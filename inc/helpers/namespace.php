<?php
/**
 * Aldine Helpers
 *
 * @package Aldine
 */

namespace Aldine\Helpers;

use const Aldine\Customizer\MAX_FEATURED_BOOKS;
use function Pressbooks\Metadata\get_institutions_flattened;
use function \Pressbooks\Metadata\book_information_to_schema;
use function \Pressbooks\Metadata\is_bisac;
use function \Pressbooks\Utility\str_starts_with;
use Pressbooks\DataCollector\Book as BookDataCollector;
use Pressbooks\Licensing;

/**
 * Get all the books in the catalog
 *
 * @return array[]
 */
function get_catalog_options(): array {

	$dc = BookDataCollector::init();
	/**
	 * Filter the WP_Site_Query args for the catalog display.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters(
		'pb_aldine_catalog_query_args',
		/**
		 * Deprecation notice
		 *
		 * @deprecated 1.0.0
		 *
		 * @see Pressbooks Publisher
		 */
		apply_filters(
			'pb_publisher_catalog_query_args',
			[
				'number' => 1000000,
				'meta_key' => $dc::IN_CATALOG, // @codingStandardsIgnoreLine
				'meta_value' => 1, // @codingStandardsIgnoreLine
				'public' => 1,
				'archived' => 0,
				'spam' => 0,
				'deleted' => 0,
				'network_id' => get_network()->site_id,
			]
		)
	);
	return get_catalog_data( $args );
}

/**
 * Get featured books
 *
 * @return array
 */
function get_featured_books(): array {

	$featured_books = [];

	foreach ( range( 1, MAX_FEATURED_BOOKS ) as $book ) {
		$book = get_option( 'pb_front_page_catalog_book_' . $book );
		if ( $book ) {
			$featured_books[] = $book;
		}
	}

	if ( empty( $featured_books ) ) {
		return [];
	}

	$args = [
		'site__in'      => $featured_books,
		'sort_by_featured' => true,
	];

	return get_catalog_data( $args );
}

/**
 * Get catalog data
 *
 * @param  array $args Query arguments
 * @return array[]
 */
function get_catalog_data( array $args ): array {
	$dc = BookDataCollector::init();
	/**
	 * WordPress site
	 *
	 * @var \WP_Site $site
	 */

	$sites_in_catalog = [];
	$sites = get_sites( $args );
	foreach ( $sites as $site ) {
		$site->pb_title = $dc->get( $site->blog_id, $dc::TITLE );
		$sites_in_catalog[] = $site;
	}
	$books = [];
	foreach ( $sites_in_catalog as $site ) {
		$book_information = $dc->get( $site->blog_id, $dc::BOOK_INFORMATION_ARRAY );
		if ( is_array( $book_information ) && ! empty( $book_information ) ) {
			$schema = book_information_to_schema( $book_information );
			$book['title'] = $schema['name'];
			$book['id'] = $site->blog_id;
			$book['link'] = get_blogaddress_by_id( $site->blog_id );
			$book['metadata'] = $schema;
			$books[] = $book;
		}
	}
	// Sort by featured books.
	if ( isset( $args['sort_by_featured'] ) ) {
		usort( $books, function ( $a, $b ) use ( $args ) {
			return array_search( $a['id'], $args['site__in'], true ) - array_search($b['id'],
			$args['site__in'], true);
		} );
	}

	return [
		'books' => $books,
	];
}

/**
 * Get paginated catalog data
 *
 * @param int $page Catalog page
 * @param int $per_page Books per page
 * @param string $orderby Sort order
 * @param string $license Copyright license
 * @param string $subject Subject
 *
 * @return array
 */
function get_paginated_catalog_data( $page = 1, $per_page = 10, $orderby = 'title', $license = '', $subject = '' ) {

	if ( ! defined( 'PB_PLUGIN_VERSION' ) ) {
		return [
			'pages' => 0,
			'books' => [],
		];
	}

	$dc = BookDataCollector::init();

	/**
	 * Filter the WP_Site_Query args for the catalog display.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters(
		'pb_aldine_catalog_query_args',
		/**
		 * Deprecation notice
		 *
		 * @deprecated 1.0.0
		 *
		 * @see Pressbooks Publisher
		 */
		apply_filters(
			'pb_publisher_catalog_query_args',
			[
				'number' => 1000000,
				'meta_key' => $dc::IN_CATALOG, // @codingStandardsIgnoreLine
				'meta_value' => 1, // @codingStandardsIgnoreLine
				'public' => 1,
				'archived' => 0,
				'spam' => 0,
				'deleted' => 0,
				'network_id' => get_network()->site_id,
			]
		)
	);

	/**
	 * WordPress site
	 *
	 * @var \WP_Site $site
	 */

	$sites_in_catalog = [];
	$sites = get_sites( $args );
	foreach ( $sites as $site ) {
		$site->pb_title = $dc->get( $site->blog_id, $dc::TITLE );
		$sites_in_catalog[] = $site;
	}
	if ( $orderby === 'latest' ) {
		$sites_in_catalog = wp_list_sort( $sites_in_catalog, 'last_updated', 'DESC' );
	} else {
		$sites_in_catalog = wp_list_sort( $sites_in_catalog, 'pb_title', 'ASC' );
	}

	$total_pages = ceil( count( $sites_in_catalog ) / $per_page );
	$offset = ( $page - 1 ) * $per_page;
	$books = [];
	foreach ( $sites_in_catalog as $i => $site ) {
		if ( $i < $offset ) {
			continue;
		}

		$book_information = $dc->get( $site->blog_id, $dc::BOOK_INFORMATION_ARRAY );
		if ( is_array( $book_information ) && ! empty( $book_information ) ) {
			$schema = book_information_to_schema( $book_information );
			$book['title'] = $schema['name'];
			$book['date-published'] = $schema['datePublished'] ?? '';
			$book['subject'] = $schema['about'][0]['identifier'] ?? '';
			$book['link'] = get_blogaddress_by_id( $site->blog_id );
			$book['metadata'] = $schema;
			$books[] = $book;
		}

		if ( count( $books ) >= $per_page ) {
			break;
		}
	}

	return [
		'pages' => $total_pages,
		'books' => $books,
	];
}

/**
 * Get licenses for catalog display.
 *
 * @return array
 */
function get_catalog_licenses() {
	if ( defined( 'PB_PLUGIN_VERSION' ) ) {
		$licenses = ( new Licensing() )->getSupportedTypes();
		foreach ( $licenses as $key => $value ) {
			$licenses[ $key ] = preg_replace( '/\([^)]+\)/', '', $value['desc'] );
		}
		return $licenses;
	}
	return [];
}

/**
 * Get licenses currently in use.
 *
 * @param array $catalog_data Catalog data
 *
 * @return array
 */
function get_available_licenses( $catalog_data ) {
	$licenses = [];
	$licensing = new Licensing();

	foreach ( $catalog_data['books'] as $book ) {
		$license = $licensing->getLicenseFromUrl( $book['metadata']['license']['url'] );
		if ( ! in_array( $license, $licenses, true ) ) {
			$licenses[] = $license;
		}
	}

	return $licenses;
}

/**
 * Get institutions for catalog display.
 *
 * @return array
 */
function get_institutions(): array {
	if ( ! defined( 'PB_PLUGIN_VERSION' ) ) {
		return [];
	}

	return get_institutions_flattened();
}

/**
 * Get institutions currently in use.
 *
 * @param array $catalog_data Catalog data
 *
 * @return array
 */
function get_available_institutions( array $catalog_data ): array {
	$institution_list = get_institutions();
	$book_institutions = array_reduce( $catalog_data['books'], static function( $carry, $book ) {
		$names = array_reduce( $book['metadata']['institutions'] ?? [], static function( $carry, $institution ) {
			return array_merge( $carry, [ $institution['name'] ] );
		}, [] );

		return array_merge( $carry, $names );
	}, [] );

	return array_intersect( $institution_list, $book_institutions );
}

/**
 * Get subjects currently in use.
 *
 * @param array $catalog_data Catalog data
 *
 * @return array
 */
function get_available_subjects( $catalog_data ) {
	$subjects = [];
	foreach ( $catalog_data['books'] as $book ) {
		if ( ! empty( $book['subject'] ) && ! is_bisac( $book['subject'] ) ) {
			$subjects[ substr( $book['subject'], 0, 1 ) ][] = substr( $book['subject'], 0, 2 );
		}
	}

	return $subjects;
}

/**
 * Return the default (non-page) menu items.
 *
 * @param string $items Items
 *
 * @return string $items
 */
function get_default_menu( $items = '' ) {
	$item_classes = [
		'prefix' => 'nav--primary-item',
		'Home' => 'home',
		'Contact' => 'contact',
		'SignIn' => 'sign-in',
		'SignUp' => 'sign-up',
		'Admin' => 'admin',
		'CreateANewBook' => 'create-book',
		'MyBooks' => 'my-books',
		'SignOut' => 'sign-out',
	];

	$link = network_home_url( '/' );
	$items = sprintf(
		'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
		$link,
		__( 'Home', 'pressbooks-aldine' ),
		$item_classes['prefix'],
		$item_classes['Home']
	) . $items;
	if ( get_option( 'pb_network_contact_form' ) ) {
		$items .= sprintf(
			'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
			'#contact',
			__( 'Contact', 'pressbooks-aldine' ),
			$item_classes['prefix'],
			$item_classes['Contact']
		);
	}
	if ( ! is_user_logged_in() ) {
		$items .= sprintf(
			'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
			wp_login_url( admin_url( 'index.php?page=pb_home_page' ) ),
			__( 'Sign In', 'pressbooks-aldine' ),
			$item_classes['prefix'],
			$item_classes['SignIn']
		);
		if ( in_array( get_site_option( 'registration' ), [ 'user', 'all' ], true ) ) {
			$items .= sprintf(
				'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
				network_home_url( '/wp-signup.php' ),
				__( 'Sign Up', 'pressbooks-aldine' ),
				$item_classes['prefix'],
				$item_classes['SignUp']
			);
		}
	} else {
		if ( is_super_admin() || is_user_member_of_blog() ) {
			$items .= sprintf(
				'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
				admin_url(),
				__( 'Admin', 'pressbooks-aldine' ),
				$item_classes['prefix'],
				$item_classes['Admin']
			);
		} else {
			$items .= sprintf(
				'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
				user_admin_url(),
				__( 'Admin', 'pressbooks-aldine' ),
				$item_classes['prefix'],
				$item_classes['Admin']
			);
		}
		$user_info = get_userdata( get_current_user_id() );
		if ( $user_info->primary_blog ) {
			$items .= sprintf(
				'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
				get_blogaddress_by_id( $user_info->primary_blog ) . 'wp-admin/index.php?page=pb_catalog',
				__( 'My Books', 'pressbooks-aldine' ),
				$item_classes['prefix'],
				$item_classes['MyBooks']
			);
		} elseif ( in_array( get_site_option( 'registration' ), [ 'blog', 'all' ], true ) ) {
			$items .= sprintf(
				'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
				network_home_url( '/wp-signup.php' ),
				__( 'Create a New Book', 'pressbooks-aldine' ),
				$item_classes['prefix'],
				$item_classes['CreateANewBook']
			);
		}
		$items .= sprintf(
			'<li class="%3$s %3$s-%4$s"><a href="%1$s">%2$s</a></li>',
			wp_logout_url( get_permalink() ),
			__( 'Sign Out', 'pressbooks-aldine' ),
			$item_classes['prefix'],
			$item_classes['SignOut']
		);
	}
	/* @codingStandardsIgnoreStart $items .= sprintf(
	 * '<li class="header__search js-search"><div class="header__search__form">%s</div></li>',
	 * get_search_form( false )
	 * ); @codingStandardsIgnoreEnd
	 */

	return $items;
}

/**
 * Echo the default menu.
 *
 * @param array $args Array
 * @param string $items Items
 */
function default_menu( $args = [], $items = '' ) {
	printf(
		"<{$args['container']} id='{$args['container_id']}' class='{$args['container_class']}' aria-label='{$args['container_aria_label']}'><ul id='{$args['menu_id']}' class='{$args['menu_class']}'>%s</ul></{$args['container']}>",
		get_default_menu( $items )
	);
	if ( class_exists( '\PressbooksOAuth\OAuth' ) ) {
		add_filter(
			'pb_oauth_output_button', function( $bool ) {
				return false;
			}
		);
		do_action( 'pressbooks_oauth_connect' );
	}
}

/**
 *
 * Handler for contact form submissions.
 *
 * @return false | array
 */
function handle_contact_form_submission() {
	if ( ! isset( $_POST['pb_root_contact_form_nonce'] ) || ! wp_verify_nonce( $_POST['pb_root_contact_form_nonce'], 'pb_root_contact_form' ) ) {
		return false; // Security check failed.
	}
	if ( isset( $_POST['submitted'] ) ) {
		// Check the fake anti-spam honeypot field.
		foreach ( $_POST as $pkey => $pval ) {
			if ( str_starts_with( $pkey, 'firstname' ) && ! empty( $pval ) ) {
				return false; // Honeypot failed.
			}
		}
		$contact_email = get_option( 'pb_network_contact_email', get_option( 'admin_email' ) );
		$output = [];
		$name = ( isset( $_POST['visitor_name'] ) ) ? $_POST['visitor_name'] : '';
		$email = ( isset( $_POST['visitor_email'] ) ) ? $_POST['visitor_email'] : '';
		$institution = ( isset( $_POST['visitor_institution'] ) ) ? $_POST['visitor_institution'] : '';
		$message = ( isset( $_POST['message'] ) ) ? $_POST['message'] : '';
		$output['values'] = [
			'visitor_name' => esc_attr( $name ),
			'visitor_email' => sanitize_email( $email ),
			'visitor_institution' => esc_attr( $institution ),
			'message' => esc_textarea( $message ),
		];
		if ( empty( $name ) ) {
			$output['message'] = __( 'Name is required.', 'pressbooks-aldine' );
			$output['status'] = 'error';
			$output['field'] = 'visitor_name';
		} elseif ( empty( $email ) ) {
			$output['message'] = __( 'Email is required.', 'pressbooks-aldine' );
			$output['status'] = 'error';
			$output['field'] = 'visitor_email';
		} elseif ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$output['message'] = __( 'Email is invalid.', 'pressbooks-aldine' );
			$output['status'] = 'error';
			$output['field'] = 'visitor_email';
		} elseif ( empty( $institution ) ) {
			$output['message'] = __( 'Institution is required.', 'pressbooks-aldine' );
			$output['status'] = 'error';
			$output['field'] = 'visitor_institution';
		} elseif ( empty( $message ) ) {
			$output['message'] = __( 'Message is required.', 'pressbooks-aldine' );
			$output['status'] = 'error';
			$output['field'] = 'message';
		} else {
			$sent = wp_mail(
				$contact_email,
				/* translators: %s name of contact for submitter */
				sprintf( __( 'Contact Form Submission from %s', 'pressbooks-aldine' ), $name ),
				sprintf(
					"From: %1\$s <%2\$s>\nInstitution: %3\$s\n\n%4\$s",
					stripslashes( $name ),
					$email,
					stripslashes( $institution ),
					wp_strip_all_tags( $message )
				),
				"From: ${email}\r\nReply-To: ${email}\r\n"
			);
			if ( $sent ) {
				$output['message'] = __( 'Your message was sent!', 'pressbooks-aldine' );
				$output['status'] = 'success';
			} else {
				$output['message'] = __( 'Your message could not be sent.', 'pressbooks-aldine' );
				$output['status'] = 'error';
			}
		}
		return $output;
	}
	return false;
}

/**
 * Does a page have page sections?
 *
 * @param int $post_id The page.
 *
 * @return bool
 */
function has_sections( $post_id ) {
	$post_content = get_post_field( 'post_content', $post_id );
	if ( ! empty( $post_content ) ) {
		if ( strpos( $post_content, 'page-section' ) || strpos( $post_content, 'aldine_page_section' ) ) {
			return true;
		} else {
			return false;
		}
	}

	return false;
}

/**
 * Maybe truncate a string to a sensible length.
 *
 * @param string $string The string.
 * @param int $length Max length in characters.
 *
 * @return string
 */
function maybe_truncate_string( $string, $length = 40 ) {
	if ( strlen( $string ) > $length ) {
		return substr( $string, 0, strpos( wordwrap( $string, $length ), "\n" ) ) . '&hellip;';
	}
	return $string;
}

/**
 * Get catalog page.
 *
 * @return WP_Post|null
 */
function get_catalog_page(): ?\WP_Post {
	$catalog_pages = get_pages( [
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-catalog.php', //phpcs:ignore HM.Performance.SlowMetaQuery.slow_query_meta_value
	]);
	return $catalog_pages[0] ?? null;
}

/**
 * This function generate a class to know if the current page is a custom frontpage.
 *
 * @return string
 */
function custom_homepage(): string {
	$home_page = get_option( 'page_on_front' );
	if ( $home_page ) {
		$template = get_page_template_slug( $home_page );
		if ( 'page-catalog.php' === $template ) {
			return 'custom-homepage';
		}
	}
	return '';
}
