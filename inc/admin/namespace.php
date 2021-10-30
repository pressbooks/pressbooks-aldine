<?php
/**
 * Aldine admin
 *
 * @package Aldine
 */

namespace Aldine\Admin;

use PressbooksMix\Assets;
use Pressbooks\Admin\Network\SharingAndPrivacyOptions;
use Pressbooks\BookDirectory;
use Pressbooks\DataCollector\Book as BookDataCollector;

/**
 * Uses old option to provide a simpler upgrade path from pressbooks-publisher theme
 */
const BLOG_OPTION = 'pressbooks_publisher_in_catalog';

/**
 * Load admin scripts
 *
 * @param string $hook Hook
 */
function admin_scripts( $hook ) {
	if ( 'sites.php' !== $hook ) {
		return;
	}

	$assets = new Assets( 'pressbooks-aldine', 'theme' );
	$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );
	wp_enqueue_script( 'pressbooks-aldine-admin', $assets->getPath( 'scripts/catalog-admin.js' ), [ 'jquery' ] );

	wp_localize_script(
		'pressbooks-aldine-admin', 'PB_Aldine_Admin', [
			'aldineAdminNonce' => wp_create_nonce( 'pressbooks-aldine-admin' ),
			'catalog_updated' => __( 'Catalog updated.', 'pressbooks-aldine' ),
			'catalog_not_updated' => __( 'Sorry, but your catalog was not updated. Please try again.', 'pressbooks-aldine' ),
			'dismiss_notice' => __( 'Dismiss this notice.', 'pressbooks-aldine' ),
		]
	);
}

/**
 * Update catalog
 */
function update_catalog() {
	if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
		return;
	}
	if ( isset( $_POST['book_id'] ) ) {
		$blog_id = absint( $_POST['book_id'] );
	}
	if ( isset( $_POST['in_catalog'] ) ) {
		$in_catalog = wp_unslash( $_POST['in_catalog'] );
		if ( $in_catalog === 'true' ) {
			update_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION, 1 );
			update_site_meta( $blog_id, BookDataCollector::IN_CATALOG, 1 );
		} else {
			delete_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION );
		}
	}
	update_site_meta( $blog_id, BookDataCollector::IN_CATALOG, 0 );
	// Exclude book when network option book directory non-catalog exclude is enabled.
	$option = get_site_option( 'pressbooks_sharingandprivacy_options', [], true );
	if (
		isset( $option[ SharingAndPrivacyOptions::NETWORK_DIRECTORY_EXCLUDED ] ) &&
		( (bool) $option[ SharingAndPrivacyOptions::NETWORK_DIRECTORY_EXCLUDED ] === true )
	) {
		BookDirectory::init()->deleteBookFromDirectory( [ $blog_id ] );
	}
	update_blog_details( $blog_id, [ 'last_updated' => current_time( 'mysql', true ) ] );
}

/**
 * Catalog columns
 *
 * @param array $columns Columns
 *
 * @return array
 */
function catalog_columns( $columns ) {
	$columns['in_catalog'] = __( 'In Catalog', 'pressbooks-aldine' );
	return $columns;
}

/**
 * Catalog column
 *
 * @param string $column Column
 * @param int $blog_id Blog ID
 */
function catalog_column( $column, $blog_id ) {

	if ( 'in_catalog' === $column && ! is_main_site( $blog_id ) ) { ?>
		<input class="in-catalog" type="checkbox" name="in_catalog" value="1" aria-label="<?php echo esc_attr_x( 'Show in Catalog', 'pressbooks-aldine' ); ?>" <?php checked( get_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION ), 1 ); ?> <?php
		if ( ! get_blog_option( $blog_id, 'blog_public' ) ) {

			?>
		disabled="disabled" title="<?php echo esc_attr_x( 'This book is private, so you can&rsquo;t display it in your catalog.', 'pressbooks-aldine' ); ?>"<?php } ?> />
		<?php
	}

}
