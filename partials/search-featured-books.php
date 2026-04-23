<?php
/**
 * Featured Books Search Control
 *
 * @package Aldine
 */

?>

<label data-setting="<?php echo esc_attr( $this->id ); ?>">
	<span id="search-books-label-<?php echo esc_attr( $this->id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<div class="search-books-field">
		<input type="text"
			id="search-books-input-<?php echo esc_attr( $this->id ); ?>"
			class="search-books-input"
			data-setting="<?php echo esc_attr( $this->id ); ?>"
			value="<?php echo esc_attr( $current_title ); ?>"
			autocomplete="off"
			placeholder="<?php esc_attr_e( 'Search catalog', 'pressbooks-aldine' ); ?>" 
			role="combobox"
			aria-autocomplete="list"
			aria-expanded="false"
			aria-controls="search-books-results-<?php echo esc_attr( $this->id ); ?>"
			aria-labelledby="search-books-label-<?php echo esc_attr( $this->id ); ?>"
		/>
		<span class="search-books-icon dashicons dashicons-search" aria-hidden="true"></span>
	</div>
	<ul 
		id="search-books-results-<?php echo esc_attr( $this->id ); ?>"
		role="listbox"
		aria-labelledby="search-books-label-<?php echo esc_attr( $this->id ); ?>"
		class="search-books-results"
	></ul>
</label>
