<?php
/**
 * The template for displaying the catalog page
 *
 * Template Name: Catalog
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

use function Aldine\Helpers\get_catalog_data;
use function Aldine\Helpers\get_catalog_licenses;
use function Aldine\Helpers\get_available_subjects;
use function Aldine\Helpers\get_available_licenses;

$current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$orderby = ( get_query_var( 'orderby' ) ) ? get_query_var( 'orderby' ) : 'title';
$subject = ( get_query_var( 'subject' ) ) ? get_query_var( 'subject' ) : '';
$license = ( get_query_var( 'license' ) ) ? get_query_var( 'license' ) : '';
$catalog_data = get_catalog_data( $current_page, 9, $orderby, $license, $subject );
$previous_page = ( $current_page > 1 ) ? $current_page - 1 : 0;
$next_page = $current_page + 1;
$licenses = get_catalog_licenses();
$available_licenses = get_available_licenses( $catalog_data );
$subjects = ( defined( 'PB_PLUGIN_VERSION' ) ) ? \Pressbooks\Metadata\get_thema_subjects() : [];
$available_subjects = get_available_subjects( $catalog_data );

if ( ! empty( $catalog_data['books'] ) ) : ?>

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php include( locate_template( 'partials/content-page-catalog.php' ) ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

else :
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 );
	exit();
endif;
