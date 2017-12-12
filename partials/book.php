<?php $subject = ( isset( $book['subject'] ) ) ? substr( $book['subject'], 0, 2 ) : '';
$date = ( isset( $book['metadata']['datePublished'] ) ) ? str_replace( '-', '', $book['metadata']['datePublished'] ) : '';
?>

<div class="book"
<?php if ( $date ) { ?>data-date-published="<?php echo $date; ?>"<?php } ?>
	data-license="<?php echo ( new \Pressbooks\Licensing() )->getLicenseFromUrl( $book['metadata']['license']['url'] ); ?>"
	data-subject="<?php echo $subject ?>"
>
<?php if ( isset( $book['subject'] ) ) { ?>
  <p class="book__subject">
	<a href="<?php echo network_home_url( "/catalog/#$subject" ) ?>"><?php echo \Pressbooks\Metadata\get_subject_from_thema( $book['subject'] ); ?></a>
  </p>
<?php } ?>
  <p class="book__title">
	<a href="<?php echo $book['link']; ?>"><?php echo $book['metadata']['name']; ?></a>
  </p>
  <p class="book__read-more">
	<a href="<?php echo $book['link']; ?>"><?php _e( 'About this book &rarr;', 'aldine' ); ?></a>
  </p>
</div>
