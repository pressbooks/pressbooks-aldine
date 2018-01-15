<nav class="booknav" aria-labelledby="latest-books-title book-navigation">
	<span class="screen-reader-text"><?php _e( 'Navigation', 'pressbooks-aldine' ); ?></span>
	<?php if ( $previous_page ) : ?>
		<a class="previous" rel="previous" data-page="<?php echo $previous_page; ?>" href="<?php echo network_home_url( "/page/$previous_page/#latest-books" ); ?>">
			<span class="screen-reader-text"><?php _e( 'Previous Page', 'pressbooks' ); ?></span>
			<svg aria-hidden="true">
				<use xlink:href="#arrow-left" />
			</svg>
		</a>
	<?php endif; ?>
	<?php if ( $next_page <= $catalog_data['pages'] ) : ?>
		<a class="next" rel="next" data-page="<?php echo $next_page; ?>" href="<?php echo network_home_url( "/page/$next_page/#latest-books" ); ?>">
			<span class="screen-reader-text"><?php _e( 'Next Page', 'pressbooks' ); ?></span>
			<svg aria-hidden="true">
				<use xlink:href="#arrow-right" />
			</svg>
		</a>
	<?php endif; ?>
</nav>
