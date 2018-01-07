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

$front_page_catalog = get_option( 'pb_front_page_catalog' );
$latest_books_title = get_option( 'pb_front_page_catalog_title', __( 'Our Latest Titles', 'pressbooks-aldine' ) );
$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$catalog_data = get_catalog_data( $page, 3 );
$previous_page = ( $page > 1 ) ? $page - 1 : 0;
$next_page = $page + 1;

?>

<div class="blarg">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php
				the_content();
			?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->

<?php if ( get_option( 'pb_front_page_catalog' ) ) : ?>
	<div id="latest-titles" class="latest-books">
		<h3><?php echo $latest_books_title; ?></h3>
		<div class="track">
			<div class="books" data-total-pages="{{ $catalog_data["pages"] }}" <?php if ( $next_page <= $catalog_data['pages'] ) : ?>data-next-page="{{ $next_page }}"<?php endif; ?>>
			<?php foreach ( $catalog_data['books'] as $book ) :
				include( locate_template( 'partials/book.php' ) );
			endforeach; ?>
			</div>
			<?php if ( $previous_page ) : ?>
				<a class="previous" data-page="<?php echo $previous_page; ?>" href="<?php echo network_home_url( "/page/$previous_page/#latest-titles" ); ?>"></a>
			<?php endif; ?>
			<?php if ( $next_page <= $catalog_data['pages'] ) : ?>
				<a class="next" data-page="<?php echo $next_page; ?>" href="<?php echo network_home_url( "/page/$next_page/#latest-titles" ); ?>"></a>
			<?php endif; ?>
		</div>
		<div class="catalog-link">
			<a class="button button--outline button--wide" href="<?php echo network_home_url( '/catalog/' ); ?>"><?php _e( 'View Complete Catalog', 'pressbooks-aldine' ); ?></a>
		</div>
	</div>
<?php endif; ?>
</div>
