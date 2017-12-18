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
<div class="controls">
  <div class="search">
	<h2><a href="#search"><?php _e( 'Search by titles or keyword', 'pressbooks-aldine' ); ?> <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a></h2>
  </div>
  <div class="filters">
	<a href="#filter"><?php _e( 'Filter by', 'pressbooks-aldine' ); ?> <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
	<div id="filter" class="filter-groups">
		<?php foreach ( $subject_groups as $key => $val ) : ?>
		<div class="<?php echo $key; ?> subjects" id="<?php echo $key; ?>">
			<a href="#<?php echo $key; ?>"><?php echo $val['label']; ?> <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
			<ul class="filter-list">
				<?php foreach ( $val['children'] as $k => $v ) :
					if ( strlen( $k ) === 2 ) : ?>
				<li><a data-filter="{{ $k }}"><?php echo $v; ?><span class="close">&times;</span></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="licenses" id="licenses">
	  <a href="#licenses"><?php _e( 'Licenses', 'pressbooks-aldine' ); ?><svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
	  <ul class="filter-list">
		<?php foreach ( $licenses as $key => $value ) : ?>
		  <li><a data-filter="<?php echo $key; ?>"><?php echo $value; ?><span class="close">&times;</span></a></li>
		<?php endforeach; ?>
	  </ul>
	</div>
  </div>
  <div class="sort">
	<a href="#sort"><?php _e( 'Sort by', 'pressbooks-aldine' ); ?> <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
	<ul id="sort" class="sorts">
	  <li><a data-sort="title" href="<?php echo "/catalog/page/$current_page/?orderby=title"; ?>"><?php _e( 'Title', 'pressbooks-aldine' ); ?></a></li>
	  <li><a data-sort="subject" href="<?php echo "/catalog/page/$current_page/?orderby=subject"; ?>"><?php _e( 'Subject', 'pressbooks-aldine' ); ?></a></li>
	  <li><a data-sort="latest" href="<?php echo "/catalog/page/$current_page/?orderby=latest"; ?>"><?php _e( 'Latest', 'pressbooks-aldine' ); ?></a></li>
	</ul>
  </div>
</div>
<div class="books">
	<?php foreach ( $catalog_data['books'] as $book ) :
		include( locate_template( 'partials/book.php' ) );
	endforeach; ?>
</div>
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
