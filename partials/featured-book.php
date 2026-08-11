<?php
/**
 * Template for displaying books in network catalog
 *
 * @package Aldine
 */

use function Aldine\Helpers\maybe_truncate_string;

?>
<div class="featured_book">
	<a href="<?php echo $book['link']; ?>" aria-label="<?php echo esc_attr($book['metadata']['name']); ?>">
		<div class="featured_book__cover" style="background-image: url('<?php echo $book['metadata']['image']; ?>' );"></div>
		<p class="featured_book__title">
			<?php echo maybe_truncate_string($book['metadata']['name']); ?>
		</p>
	</a>
</div>
