<?php
/**
 * Template part for displaying the catalog page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

?>

<?php get_template_part( 'partials/page', 'header' ); ?>
<section class="network-catalog">
	<form role="form" class="filter-sort" method="get">
		<input type="hidden" name="paged" value="<?php echo $current_page; ?>" />
		<fieldset class="subject-filters">
			<h2><?php _e( 'Filter by Subject', 'pressbooks-aldine' ); ?></h2>
			<input type="radio" name="subject" id="all-subjects" value="" <?php checked( $subject, '' ); ?>>
			<label for="all-subjects"><?php _e( 'All Subjects', 'pressbooks-aldine' ); ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<div class="subject-groups">
			<?php
			foreach ( $subjects as $key => $val ) :
				if ( array_key_exists( $key, $available_subjects ) ) :
					?>
				<h3><span class="label"><?php echo $val['label']; ?></span></h3>
					<?php
					foreach ( $val['children'] as $k => $v ) :
						if ( in_array( $k, $available_subjects[ $key ], true ) ) :
							?>
						<input type="radio" name="subject" id="<?php echo $k; ?>" value="<?php echo $k; ?>" <?php checked( $subject, $k ); ?>>
						<label for="<?php echo $k; ?>"><span class="label"><?php echo $v; ?></span> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</fieldset>
		<fieldset class="institution-filters">
			<h2><?php _e( 'Filter by Institution', 'pressbooks-aldine' ); ?></h2>
			<input type="radio" name="institution" id="all-institutions" value="" <?php checked( $institution, '' ); ?>>
			<label for="all-institutions"><?php _e( 'All Institutions', 'pressbooks-aldine' ); ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php
			foreach ( $institutions as $key => $value ) :
				if ( array_key_exists( $key, $available_institutions ) ) :
					?>
					<input type="radio" name="institution" id="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php checked( $institution, $key ); ?>>
					<label for="<?php echo $key; ?>"><?php echo $value; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
					<?php
				endif;
			endforeach;
			?>
		</fieldset>
		<fieldset class="license-filters">
			<h2><?php _e( 'Filter by License', 'pressbooks-aldine' ); ?></h2>
			<input type="radio" name="license" id="all-licenses" value="" <?php checked( $license, '' ); ?>>
			<label for="all-licenses"><?php _e( 'All Licenses', 'pressbooks-aldine' ); ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php
			foreach ( $licenses as $key => $value ) :
				if ( in_array( $key, $available_licenses, true ) ) :
					?>
				<input type="radio" name="license" id="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php checked( $license, $key ); ?>>
				<label for="<?php echo $key; ?>"><?php echo $value; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
					<?php
			endif;
				endforeach;
			?>
		</fieldset>
		<fieldset class="sorts">
			<h2><?php _e( 'Sort by', 'pressbooks-aldine' ); ?></h2>
			<?php
			$sorts = [
				'title' => __( 'Title', 'pressbooks-aldine' ),
				'subject' => __( 'Subject', 'pressbooks-aldine' ),
				'latest' => __( 'Latest', 'pressbooks-aldine' ),
			];
			foreach ( $sorts as $key => $value ) {
				?>
				<input type="radio" name="orderby" id="<?php echo $key ?>" value="<?php echo $key ?>" <?php checked( $orderby, $key ); ?>>
				<label for="<?php echo $key ?>"><?php echo $value; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php } ?>
		</fieldset>
		<button type="button" class="clear-filters" hidden><?php _e( 'Clear Filters', 'pressbooks-aldine' ); ?></button>
		<button type="submit"><?php _e( 'Submit', 'pressbooks-aldine' ); ?></button>
	</form>
<ul class="books">
	<?php
	foreach ( $catalog_data['books'] as $book ) :
		include( locate_template( 'partials/book.php' ) );
	endforeach;
	?>
</ul>
<?php if ( isset( $catalog_data['pages'] ) && $catalog_data['pages'] > 1 ) : ?>
<nav class="catalog-navigation">
	<?php
	if ( $previous_page ) :
		?>
		<a class="previous" rel="previous" data-page="<?php echo $previous_page; ?>" href="<?php echo network_home_url( "/catalog/page/$previous_page/" ); ?>"><span class="screen-reader-text"><?php _e( 'Previous Page', 'pressbooks' ); ?></span>
			<svg aria-hidden="true">
				<use xlink:href="#arrow-left" />
			</svg></a><?php endif; ?>
	<div class="pages">
	<?php
	for ( $i = 1; $i <= $catalog_data['pages']; $i++ ) :
		if ( $i === $current_page ) :
			?>
		<span class="current"><?php echo $i; ?></span>
		<?php else : ?>
		<a href="<?php echo network_home_url( "/catalog/page/$i/" ); ?>"><?php echo $i; ?></a>
		<?php endif; ?>
	<?php endfor; ?>
	</div>
	<?php
	if ( $next_page <= $catalog_data['pages'] ) :
		?>
		<a class="next" rel="next" data-page="<?php echo $next_page; ?>" href="<?php echo network_home_url( "/catalog/page/$next_page/" ); ?>"><span class="screen-reader-text"><?php _e( 'Next Page', 'pressbooks' ); ?></span>
			<svg aria-hidden="true">
				<use xlink:href="#arrow-right" />
			</svg></a><?php endif; ?>
</nav>
<?php endif; ?>
</section>
