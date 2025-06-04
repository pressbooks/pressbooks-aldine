<?php
/**
 * Template part for displaying page content in page-titles.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-titles' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		$content = get_the_content();
		$has_titles_shortcode = preg_match( '/\[last-titles.*?\]/', $content );
		if ( $has_titles_shortcode ) {
			$main_content = preg_replace( '/\[last-titles.*?\]/', '', $content );
			$main_content = apply_filters( 'the_content', $main_content );
			$main_content = str_replace( ']]>', ']]&gt;', $main_content );
			echo $main_content;
		} else {
			the_content();
		}

		wp_link_pages(
			[
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pressbooks-aldine' ),
				'after'  => '</div>',
			]
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'pressbooks-aldine' ),
							[
								'span' => [
									'class' => [],
								],
							]
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article>
<?php
if ( $has_titles_shortcode ) {
	$atts = shortcode_parse_atts( str_replace( '[last-titles', '', str_replace( ']', '', $content ) ) );
	$title = isset( $atts['title'] ) ? ' title="' . esc_attr( $atts['title'] ) . '"' : '';
	echo do_shortcode( '[latest-titles' . $title . ']' );
}
?>
