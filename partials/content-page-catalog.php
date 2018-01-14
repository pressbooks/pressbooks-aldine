<?php
/**
 * Template part for displaying the catalog page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

?>

<?php

use function Aldine\Helpers\get_catalog_data;
use function Aldine\Helpers\get_catalog_licenses;

$current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$orderby = ( get_query_var( 'orderby' ) ) ? get_query_var( 'orderby' ) : 'title';
$subject = ( get_query_var( 'subject' ) ) ? get_query_var( 'subject' ) : '';
$license = ( get_query_var( 'license' ) ) ? get_query_var( 'license' ) : '';
$catalog_data = get_catalog_data( $current_page, 9, $orderby, $license, $subject );
$previous_page = ( $current_page > 1 ) ? $current_page - 1 : 0;
$next_page = $current_page + 1;
$licenses = get_catalog_licenses();
$subject_groups = ( defined( 'PB_PLUGIN_VERSION' ) ) ? \Pressbooks\Metadata\get_thema_subjects() : [];

?>

<?php get_template_part( 'partials/page', 'header' ); ?>
<section class="network-catalog">
	<form role="form" class="filter-sort" method="get">
		<input type="hidden" name="paged" value="<?php echo $current_page; ?>" />
		<fieldset class="license-filters">
			<h2><?php _e( 'Filter by License', 'pressbooks-aldine' ); ?></h2>
			<input type="radio" name="license" id="all-licenses" value="" <?php checked( $license, '' ); ?>>
			<label for="all-licenses"><?php _e( 'All Licenses', 'pressbooks-aldine' ); ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php foreach ( $licenses as $key => $value ) : ?>
				<input type="radio" name="license" id="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php checked( $license, $key ); ?>>
				<label for="<?php echo $key; ?>"><?php echo $value; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php endforeach; ?>
		</fieldset>
		<fieldset class="subject-filters">
			<h2><?php _e( 'Filter by Subject', 'pressbooks-aldine' ); ?></h2>
			<input type="radio" name="subject" id="all-subjects" value="" <?php checked( $subject, '' ); ?>>
			<label for="all-subjects"><?php _e( 'All Subjects', 'pressbooks-aldine' ); ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<div class="subject-groups">
			<?php foreach ( $subject_groups as $key => $val ) : ?>
				<h3><?php echo $val['label']; ?></h3>
				<?php foreach ( $val['children'] as $k => $v ) :
					if ( strlen( $k ) === 2 ) : ?>
						<input type="radio" name="subject" id="<?php echo $k; ?>" value="<?php echo $k; ?>" <?php checked( $subject, $k ); ?>>
						<label for="<?php echo $k; ?>"><?php echo $v; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
			</div>
		</fieldset>
		<fieldset class="sorts">
			<h2><?php _e( 'Sort by', 'pressbooks-aldine' ); ?></h2>
			<?php
			$sorts = [
				'title' => __( 'Title', 'pressbooks-aldine' ),
				'subject' => __( 'Subject', 'pressbooks-aldine' ),
				'latest' => __( 'Latest', 'pressbooks-aldine' ),
			];
			foreach ( $sorts as $key => $value ) { ?>
				<input type="radio" name="orderby" id="<?php echo $key ?>" value="<?php echo $key ?>" <?php checked( $orderby, $key ); ?>>
				<label for="<?php echo $key ?>"><?php echo $value; ?> <svg class="checked"><use xlink:href="#checkmark" /></svg></label>
			<?php } ?>
		</fieldset>
		<button type="submit"><?php _e( 'Submit', 'pressbooks-aldine' ); ?></button>
	</form>
<ul class="books">
	<?php foreach ( $catalog_data['books'] as $book ) :
		include( locate_template( 'partials/book.php' ) );
	endforeach; ?>
</ul>
<?php if ( $catalog_data['pages'] > 1 ) : ?>
<nav class="catalog-navigation">
<?php if ( $previous_page ) : ?><a class="previous" data-page="<?php echo $previous_page; ?>" href="<?php echo network_home_url( "/catalog/page/$previous_page/" ); ?>"><?php _e( 'Previous', 'pressbooks-aldine' ); ?></a><?php endif; ?>
  <div class="pages">
	<?php for ( $i = 1; $i <= $catalog_data['pages']; $i++ ) :
		if ( $i === $current_page ) : ?>
		<span class="current"><?php echo $i; ?></span>
		<?php else : ?>
		<a href="<?php echo network_home_url( "/catalog/page/$i/" ); ?>"><?php echo $i; ?></a>
		<?php endif; ?>
	<?php endfor; ?>
  </div>
<?php if ( $next_page <= $catalog_data['pages'] ) : ?><a class="next" data-page="<?php echo $next_page; ?>" href="<?php echo network_home_url( "/catalog/page/$next_page/" ); ?>"><?php _e( 'Next', 'pressbooks-aldine' ); ?></a><?php endif; ?>
</nav>
<?php endif; ?>
</section>
