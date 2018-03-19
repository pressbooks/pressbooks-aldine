<?php
/**
 * Aldine Helpers
 *
 * @package Aldine
 */

namespace Aldine\Helpers;

use Pressbooks\Book;
use function \Pressbooks\Metadata\book_information_to_schema;

/**
 * @param int $page
 * @param int $per_page
 * @param string $orderby
 * @param string $license
 * @param string $subject
 *
 * @return array
 */
function get_catalog_data( $page = 1, $per_page = 10, $orderby = 'title', $license = '', $subject = '' ) {

	if ( ! defined( 'PB_PLUGIN_VERSION' ) ) {
		return [ 'pages' => 0, 'books' => [] ]; // Bail
	}

	/**
	 * Filter the WP_Site_Query args for the catalog display.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters(
		'pb_aldine_catalog_query_args',
		/**
		 * @deprecated 1.0.0
		 *
		 * @see Pressbooks Publisher
		 */
		apply_filters(
			'pb_publisher_catalog_query_args',
			[
				'public' => 1,
				'archived' => 0,
				'spam' => 0,
				'deleted' => 0,
				'network_id' => get_network()->site_id,
			]
		)
	);

	/** @var \WP_Site $site */

	$sites_in_catalog = [];
	$sites = new \WP_Site_Query( $args );
	foreach ( $sites->sites as $site ) {
		// TODO: Using switch_to_blog() is a performance problem. Use [ https://core.trac.wordpress.org/ticket/37923 ] when available.
		switch_to_blog( $site->blog_id );
		if ( get_option( \Aldine\Admin\BLOG_OPTION ) ) {
			$site->pb_title = get_bloginfo( 'name' ); // Cool hack! :face_with_rolling_eyes:
			$sites_in_catalog[] = $site;
		}
		restore_current_blog();
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

		switch_to_blog( $site->blog_id );
		$schema = book_information_to_schema( Book::getBookInformation() );
		$book['title'] = $schema['name'];
		$book['date-published'] = $schema['datePublished'] ?? '';
		$book['subject'] = $schema['about'][0]['identifier'] ?? '';
		$book['link'] = get_blogaddress_by_id( $site->blog_id );
		$book['metadata'] = $schema;
		$books[] = $book;
		restore_current_blog();

		if ( count( $books ) >= $per_page ) {
			break;
		}
	}

	return [ 'pages' => $total_pages, 'books' => $books ];
}


/**
 * Get licenses for catalog display.
 *
 * @return array
 */
function get_catalog_licenses() {
	if ( defined( 'PB_PLUGIN_VERSION' ) ) {
		$licenses = ( new \Pressbooks\Licensing() )->getSupportedTypes();
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
 * @param array $catalog_data
 *
 * @return array
 */
function get_available_licenses( $catalog_data ) {
	$licenses = [];
	$licensing = new \Pressbooks\Licensing();

	foreach ( $catalog_data['books'] as $book ) {
		$license = $licensing->getLicenseFromUrl( $book['metadata']['license']['url'] );
		if ( ! in_array( $license, $licenses, true ) ) {
			$licenses[] = $license;
		}
	}

	return $licenses;
}

/**
 * Get subjects currently in use.
 *
 * @param array $catalog_data
 *
 * @return array
 */
function get_available_subjects( $catalog_data ) {
	$subjects = [];
	foreach ( $catalog_data['books'] as $book ) {
		if ( ! empty( $book['subject'] ) ) {
			$subjects[ substr( $book['subject'], 0, 1 ) ][] = substr( $book['subject'], 0, 2 );
		}
	}

	return $subjects;
}

/**
 * Return the default (non-page) menu items.
 *
 * @param string $items
 *
 * @return string $items
 */
function get_default_menu( $items = '' ) {
	$link = ( is_front_page() ) ? network_home_url( '#main' ) : network_home_url( '/' );
	$items = sprintf(
		'<li><a href="%1$s">%2$s</a></li>',
		$link,
		__( 'Home', 'pressbooks-aldine' )
	) . $items;
	if ( get_option( 'pb_network_contact_form' ) ) {
		$items .= sprintf(
			'<li><a href="%1$s">%2$s</a></li>',
			'#contact',
			__( 'Contact', 'pressbooks-aldine' )
		);
	}
	if ( ! is_user_logged_in() ) {
		$items .= sprintf(
			'<li><a href="%1$s">%2$s</a></li>',
			wp_login_url( get_permalink() ),
			__( 'Sign In', 'pressbooks-aldine' )
		);
		if ( in_array( get_site_option( 'registration' ), [ 'user', 'all' ], true ) ) {
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				network_home_url( '/wp-signup.php' ),
				__( 'Sign Up', 'pressbooks-aldine' )
			);
		}
	} else {
		if ( is_super_admin() || is_user_member_of_blog() ) {
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				admin_url(),
				__( 'Admin', 'pressbooks-aldine' )
			);
		}
		$user_info = get_userdata( get_current_user_id() );
		if ( $user_info->primary_blog ) {
			$items .= sprintf(
				'<li><a href="%1$s">%2$s</a></li>',
				get_blogaddress_by_id( $user_info->primary_blog ) . 'wp-admin/index.php?page=pb_catalog',
				__( 'My Books', 'pressbooks-aldine' )
			);
		}
		$items .= sprintf(
			'<li><a href="%1$s">%2$s</a></li>',
			wp_logout_url( get_permalink() ),
			__( 'Sign Out', 'pressbooks-aldine' )
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
 * @param string $items
 */
function default_menu( $args = [], $items = '' ) {
	printf(
		"<{$args['container']} id='{$args['container_id']}' class='{$args['container_class']}'><ul id='{$args['menu_id']}' class='{$args['menu_class']}'>%s</ul></{$args['container']}>",
		get_default_menu( $items )
	);
	if ( class_exists( '\PressbooksOAuth\OAuth' ) ) {
		add_filter( 'pb_oauth_output_button', function( $bool ) {
			return false;
		} );
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
				sprintf( __( 'Contact Form Submission from %s', 'pressbooks-aldine' ), $name ),
				sprintf(
					"From: %1\$s <%2\$s>\nInstitution: %3\$s\n\n%4\$s",
					stripslashes( $name ),
					$email,
					stripslashes( $institution ),
					strip_tags( $message )
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
	return;
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
