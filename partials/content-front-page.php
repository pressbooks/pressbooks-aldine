<?php
/**
 * Template part for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

?>

<?php

use function Aldine\Helpers\get_catalog_data;
use function Aldine\Helpers\has_sections;

$front_page_catalog = get_option( 'pb_front_page_catalog' );
$pb_front_page_catalog_title = get_option( 'pb_front_page_catalog_title' );
$latest_books_title = ( ! empty( $pb_front_page_catalog_title ) ) ? $pb_front_page_catalog_title : __( 'Our Latest Titles', 'pressbooks-aldine' );
if ( get_option( 'pb_front_page_catalog' ) ) {
	$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	$catalog_data = get_catalog_data( $page, 3, 'latest' );
	$previous_page = ( $page > 1 ) ? $page - 1 : 0;
	$next_page = $page + 1;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo get_bloginfo( 'name', 'display' ); ?></h1>
		<p class="entry-description"><?php echo get_bloginfo( 'description', 'display' ); ?></p>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( has_sections( $post->ID ) ) {
			the_content();
		} else {
			$content = get_post_field( 'post_content', $post );
			if ( ! empty( $content ) ) {
				echo apply_filters(
					'the_content',
					sprintf(
						'[aldine_page_section]%s[/aldine_page_section]',
						$content
					)
				);
			}
		}
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php if ( get_option( 'pb_front_page_catalog' ) && ! empty( $catalog_data['books'] ) ) : ?>
<div id="latest-books" class="latest-books">
	<h2 id="latest-books-title"><?php echo $latest_books_title; ?></h2>
	<div class="slider" role="region" aria-labelledby="latest-books-title" data-total-pages="<?php echo $catalog_data['pages']; ?>" <?php if ( $next_page <= $catalog_data['pages'] ) : ?>data-next-page="<?php echo $next_page; ?>"<?php endif; ?>>
		<ul class="books">
		<?php foreach ( $catalog_data['books'] as $book ) :
			include( locate_template( 'partials/book.php' ) );
		endforeach; ?>
		</ul>
		<?php if ( $previous_page || $next_page ) { include( locate_template( 'partials/paged-navigation.php' ) ); } ?>
	</div>
	<p class="catalog-link">
		<a class="call-to-action" href="<?php echo network_home_url( '/catalog/' ); ?>"><?php _e( 'View Complete Catalog', 'pressbooks-aldine' ); ?></a>
	</p>
</div>
<?php endif; ?>
