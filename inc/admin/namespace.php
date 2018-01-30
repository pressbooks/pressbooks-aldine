<?php
/**
 * @package Aldine
 */

namespace Aldine\Admin;

use PressbooksMix\Assets;

/**
 * Uses old option to provide a simpler upgrade path from pressbooks-publisher theme
 */
const BLOG_OPTION = 'pressbooks_publisher_in_catalog';

/**
 * @param string $hook
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
 *
 */
function update_catalog() {
	if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
		return;
	}

	$blog_id = absint( $_POST['book_id'] );
	$in_catalog = $_POST['in_catalog'];

	if ( $in_catalog === 'true' ) {
		update_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION, 1 );
	} else {
		delete_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION );
	}
}

/**
 * @param array $columns
 *
 * @return array
 */
function catalog_columns( $columns ) {
	$columns['in_catalog'] = __( 'In Catalog', 'pressbooks-aldine' );
	return $columns;
}

/**
 * @param string $column
 * @param int $blog_id
 */
function catalog_column( $column, $blog_id ) {

	if ( 'in_catalog' === $column && ! is_main_site( $blog_id ) ) { ?>
		<input class="in-catalog" type="checkbox" name="in_catalog" value="1" aria-label="<?php echo esc_attr_x( 'Show in Catalog', 'pressbooks-aldine' ); ?>" <?php checked( get_blog_option( $blog_id, \Aldine\Admin\BLOG_OPTION ), 1 ); ?> <?php
		if ( ! get_blog_option( $blog_id, 'blog_public' ) ) { ?>disabled="disabled" title="<?php echo esc_attr_x( 'This book is private, so you can&rsquo;t display it in your catalog.', 'pressbooks-aldine' ); ?>"<?php } ?> />
	<?php }

}
