<?php
/**
 * Template for displaying books in network catalog
 *
 * @package Aldine
 */

use function \Aldine\Helpers\maybe_truncate_string;
?>
<div class="book">
	<div class="book__cover" style="background-image: url('<?php echo $book['metadata']['image']; ?>' );"></div>
	<p class="book__title">
		<a href="<?php echo $book['link']; ?>"><?php echo maybe_truncate_string( $book['metadata']['name'] ); ?></a>
	</p>
</div>
