<?php

/**
 * @package Aldine
 */

namespace Aldine\Activation;

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
					'<h2>%1$s</h2><p>%2$s</p><p><a class="call-to-action" href="/about/">%3$s</a></p>',
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
						'<p>%1$s</p><ul><li>%2$s</li><li>%3$s</li><li>%4$s</li></ul><p>%5$s</p><p>%6$s</p>',
						__( 'Pressbooks is simple book production software. You can use Pressbooks to publish textbooks, scholarly monographs, syllabi, fiction and non-fiction books, white papers, and more in multiple formats including:', 'pressbooks-aldine' ),
						__( 'MOBI (for Kindle ebooks)', 'pressbooks-aldine' ),
						__( 'EPUB (for all other ebookstores)', 'pressbooks-aldine' ),
						__( 'designed PDF (for print-on-demand and digital distribution)', 'pressbooks-aldine' ),
						__( 'Pressbooks is used by educational institutions around the world as well as authors and publishers.', 'pressbooks' ),
						sprintf(
							__( 'For more information about Pressbooks, %s.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://pressbooks.com/about">%s</a>', __( 'see here', 'pressbooks-aldine' ) )
						)
					)
				),
			],
			'help' => [
				'post_title' => __( 'Help', 'pressbooks-aldine' ),
				'post_content' => apply_filters(
					'pb_root_help_page_content',
					sprintf(
						'<p>%1$s</p><p>%2$s</p>',
						sprintf(
							__( 'The easiest way to get started with Pressbooks is to follow our %1$s. Or, you can review our %2$s.', 'pressbooks-aldine' ),
							sprintf( '<a href="https://pressbooks.com/how-to-make-a-book-with-pressbooks">%s</a>', __( '4 Step Guide to Making a Book on Pressbooks', 'pressbooks-aldine' ) ),
							sprintf( '<a href="https://guide.pressbooks.com/">%s</a>', __( 'Guide to Using Pressbooks', 'pressbooks-aldine' ) )
						),
						__( 'If you require further assistance, please contact your network manager.', 'pressbooks-aldine' )
					)
				),
			],
			'catalog' => [
				'post_title' => __( 'Catalog', 'pressbooks-aldine' ),
				'post_content' => '',
			],
			'home' => [
				'post_title' => __( 'Home', 'pressbooks-aldine' ),
				'post_content' => sprintf(
					'<div class="page-section">%s</div>',
					$home_content
				),
			],
		];

		// Add our pages
		$pages = [];

		foreach ( $default_pages as $slug => $page ) {
			$check = get_page_by_path( $slug );
			if ( empty( $check ) ) {
				$pages[ $slug ] = wp_insert_post( array_merge( $page, [ 'post_type' => 'page', 'post_status' => 'publish' ] ) );
			} else {
				$pages[ $slug ] = $check->ID;
			}
		}

		// Set front page to Home
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );

		// Remove content generated by wp_install_defaults
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1, true );

		// Add "pb_aldine_activated" option to enable check above
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

		$catalog = get_page_by_title( __( 'Catalog', 'pressbooks-aldine' ) );
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

		$catalog = get_page_by_title( __( 'Catalog', 'pressbooks-aldine' ) );
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
