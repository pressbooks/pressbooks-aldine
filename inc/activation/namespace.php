<?php
/**
 * Activate Aldine Theme
 *
 * @package Aldine
 */

namespace Aldine\Activation;

use function Aldine\Helpers\get_catalog_page;

/**
 * Create default page content, importing from Pressbooks Publisher, if possible.
 */
function create_default_content() {
	if ( ! get_option( 'pb_aldine_activated' ) ) {
		$mods = get_option( 'theme_mods_pressbooks-publisher' );
		if ( $mods === false ) {
			$mods = get_option( 'mods_pressbooks-publisher' );
		}
		if ( $mods && isset( $mods['pressbooks_publisher_intro_textbox'] ) ) {
			$home_content = apply_filters( 'the_content', $mods['pressbooks_publisher_intro_textbox'] );
		} else {
			$home_content = apply_filters(
				'pb_root_home_page_content',
				sprintf(
					'[aldine_page_section title="%1$s"]<p>%2$s</p><p>[aldine_call_to_action link="/about" text="%3$s"]</p>[/aldine_page_section]',
					__( 'About Pressbooks', 'pressbooks-aldine' ),
					__( 'Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'pressbooks-aldine' ),
					__( 'Learn More', 'pressbooks-aldine' )
				)
			);
		}

		$default_pages = [
			'about' => [
				'post_title' => __( 'About', 'pressbooks-aldine' ),
				'post_content' => apply_filters(
					'pb_root_about_page_content',
					sprintf(
						'<p>%1$s</p><p>%2$s</p><p>%3$s</p>',
						__( 'Pressbooks is simple book production software that makes it easy to write, develop, and share your ideas. You can use Pressbooks to publish open educational resources, textbooks, scholarly monographs, fiction and non-fiction books, white papers, syllabi, and more.', 'pressbooks-aldine' ),
						__( 'Pressbooks lets creators quickly publish their content to the web and produce exports in multiple formats, including accessible EPUBs and PDFs specially designed for print-on-demand or digital distribution.', 'pressbooks-aldine' ),
						sprintf(
							/* translators: %1$s: link to Pressbooks product page; %2$2: link to Pressbooks getting started page */
							__( 'Pressbooks\' %1$s are used by hundreds of educational institutions and thousands of individual authors and publishers around the world. %2$s to learn more about how you or your institution can get started with Pressbooks.', 'pressbooks' ),
							sprintf( '<a href="https://pressbooks.com/our-products/">%s</a>', __( 'suite of products', 'pressbooks-aldine' ) ),
							sprintf( '<a href="https://pressbooks.com/get-started/">%s</a>', __( 'Contact us', 'pressbooks-aldine' ) )
						)
					)
				),
			],
			'help' => [
				'post_title' => __( 'Help', 'pressbooks-aldine' ),
				'post_content' => apply_filters(
					'pb_root_help_page_content',
					sprintf(
						'<p>%1$s</p><p>%2$s</p><p>%3$s</p><p>%4$s</p><p>%5$s</p>',
						sprintf(
						/* translators: %s: link to guide */
							__( 'Are you looking for help on your Pressbooks project? The most comprehensive resource available is the %s, which contains everything you need to know about creating, enriching and exporting your work.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://guide.pressbooks.com/">%s</a>', __( 'Pressbooks User Guide', 'pressbooks-aldine' ) )
						),
						sprintf(
						/* translators: %1$s: link to Pressbooks YouTube channel; %2$s: link to Fundamental of Pressbooks YouTube playlist */
							__( 'You can find short video tutorials and webinars about features and product updates on the %1$s. If you’re just getting started with Pressbooks, this %2$s will guide you.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://www.youtube.com/c/Pressbooks">%s</a>', __( 'Pressbooks YouTube channel', 'pressbooks-aldine' ) ),
							sprintf( '<a href="https://www.youtube.com/playlist?list=PLMFmJu3NJheuRt1rZwNCEElROtSjc5dJG">%s</a>', __( 'short video series', 'pressbooks-aldine' ) )
						),
						sprintf(
						/* translators: %s: link to Pressbooks webinar schedule */
							__( 'If you learn best by learning by attending live training sessions, you can register for and attend one of Pressbooks\' %s.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://pressbooks.com/webinars/">%s</a>', __( 'monthly webinars', 'pressbooks-aldine' ) )
						),
						sprintf(
						/* translators: %1$s: link to Pressbooks support page; %2$s: link to Pressbooks community forum */
							__( 'The %1$s also contains links to other useful support resources and has answers to some commonly asked questions. Pressbooks also maintains a %2$s where you can ask and answer questions of other users.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://pressbooks.com/support/">%s</a>', __( 'Pressbooks support page', 'pressbooks-aldine' ) ),
							sprintf( '<a href="https://pressbooks.community/">%s</a>', __( 'community forum', 'pressbooks-aldine' ) )
						),
						sprintf(
						/* translators: %s: link to Pressbooks support request form */
							__( 'For additional support needs, reach out to your institution’s Pressbooks network managers. If you don’t know who your network managers are, please fill out the %s to be put in touch with them.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://pressbooks.com/pressbooksedu-support/">%s</a>', __( 'support request form', 'pressbooks-aldine' ) )
						)
					)
				),
			],
			'catalog' => [
				'post_title' => __( 'Catalog', 'pressbooks-aldine' ),
				'post_content' => '',
				'meta_input' => [
					'_wp_page_template' => 'page-catalog.php',
				],
			],
			'home' => [
				'post_title' => __( 'Home', 'pressbooks-aldine' ),
				'post_content' => $home_content,
			],
		];

		// Add our pages.
		$pages = [];

		foreach ( $default_pages as $slug => $page ) {
			$check = get_page_by_path( $slug );
			if ( empty( $check ) ) {
				$pages[ $slug ] = wp_insert_post(
					array_merge(
						$page, [
							'post_type' => 'page',
							'post_status' => 'publish',
						]
					)
				);
			} else {
				$pages[ $slug ] = $check->ID;
			}
		}

		// Set front page to Home.
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );

		// Remove content generated by wp_install_defaults.
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1, true );

		// Migrate site logo.
		if ( ! empty( $mods['custom_logo'] ) ) {
			set_theme_mod( 'custom_logo', $mods['custom_logo'] );
		}

		// Add "pb_aldine_activated" option to enable check above.
		add_option( 'pb_aldine_activated', 1 );
	}
}

/**
 * Create default primary and footer menus.
 */
function create_menus() {
	$menu_name = __( 'Primary Menu', 'pressbooks-aldine' );

	if ( ! wp_get_nav_menu_object( $menu_name ) ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		$catalog = get_catalog_page();
		if ( $catalog && defined( 'PB_PLUGIN_VERSION' ) ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				[
					'menu-item-title' => __( 'Catalog', 'pressbooks-aldine' ),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-object-id' => $catalog->ID,
					'menu-item-status' => 'publish',
				]
			);
		}
	}

	$menu_name = __( 'Footer Menu', 'pressbooks-aldine' );

	if ( ! wp_get_nav_menu_object( $menu_name ) ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		$about = get_page_by_title( __( 'About', 'pressbooks-aldine' ) );
		if ( $about ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				[
					'menu-item-title' => __( 'About', 'pressbooks-aldine' ),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-object-id' => $about->ID,
					'menu-item-status' => 'publish',
				]
			);
		}

		$catalog = get_catalog_page();
		if ( $catalog && defined( 'PB_PLUGIN_VERSION' ) ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				[
					'menu-item-title' => __( 'Catalog', 'pressbooks-aldine' ),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-object-id' => $catalog->ID,
					'menu-item-status' => 'publish',
				]
			);
		}

		$help = get_page_by_title( __( 'Help', 'pressbooks-aldine' ) );
		if ( $help ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				[
					'menu-item-title' => __( 'Help', 'pressbooks-aldine' ),
					'menu-item-type' => 'post_type',
					'menu-item-object' => 'page',
					'menu-item-object-id' => $help->ID,
					'menu-item-status' => 'publish',
				]
			);
		}
	}
}

/**
 * Check for presence of menus; if they exist, assign them to their locations.
 */
function assign_menus() {
	$locations = get_theme_mod( 'nav_menu_locations' );

	if ( ! empty( $locations ) ) {
		foreach ( $locations as $id => $value ) {
			switch ( $id ) {
				case 'primary-menu':
					$menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
					break;

				case 'network-footer-menu':
					$menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
					break;
			}

			if ( $menu ) {
				$locations[ $id ] = $menu->term_id;
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
