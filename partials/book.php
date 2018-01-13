<?php $subject = ( isset( $book['subject'] ) ) ? substr( $book['subject'], 0, 2 ) : '';
$date = ( isset( $book['metadata']['datePublished'] ) ) ? str_replace( '-', '', $book['metadata']['datePublished'] ) : '';
?>

<li class="book"
<?php if ( $date ) { ?>data-date-published="<?php echo $date; ?>"<?php } ?>
	data-license="<?php echo ( new \Pressbooks\Licensing() )->getLicenseFromUrl( $book['metadata']['license']['url'] ); ?>"
	<?php if ( ! empty( $subject ) ) { ?> data-subject="<?php echo $subject ?>"<?php } ?>
>
<?php if ( ! empty( $subject ) ) { ?>
  <p class="book__subject">
		<a href="<?php echo network_home_url( "/catalog/#$subject" ) ?>"><?php echo \Pressbooks\Metadata\get_subject_from_thema( $book['subject'] ); ?></a>
  </p>
<?php } ?>
  <p class="book__title">
		<a href="<?php echo $book['link']; ?>"><?php echo $book['metadata']['name']; ?></a>
  </p>
  <p class="book__read-more">
		<a href="<?php echo $book['link']; ?>"><?php _e( 'About this book', 'pressbooks-aldine' ); ?> <svg aria-hidden="true"><use xlink:href="#arrow-right" /></svg></a>
  </p>
</li>
