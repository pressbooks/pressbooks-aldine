<?php

/**
 * @package Aldine
 */

namespace Aldine\Activation;

/**
 * Create starter content, importing from Pressbooks Publisher, if possible.
 *
 * @return array
 */
function get_starter_posts() {
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
			'post_type' => 'page',
			'comment_status' => 'closed',
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
			'post_type' => 'page',
			'comment_status' => 'closed',
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
			'post_type' => 'page',
			'comment_status' => 'closed',
			'post_title' => __( 'Catalog', 'pressbooks-aldine' ),
			'post_content' => '',
		],
		'home' => [
			'post_type' => 'page',
			'comment_status' => 'closed',
			'post_title' => __( 'Home', 'pressbooks-aldine' ),
			'post_content' => sprintf(
				'<div class="page-section">%s</div>',
				$home_content
			),
		],
	];

	return $default_pages;
}

/**
 * Create default primary and footer menus.
 *
 * @return array
 */
function get_starter_nav_menus() {
	$default_menus = [
		'primary-menu' => [
			'name' => __( 'Primary Menu', 'pressbooks-aldine' ),
			'items' => [
				'page_catalog' => [
					'title' => __( 'Catalog', 'pressbooks-aldine' ),
					'type' => 'post_type',
					'object' => 'page',
					'object_id' => '{{catalog}}',
				],
			],
		],
		'network-footer-menu' => [
			'name' => __( 'Footer Menu', 'pressbooks-aldine' ),
			'items' => [
				'page_about' => [
					'title' => __( 'About', 'pressbooks-aldine' ),
					'type' => 'post_type',
					'object' => 'page',
					'object_id' => '{{about}}',
				],
				'page_catalog' => [
					'title' => __( 'Catalog', 'pressbooks-aldine' ),
					'type' => 'post_type',
					'object' => 'page',
					'object_id' => '{{catalog}}',
				],
				'page_help' => [
					'title' => __( 'Help', 'pressbooks-aldine' ),
					'type' => 'post_type',
					'object' => 'page',
					'object_id' => '{{help}}',
				],
			],
		],
	];

	return $default_menus;
}
