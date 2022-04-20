<?php
add_filter( 'wp_robots', 'wp_robots_no_robots' );
nocache_headers();

do_action( 'pb_custom_signup_form_handler' )

?>
<html lang="en">
<head>
	<title>Signup for a Pressbooks Account</title>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo("template_directory"); ?>/dist/styles/aldine.css" />
	<?php do_action( 'pb_custom_signup_header' ); ?>
<body class="page signup">
<!-- TODO: insert logo -->
<p class="signup--tagline"><?php _e( 'Start creating your textbook today', 'pressbooks-aldine' ); ?></p>
<?php do_action( 'pb_custom_signup_before_wrapper' ); ?>
<div class="signup--wrapper">
	<section class="signup--section">
		<h2 class="signup--header-title"><?php _e( 'Sign up with your email and a password', 'pressbooks-aldine' ); ?></h2>
		<form class="form"<?php echo home_url(); ?>/register" method="post">
			<div class="form--input-wrapper">
				<input id="email" type="email" autocomplete="email" placeholder=" " required/>
				<label for="email"><?php _e( 'Email address', 'pressbooks-aldine' );?></label>
			</div>
			<p class="form--input-description"><?php _e( 'Will be used to send your registration details', 'pressbooks-aldine' );?></p>
			<div class="form--input-wrapper">
				<input id="password" type="text" autocomplete="new-password" placeholder=" " required/>
				<label for="password"><?php _e( 'Password', 'pressbooks-aldine' );?></label>
			</div>
			<p class="form--input-description"><?php _e( 'At least 12 characters, with at least one upper case letter and one number', 'pressbooks-aldine' ); ?></p>
			<?php do_action( 'pb_custom_signup_extra_fields' ); ?>
			<button type="submit"><?php _e( 'Create Your Account', 'pressbooks-aldine' );?></button>
			<p class="form--input-description"><?php _e( 'By signing up for Pressbooks. you agree to our privacy policy and terms of service.', 'pressbooks-aldine' ); ?></p>
		</form>
		<h2 class="signup--header-title">Already have an account? <a href="<?php echo site_url(); ?>/wp-login.php">Log in</a></h2>
	</section>
	<section class="signup--section">
		<h2 class="signup--header-title"><?php _e( 'Or sign up with one of the following:', 'pressbooks-aldine' ); ?></h2>
		<div class="signup--social-buttons">
			<a href="<?php echo site_url(); ?>/wp-login.php?loginGoogle=1">Google</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginTwitter=1">Twitter</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginFacebook=1">Facebook</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginLinkedIn=1">LinkedIn</a>
		</div>
	</section>
</div>
<?php do_action( 'pb_custom_signup_after_wrapper' ); ?>
