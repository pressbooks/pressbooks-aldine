<?php
/**
 * The template for displaying the Our Last Titles section
 *
 * Template Name: Featured Books
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

get_header(); ?>

	<div id="primary" class="content-area wider-page">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'partials/content-page-featured-books', 'page' );

			endwhile;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
