<?php
/**
 * The catalog search form
 *
 * @package Aldine
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s">
		<?php _ex( 'Search Catalog', 'label', 'pressbooks-aldine' ); ?>
		<input id="s" type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit" value="<?php _ex( 'Search', 'submit button', 'pressbooks-aldine' ); ?>" />
</form>
