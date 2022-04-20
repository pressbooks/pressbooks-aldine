<?php
add_filter( 'wp_robots', 'wp_robots_no_robots' );
nocache_headers();

do_action( 'pb_custom_signup_form_handler' )

?>
<html lang="en">
<head>
	<title>PressBooks Aldine</title>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo("template_directory"); ?>/dist/styles/aldine.css" />
	<?php do_action( 'pb_custom_signup_header' ); ?>
<body>
<?php do_action( 'pb_custom_signup_before_wrapper' ); ?>
<div class="signup">
	<section class="form__wrapper">
		<h1>Pressbooks Logo</h1>
		<h2>Start creating your <strong>manuscript</strong> today</h2>
		<p>Sign up with your email and password</p>
		<form action="<?php echo home_url(); ?>/register" method="post">
			<input type="text" name="user_email" placeholder="Email" />
			<label for="user_email error">Will be used to send your registration details</label>
			<input type="password" name="user_pass" placeholder="Password" />
			<label for="password error">At least 12 characters, with at least one upper case letter and one number</label>
			<?php do_action( 'pb_custom_signup_extra_fields' ); ?>
			<button type="submit">Create Your Account</button>
			<label>By signing up for Pressbooks. you agree to our privacy policy and terms of service.</label>
		</form>
		Already have an account? <a href="<?php echo site_url(); ?>/wp-login.php">Log in</a>
	</section>
	<section class="social__wrapper">
		<h2>Or sign up with one of the following:</h2>
		<div class="social__buttons">
			<a href="<?php echo site_url(); ?>/wp-login.php?loginFacebook=1">Google</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginTwitter=1">Twitter</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginTwitter=1">LinkedIn</a>
			<a href="<?php echo site_url(); ?>/wp-login.php?loginTwitter=1">Facebook</a>
		</div>
	</section>
</div>
<?php do_action( 'pb_custom_signup_after_wrapper' ); ?>
