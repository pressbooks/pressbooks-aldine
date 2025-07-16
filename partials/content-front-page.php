<?php
/**
 * Template part for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

use function Aldine\Helpers\get_catalog_page;
use function Aldine\Helpers\get_featured_books;
use function Aldine\Helpers\has_sections;

$pb_front_page_catalog_title = get_option( 'pb_front_page_catalog_title' );

$latest_books_title = ( ! empty( $pb_front_page_catalog_title ) ) ? $pb_front_page_catalog_title : __('Our Latest Titles',
'pressbooks-aldine');

$tagline_text = null;
if ( has_shortcode( $post->post_content, 'aldine_page_section' ) ) {
	$shortcode = get_shortcode_regex( [ 'aldine_page_section' ] );
	preg_match_all( '/' . $shortcode . '/s', $post->post_content, $matches );
	if ( ! empty( $matches[3] ) && isset( $matches[3][0] ) ) {
		$atts = shortcode_parse_atts( $matches[3][0] );
		if ( isset( $atts['tagline-text'] ) && ! empty( $atts['tagline-text'] ) ) {
			$tagline_text = esc_html( $atts['tagline-text'] );
		}
	}
}

if ( get_option( 'pb_front_page_catalog' ) ) {
	$catalog_data = get_featured_books();
}

$catalog_page = get_catalog_page();
if ( $catalog_page ) {
	$catalog_permalink = get_permalink( $catalog_page->ID );
}

$title_text = null;

if ( get_page_template_slug() === 'page-custom-home.php' ) {
	$title_text = get_the_title( $post->ID );
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo $title_text ?? get_bloginfo( 'name', 'display' ); ?></h1>
		<p class="entry-description"><?php echo $tagline_text ?? get_bloginfo( 'description', 'display' ); ?></p>
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
		<div class="books">
			<?php
			foreach ( $catalog_data['books'] as $book ) :
				include( locate_template( 'partials/featured-book.php' ) );
			endforeach;
			?>
		</div>
		<p class="catalog-link">
			<a class="call-to-action" href="<?php echo $catalog_permalink ?? ''; ?>">
				<?php echo __( 'View Complete Catalog', 'pressbooks-aldine' ); ?>
			</a>
		</p>
	</div>
<?php endif; ?>
