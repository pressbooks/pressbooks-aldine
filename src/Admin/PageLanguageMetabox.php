<?php
/**
 * Page Language Metabox
 *
 * Adds a metabox to select the language for Additional Home page templates.
 */

namespace Aldine\Admin;

/**
 * Class PageLanguageMetabox
 *
 * Manages language selection metabox and locale switching for Additional Home page templates.
 */
class PageLanguageMetabox
{
    /**
     * Supported template for language selection.
     *
     * @var string
     */
    private string $supported_template = 'page-custom-home.php';

    /**
     * Singleton instance.
     *
     * @var PageLanguageMetabox|null
     */
    private static ?PageLanguageMetabox $instance = null;

    /**
     * Initialize the metabox and hooks.
     *
     * @return PageLanguageMetabox
     */
    public static function init(): PageLanguageMetabox
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
            self::hooks(self::$instance);
        }

        return self::$instance;
    }

    /**
     * Register hooks for the metabox.
     *
     * @param PageLanguageMetabox $instance The instance of the class.
     */
    public static function hooks(PageLanguageMetabox $instance): void
    {
        if (! is_main_site()) {
            return;
        }

        add_action('add_meta_boxes', [ $instance, 'addLanguageMetabox' ]);
        add_action('save_post', [ $instance, 'saveLanguageMetabox' ]);
        add_action('template_redirect', [ $instance, 'overrideLocale' ]);
    }

    /**
     * Add the language metabox to the Additional Home page template.
     *
     * @param string $post_type Post type slug.
     */
    public function addLanguageMetabox(string $post_type): void
    {
        if ($post_type !== 'page') {
            return;
        }

        $post = get_post();
        if (! $post instanceof \WP_Post) {
            return;
        }

        $template = get_page_template_slug($post->ID);
        if ($template !== $this->supported_template) {
            return;
        }

        add_meta_box(
            'aldine_language_metabox',
            __('Page Language', 'pressbooks-aldine'),
            [ $this, 'renderLanguageSelector' ],
            'page',
            'side',
            'default'
        );
    }

    /**
     * Render the language selector metabox.
     *
     * @param \WP_Post $post Post object.
     */
    public function renderLanguageSelector(\WP_Post $post): void
    {
        $selected_lang = get_post_meta($post->ID, 'page_language', true);
        $languages = $this->getAvailableLanguages();

        ?>
		<label for="page_language"><?php _e('Select Language', 'pressbooks-aldine'); ?></label><br>
		<select name="page_language" id="page_language">
			<option value="">-- <?php _e('Choose', 'pressbooks-aldine'); ?> --</option>
			<?php foreach ($languages as $lang => $name) : ?>
				<option value="<?php echo esc_attr($lang); ?>" <?php selected($selected_lang, $lang); ?>><?php echo esc_html($name); ?></option>
			<?php endforeach; ?>
		</select>
		<?php

        wp_nonce_field('aldine_language_metabox_nonce_action', 'aldine_language_metabox_nonce');
    }

    /**
     * Save the selected language for the page.
     *
     * @param int $post_id Post ID.
     */
    public function saveLanguageMetabox(int $post_id): void
    {
        $template = get_page_template_slug($post_id);
        if ($template !== $this->supported_template) {
            return;
        }

        if (! isset($_POST['aldine_language_metabox_nonce']) ||
            ! wp_verify_nonce($_POST['aldine_language_metabox_nonce'], 'aldine_language_metabox_nonce_action')
        ) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (! current_user_can('edit_page', $post_id)) {
            return;
        }

        if (empty($_POST['page_language'])) {
            delete_post_meta($post_id, 'page_language');
            return;
        }

        $language_selected = sanitize_text_field($_POST['page_language']);

        $supported_languages = $this->getAvailableLanguages();
        if (! array_key_exists($language_selected, $supported_languages)) {
            wp_die(__('Selected language is not supported.', 'pressbooks-aldine'));
        }

        update_post_meta($post_id, 'page_language', $language_selected);
    }

    /**
     * Override locale based on selected language.
     */
    public function overrideLocale(): void
    {
        if (is_admin() || ! is_page()) {
            return;
        }

        $page_id = get_queried_object_id();
        if (! $page_id) {
            return;
        }

        $template = get_post_meta($page_id, '_wp_page_template', true);
        if ($template !== $this->supported_template) {
            return;
        }

        $lang = get_post_meta($page_id, 'page_language', true);
        if (empty($lang)) {
            return;
        }

        $available_languages = $this->getAvailableLanguages();
        if (! isset($available_languages[ $lang ])) {
            return;
        }

        $current_locale = get_locale();
        if ($lang === $current_locale) {
            return;
        }

        $this->switchToLocale($lang);
    }

    /**
     * Switch to the specified locale.
     *
     * @param string $target_locale The locale code to switch to.
     */
    private function switchToLocale(string $target_locale): void
    {
        global $locale;
        $locale = $target_locale;

        add_filter('locale', function () use ($target_locale) {
            return $target_locale;
        }, 999);

        unload_textdomain('pressbooks-aldine');

        $mo_file = get_template_directory() . '/languages/' . $target_locale . '.mo';
        if (file_exists($mo_file)) {
            load_textdomain('pressbooks-aldine', $mo_file);
        }
    }

    /**
     * Get available languages from .po files in the theme's languages directory.
     *
     * @return array Array of locale => native_name pairs.
     */
    private function getAvailableLanguages(): array
    {
        $languages = [];
        $languages_dir = get_template_directory() . '/languages/';

        if (! is_dir($languages_dir)) {
            return $languages;
        }

        $po_files = glob($languages_dir . '*.po');

        foreach ($po_files as $po_file) {
            $filename = basename($po_file, '.po');

            if ($filename === 'pressbooks-aldine') {
                continue;
            }

            $locale = $filename;
            $language_name = $this->getLanguageName($locale, $po_file);

            $languages[ $locale ] = $language_name;
        }

        asort($languages);

        return $languages;
    }

    /**
     * Get the native language name for a locale.
     *
     * @param string $locale The locale code.
     * @param string $po_file_path Path to the .po file.
     * @return string The native language name.
     */
    private function getLanguageName(string $locale, string $po_file_path): string
    {
        if (function_exists('wp_get_available_translations')) {
            $translations = wp_get_available_translations();
            if (isset($translations[ $locale ]['native_name'])) {
                return $translations[ $locale ]['native_name'];
            }
        }

        $language_name = $this->extractLanguageNameFromPo($po_file_path, $locale);
        if (! empty($language_name)) {
            return $language_name;
        }

        return $this->formatLocaleCode($locale);
    }

    /**
     * Extract language name from .po file headers.
     *
     * @param string $po_file_path Path to .po file.
     * @param string $locale Locale code.
     * @return string Language name or empty string.
     */
    private function extractLanguageNameFromPo(string $po_file_path, string $locale): string
    {
        $handle = fopen($po_file_path, 'r');
        if (! $handle) {
            return '';
        }

        $header_content = '';
        $line_count = 0;
        $in_header = false;

        $line = fgets($handle);
        while ($line !== false && $line_count < 50) {
            $line_count++;

            if (strpos($line, 'msgstr ""') !== false) {
                $in_header = true;
                $line = fgets($handle);
                continue;
            }

            if ($in_header && (strpos($line, 'msgid') !== false && $line_count > 10)) {
                break;
            }

            if ($in_header) {
                $header_content .= $line;
            }

            $line = fgets($handle);
        }
        fclose($handle);

        if (preg_match('/"Language-Team:\s*(.+?)(?:\s*\(https?:\/\/[^)]+\))?\s*\\\\n"/', $header_content, $matches)) {
            $language_name = trim($matches[1]);
            if (! empty($language_name) && $language_name !== $locale) {
                return $language_name;
            }
        }

        return '';
    }

    /**
     * Format a locale code into a readable string.
     *
     * @param string $locale The locale code.
     * @return string Formatted language name.
     */
    private function formatLocaleCode(string $locale): string
    {
        $parts = explode('_', $locale);
        $language_part = $parts[0];
        $country_part = isset($parts[1]) ? $parts[1] : '';

        if (! empty($country_part)) {
            return ucfirst($language_part) . ' (' . $country_part . ')';
        }

        return ucfirst($language_part);
    }
}
