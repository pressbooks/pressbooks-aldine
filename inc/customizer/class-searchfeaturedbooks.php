<?php

namespace Aldine\Customizer;

class SearchFeaturedBooks extends \WP_Customize_Control {

	public $type = 'search-books';

	public function render_content(): void {
		$dc            = \Pressbooks\DataCollector\Book::init();
		$current_id    = intval( $this->value() );
		$current_title = $current_id
			? $dc->get( $current_id, $dc::TITLE )
			: '';

		include get_template_directory() . '/partials/search-featured-books.php';
	}
}
