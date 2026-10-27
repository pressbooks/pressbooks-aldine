<?php
/**
 * Aldine admin
 *
 * @package Aldine
 */

namespace Aldine\Admin;

use PressbooksFrontendTools\Assets;
use PressbooksFrontendTools\AssetType;
use Pressbooks\Admin\Network\SharingAndPrivacyOptions;
use Pressbooks\BookDirectory;
use Pressbooks\DataCollector\Book as BookDataCollector;

class Catalog
{
    public const BULK_ADD = 'pb_aldine_add_to_catalog';

    public const BULK_REMOVE = 'pb_aldine_remove_from_catalog';

    /**
     * Load admin scripts
     *
     * @param string $hook Hook
     */
    public static function adminScripts($hook)
    {
        if ('sites.php' !== $hook) {
            return;
        }

        $assets = new Assets('pressbooks-aldine', AssetType::THEME);
        $assets->enqueue('assets/scripts/catalog-admin.js', 'pressbooks-aldine-admin', [
            'dependencies' => [ 'jquery' ],
        ]);

        wp_localize_script(
            'pressbooks-aldine-admin',
            'PB_Aldine_Admin',
            [
                'aldineAdminNonce' => wp_create_nonce('pressbooks-aldine-admin'),
                'catalog_updated' => __('Catalog updated.', 'pressbooks-aldine'),
                'catalog_not_updated' => __('Sorry, but your catalog was not updated. Please try again.', 'pressbooks-aldine'),
                'dismiss_notice' => __('Dismiss this notice.', 'pressbooks-aldine'),
            ]
        );
    }

    /**
     * Update catalog
     */
    public static function updateCatalog()
    {
        if (! current_user_can('manage_network') || ! check_ajax_referer('pressbooks-aldine-admin')) {
            return;
        }

        $blog_id = isset($_POST['book_id']) ? absint($_POST['book_id']) : 0;
        if (! $blog_id) {
            wp_send_json_error(__('Missing book ID.', 'pressbooks-aldine'), 400);
        }

        $in_catalog = isset($_POST['in_catalog']) && wp_unslash($_POST['in_catalog']) === 'true';

        if (! self::setCatalogStatus($blog_id, $in_catalog)) {
            wp_send_json_error(__('The book could not be updated.', 'pressbooks-aldine'), 400);
        }

        wp_send_json_success();
    }

    /**
     * Add or remove a book from the network catalog.
     *
     * @param int $blog_id Blog ID
     * @param bool $in_catalog Whether the book should be in the catalog
     * @return bool True when updated, false when skipped
     */
    public static function setCatalogStatus(int $blog_id, bool $in_catalog): bool
    {
        if (! $blog_id || is_main_site($blog_id)) {
            return false;
        }

        if ($in_catalog) {
            if (! get_blog_option($blog_id, 'blog_public')) {
                return false;
            }

            update_blog_option($blog_id, BLOG_OPTION, 1);
            update_site_meta($blog_id, BookDataCollector::IN_CATALOG, 1);
        } else {
            delete_blog_option($blog_id, BLOG_OPTION);
            update_site_meta($blog_id, BookDataCollector::IN_CATALOG, 0);

            // Exclude from the directory when the network option is enabled.
            $option = get_site_option('pressbooks_sharingandprivacy_options', [], true);
            if (
                isset($option[SharingAndPrivacyOptions::NETWORK_DIRECTORY_EXCLUDED]) &&
                ((bool) $option[SharingAndPrivacyOptions::NETWORK_DIRECTORY_EXCLUDED] === true)
            ) {
                BookDirectory::init()->deleteBookFromDirectory([$blog_id]);
            }
        }

        update_blog_details($blog_id, ['last_updated' => current_time('mysql', true)]);

        return true;
    }

    /**
     * Register catalog bulk actions.
     *
     * @param array $actions Bulk actions
     * @return array
     */
    public static function bulkActions($actions)
    {
        $actions[self::BULK_ADD] = __('Add to catalog', 'pressbooks-aldine');
        $actions[self::BULK_REMOVE] = __('Remove from catalog', 'pressbooks-aldine');

        return $actions;
    }

    /**
     * Handle catalog bulk actions.
     *
     * @param string $redirect_to Redirect URL
     * @param string $action Current bulk action
     * @param array $blog_ids Selected blog IDs
     * @return string
     */
    public static function handleBulkActions($redirect_to, $action, $blog_ids)
    {
        if (! in_array($action, [self::BULK_ADD, self::BULK_REMOVE], true)) {
            return $redirect_to;
        }

        $in_catalog = $action === self::BULK_ADD;
        $updated = 0;
        $skipped = 0;

        foreach ((array) $blog_ids as $blog_id) {
            $blog_id = absint($blog_id);

            if (! $blog_id || is_main_site($blog_id)) {
                continue;
            }

            if (self::setCatalogStatus($blog_id, $in_catalog)) {
                $updated++;
            } else {
                $skipped++;
            }
        }

        return add_query_arg(
            [
                'pb_aldine_catalog_action' => $in_catalog ? 'added' : 'removed',
                'pb_aldine_catalog_updated' => $updated,
                'pb_aldine_catalog_skipped' => $skipped,
            ],
            $redirect_to
        );
    }

    /**
     * Display catalog bulk action results.
     */
    public static function bulkActionNotice()
    {
        if (! isset($_GET['pb_aldine_catalog_action'], $_GET['pb_aldine_catalog_updated'])) {
            return;
        }

        $action = sanitize_key(wp_unslash($_GET['pb_aldine_catalog_action']));
        $updated = absint($_GET['pb_aldine_catalog_updated']);
        $skipped = isset($_GET['pb_aldine_catalog_skipped']) ? absint($_GET['pb_aldine_catalog_skipped']) : 0;

        if ($action === 'added') {
            $message = sprintf(
                _n('%s book added to the catalog.', '%s books added to the catalog.', $updated, 'pressbooks-aldine'),
                number_format_i18n($updated)
            );
        } elseif ($action === 'removed') {
            $message = sprintf(
                _n('%s book removed from the catalog.', '%s books removed from the catalog.', $updated, 'pressbooks-aldine'),
                number_format_i18n($updated)
            );
        } else {
            return;
        }

        if ($skipped > 0) {
            $message .= ' '.sprintf(
                _n('%s private book was skipped.', '%s private books were skipped.', $skipped, 'pressbooks-aldine'),
                number_format_i18n($skipped)
            );
        }

        printf(
            '<div class="notice %s is-dismissible"><p>%s</p></div>',
            $updated > 0 ? 'notice-success' : 'notice-warning',
            esc_html($message)
        );
    }

    /**
     * Catalog columns
     *
     * @param array $columns Columns
     *
     * @return array
     */
    public static function catalogColumns($columns)
    {
        $columns['in_catalog'] = __('In Catalog', 'pressbooks-aldine');
        return $columns;
    }

    /**
     * Catalog column
     *
     * @param string $column Column
     * @param int $blog_id Blog ID
     */
    public static function catalogColumn($column, $blog_id)
    {

        if ('in_catalog' === $column && ! is_main_site($blog_id)) { ?>
    		<input class="in-catalog" type="checkbox" name="in_catalog" value="1" aria-label="<?php echo esc_attr__('Show in Catalog', 'pressbooks-aldine'); ?>" <?php checked(get_blog_option($blog_id, \Aldine\Admin\BLOG_OPTION), 1); ?>
    		<?php
            if (! get_blog_option($blog_id, 'blog_public')) {

                ?>
    		disabled="disabled" title="<?php echo esc_attr__('This book is private, so you can&rsquo;t display it in your catalog.', 'pressbooks-aldine'); ?>"<?php } ?> />
    		<?php
        }

    }
}
