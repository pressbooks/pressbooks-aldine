<?php
/**
 * The template for displaying custom signup/signin pages
 *
 * Template Name: Auth
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aldine
 */

use PressbooksMix\Assets;

add_filter( 'wp_robots', 'wp_robots_no_robots' );
nocache_headers();
$assets = new Assets( 'pressbooks-aldine', 'theme' );
$assets->setSrcDirectory( 'assets' )->setDistDirectory( 'dist' );
wp_enqueue_script( 'custom-signup', $assets->getPath( 'scripts/custom-signup.js' ) );

$action = $_GET['action'] ?? 'signup';

if ( $action === 'signup' ) {
	$main_title = esc_html__( 'Create a new account', 'pressbooks-aldine' );
	$title = esc_html__( 'Sign up with your email and a password', 'pressbooks-aldine' );
	$url = home_url() . '/auth/?action=signup';
	$button_cta = esc_html__( 'Create Your Account', 'pressbooks-aldine' );
	$invite_cta = esc_html__( 'Already have an account?', 'pressbooks-aldine' );
	$invite_cta_link = home_url() . '/auth/?action=signin';
	$invite_cta_link_text = esc_html__( 'Sign in', 'pressbooks-aldine' );
	$sign_action = esc_html__( 'Or sign up with one of the following', 'pressbooks-aldine' );
} else {
	$main_title = esc_html__( 'Welcome back!', 'pressbooks-aldine' );
	$title = esc_html__( 'Sign in to your existing account', 'pressbooks-aldine' );
	$url = home_url() . '/auth/?action=signin';
	$button_cta = esc_html__( 'Sign in', 'pressbooks-aldine' );
	$invite_cta = esc_html__( 'Don\'t have an account?', 'pressbooks-aldine' );
	$invite_cta_link = home_url() . '/auth/?action=signup';
	$invite_cta_link_text = esc_html__( 'Register here', 'pressbooks-aldine' );
	$sign_action = esc_html__( 'Or sign in with one of the following', 'pressbooks-aldine' );
}

// Implement this hook to process the form.
do_action( 'pb_custom_signup_form_handler' );

$errors = apply_filters( 'pb_custom_signup_errors', [] );

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html( $title ); ?></title>
	<?php
	wp_head();
	do_action( 'pb_custom_signup_header' );
	?>
</head>

<body class="page <?php echo $action; ?>">
<svg style="display: none;" xmlns="http://www.w3.org/2000/svg">
	<defs>
		<symbol id="icon-pressbooks" fill="currentColor" viewBox="0 0 45 44">
			<path d="M44.195 41.872c0 .745-.618 1.346-1.377 1.346H1.377C.617 43.219 0 42.617 0 41.872V1.347C0 .604.618 0 1.377 0h41.44c.76 0 1.378.604 1.378 1.347v40.525zM15.282 10.643h-5.21v21.43h3.304V24h1.906c1.435 0 2.656-.5 3.665-1.504 1.008-1.004 1.513-2.213 1.513-3.626v-3.113c0-1.47-.444-2.678-1.33-3.625-.956-.993-2.24-1.489-3.848-1.489zm1.977 5.165h-.001v3.131c0 .513-.184.952-.55 1.318a1.826 1.826 0 0 1-1.338.547h-1.994v-6.86h1.995c.571 0 1.029.171 1.372.513.344.342.516.792.516 1.35zm5.84 16.265h6.118c.828 0 1.662-.25 2.502-.752a4.642 4.642 0 0 0 1.73-1.779c.526-.945.788-2.097.788-3.455 0-.545-.04-1.043-.122-1.486-.163-.868-.414-1.575-.751-2.122-.513-.81-1.137-1.352-1.871-1.625a3.325 3.325 0 0 0 1.154-.839c.78-.866 1.173-2.018 1.173-3.455 0-.876-.105-1.635-.315-2.274-.386-1.198-1.027-2.08-1.925-2.652-1.049-.672-2.225-1.008-3.531-1.008h-4.95v21.447zm3.568-12.69v-5.475h1.382c.652 0 1.184.212 1.592.634.443.456.665 1.13.665 2.018 0 .537-.065.987-.193 1.352-.35.982-1.039 1.471-2.064 1.471h-1.382zm0 9.493v-6.397h1.382c.815 0 1.433.25 1.853.751.466.549.7 1.42.7 2.617 0 .502-.075.948-.227 1.335-.432 1.13-1.208 1.694-2.326 1.694h-1.382z" />
		</symbol>
		<symbol id="logo-pressbooks" viewBox="0 0 265 40">
			<path fill="#000" d="M51.979 1.754c2.75 0 4.942.868 6.579 2.602 1.514 1.656 2.272 3.768 2.272 6.34v5.442c0 2.472-.862 4.586-2.587 6.34-1.724 1.754-3.813 2.631-6.264 2.631H48.72v14.114h-5.651V1.754h8.91zm3.38 9.03c0-.977-.296-1.764-.882-2.364-.588-.597-1.371-.896-2.348-.896H48.72v11.99h3.409c.897 0 1.66-.32 2.287-.957a3.163 3.163 0 0 0 .942-2.303v-5.47zM74.255 1.754c3.149 0 5.462.868 6.937 2.602 1.295 1.516 1.943 3.63 1.943 6.34v5.442c0 2.652-1.006 4.893-3.02 6.727L84.3 39.222h-6.112l-3.425-14.114h-3.767v14.114h-5.651V1.754h8.91zm3.379 9.03c0-2.173-1.076-3.259-3.23-3.259h-3.408v11.99h3.409c.897 0 1.66-.32 2.287-.957a3.163 3.163 0 0 0 .942-2.302v-5.472zM89.145 39.22V1.724h16.087v5.681H94.796v10.227h7.625v5.682h-7.625V33.54h10.436v5.68zM127.808 29.892c.04 2.61-.639 4.843-2.034 6.697-.917 1.256-2.213 2.143-3.887 2.661-.897.278-1.944.418-3.14.418-2.212 0-4.047-.548-5.5-1.645-1.217-.896-2.179-2.117-2.886-3.661-.707-1.544-1.121-3.315-1.24-5.308l5.381-.388c.239 2.185.817 3.768 1.735 4.749.676.74 1.455 1.092 2.332 1.052 1.237-.039 2.223-.648 2.96-1.826.38-.578.569-1.407.569-2.485 0-1.555-.708-3.103-2.124-4.64l-5.024-4.758c-1.873-1.815-3.2-3.442-3.976-4.879-.837-1.615-1.257-3.37-1.257-5.267 0-3.411 1.146-5.995 3.438-7.75 1.415-1.057 3.17-1.586 5.263-1.586 2.014 0 3.739.447 5.173 1.346 1.116.697 2.018 1.672 2.706 2.93.687 1.256 1.101 2.701 1.24 4.335l-5.411.987c-.16-1.536-.598-2.73-1.317-3.589-.519-.616-1.266-.926-2.242-.926-1.037 0-1.823.459-2.362 1.374-.438.738-.658 1.656-.658 2.752 0 1.715.736 3.458 2.213 5.233.557.678 1.395 1.476 2.512 2.391 1.316 1.096 2.182 1.865 2.602 2.303 1.395 1.397 2.471 2.772 3.229 4.126.358.639.647 1.227.867 1.766.54 1.334.818 2.531.838 3.588zM150.383 29.892c.04 2.61-.637 4.843-2.032 6.697-.917 1.256-2.213 2.143-3.889 2.661-.897.278-1.944.418-3.138.418-2.213 0-4.049-.548-5.503-1.645-1.215-.896-2.178-2.117-2.885-3.661-.707-1.544-1.121-3.315-1.24-5.308l5.383-.388c.238 2.185.817 3.768 1.733 4.749.676.74 1.454 1.092 2.331 1.052 1.236-.039 2.223-.648 2.96-1.826.38-.578.57-1.407.57-2.485 0-1.555-.71-3.103-2.125-4.64l-5.024-4.758c-1.872-1.815-3.199-3.442-3.976-4.879-.838-1.616-1.256-3.372-1.256-5.268 0-3.412 1.146-5.995 3.44-7.75 1.414-1.058 3.168-1.587 5.262-1.587 2.013 0 3.737.448 5.173 1.346 1.116.698 2.018 1.673 2.706 2.93.688 1.257 1.102 2.702 1.242 4.336l-5.412.986c-.16-1.535-.599-2.73-1.316-3.588-.52-.616-1.266-.927-2.244-.927-1.036 0-1.823.46-2.362 1.374-.438.739-.658 1.656-.658 2.752 0 1.715.737 3.458 2.213 5.234.556.677 1.395 1.476 2.51 2.391 1.317 1.096 2.184 1.865 2.603 2.303 1.395 1.396 2.472 2.772 3.23 4.126.358.638.649 1.226.867 1.765.538 1.336.817 2.533.837 3.59zM155.077 39.22V1.724h8.463c2.231 0 4.245.588 6.04 1.764 1.535.998 2.631 2.543 3.29 4.636.359 1.117.538 2.442.538 3.977 0 2.512-.67 4.526-2.004 6.04a5.674 5.674 0 0 1-1.973 1.465c1.256.479 2.321 1.426 3.198 2.84.579.958 1.008 2.193 1.286 3.709.14.778.21 1.644.21 2.601 0 2.372-.449 4.386-1.345 6.04a8.075 8.075 0 0 1-2.96 3.11c-1.436.878-2.862 1.317-4.276 1.317h-10.467v-.001zm6.1-22.186h2.363c1.754 0 2.93-.856 3.528-2.57.219-.64.328-1.426.328-2.364 0-1.555-.379-2.73-1.137-3.53-.697-.736-1.605-1.105-2.72-1.105h-2.363v9.57zm0 16.595h2.363c1.912 0 3.239-.986 3.977-2.96.258-.676.387-1.455.387-2.332 0-2.092-.398-3.618-1.197-4.575-.717-.877-1.774-1.316-3.169-1.316h-2.363v11.183h.001zM187.88 1.276c2.491 0 4.607.877 6.353 2.631 1.743 1.754 2.616 3.868 2.616 6.34v20.452c0 2.491-.878 4.61-2.631 6.353-1.756 1.745-3.87 2.616-6.34 2.616-2.492 0-4.604-.877-6.34-2.631-1.734-1.753-2.602-3.866-2.602-6.34v-20.45c0-2.492.877-4.61 2.632-6.354 1.754-1.744 3.859-2.617 6.312-2.617zm3.078 8.85c0-.897-.313-1.66-.94-2.287a3.12 3.12 0 0 0-2.29-.941c-.896 0-1.664.314-2.302.941a3.085 3.085 0 0 0-.958 2.288v20.512c0 .898.319 1.66.958 2.287a3.17 3.17 0 0 0 2.302.943 3.12 3.12 0 0 0 2.29-.943c.627-.627.94-1.389.94-2.287V10.127zM210.663 1.276c2.49 0 4.61.877 6.353 2.631 1.746 1.754 2.617 3.868 2.617 6.34v20.452c0 2.491-.877 4.61-2.631 6.353-1.754 1.745-3.868 2.616-6.34 2.616-2.492 0-4.605-.877-6.34-2.631-1.733-1.753-2.602-3.866-2.602-6.34v-20.45c0-2.492.877-4.61 2.632-6.354 1.754-1.744 3.859-2.617 6.31-2.617zm3.08 8.85c0-.897-.316-1.66-.943-2.287s-1.39-.941-2.288-.941c-.898 0-1.665.314-2.302.941a3.09 3.09 0 0 0-.958 2.288v20.512c0 .898.32 1.66.958 2.287a3.166 3.166 0 0 0 2.302.943c.899 0 1.66-.315 2.288-.943.627-.627.943-1.389.943-2.287V10.127zM230.247 27.334V39.22h-5.652V1.723h5.652V15.09l6.907-13.366h6.025l-7.735 15.295 9.073 22.201h-6.644l-5.935-15.224zM264.784 29.892c.041 2.61-.637 4.843-2.032 6.697-.916 1.256-2.213 2.143-3.889 2.661-.896.278-1.943.418-3.138.418-2.213 0-4.048-.548-5.502-1.645-1.216-.896-2.178-2.117-2.886-3.661-.708-1.545-1.12-3.315-1.242-5.308l5.384-.388c.238 2.185.817 3.768 1.733 4.749.676.74 1.454 1.092 2.331 1.052 1.236-.039 2.223-.648 2.96-1.826.38-.578.57-1.407.57-2.485 0-1.555-.71-3.103-2.125-4.64l-5.024-4.758c-1.872-1.815-3.199-3.442-3.976-4.879-.838-1.616-1.258-3.372-1.258-5.268 0-3.412 1.147-5.995 3.44-7.75 1.415-1.058 3.169-1.587 5.263-1.587 2.012 0 3.737.448 5.173 1.346 1.115.698 2.018 1.673 2.705 2.93.688 1.257 1.102 2.702 1.242 4.336l-5.411.986c-.16-1.535-.6-2.73-1.316-3.588-.52-.616-1.266-.927-2.244-.927-1.036 0-1.823.46-2.362 1.374-.438.739-.658 1.656-.658 2.752 0 1.715.736 3.458 2.213 5.234.555.677 1.395 1.476 2.51 2.391 1.317 1.096 2.184 1.865 2.602 2.303 1.395 1.396 2.473 2.772 3.23 4.126.359.638.65 1.226.868 1.765.54 1.336.82 2.533.84 3.59z"/>
			<path fill="#B01109" d="M39.549 37.515c0 .667-.553 1.205-1.232 1.205H1.232A1.217 1.217 0 0 1 0 37.515V1.25C0 .585.553.045 1.232.045h37.083c.681 0 1.234.54 1.234 1.205v36.265z"/>
			<path fill="#EDEDED" d="M13.648 10.504c1.44 0 2.588.444 3.444 1.332.793.848 1.19 1.93 1.19 3.245v2.786c0 1.264-.452 2.346-1.354 3.244-.903.898-1.996 1.346-3.28 1.346h-1.705v7.225H8.986V10.504h4.662zm1.77 4.622c0-.5-.155-.903-.462-1.209-.307-.305-.717-.458-1.228-.458h-1.785v6.138h1.784c.468 0 .868-.163 1.197-.49.328-.327.492-.72.492-1.179v-2.802h.002zM20.644 29.682V10.489h4.429c1.169 0 2.222.3 3.16.902.803.511 1.377 1.301 1.722 2.374.188.57.282 1.25.282 2.034 0 1.286-.35 2.317-1.05 3.092a2.976 2.976 0 0 1-1.032.75c.657.245 1.215.73 1.674 1.455.302.49.526 1.123.672 1.899.073.397.11.842.11 1.33 0 1.215-.235 2.245-.705 3.092a4.154 4.154 0 0 1-1.55 1.591c-.75.45-1.497.674-2.238.674h-5.474zm3.193-11.356h1.236c.918 0 1.534-.438 1.847-1.317.115-.327.172-.73.172-1.21 0-.795-.197-1.397-.595-1.806-.365-.377-.84-.567-1.424-.567h-1.236v4.9zm0 8.494h1.236c1 0 1.695-.505 2.081-1.515.136-.347.204-.746.204-1.195 0-1.072-.21-1.85-.626-2.342-.376-.45-.93-.672-1.66-.672h-1.235v5.724z"/>
		</symbol>
		<symbol id="logo-google" viewBox="0 0 50 50">
			<path d="M 25.996094 48 C 13.3125 48 2.992188 37.683594 2.992188 25 C 2.992188 12.316406 13.3125 2 25.996094 2 C 31.742188 2 37.242188 4.128906 41.488281 7.996094 L 42.261719 8.703125 L 34.675781 16.289063 L 33.972656 15.6875 C 31.746094 13.78125 28.914063 12.730469 25.996094 12.730469 C 19.230469 12.730469 13.722656 18.234375 13.722656 25 C 13.722656 31.765625 19.230469 37.269531 25.996094 37.269531 C 30.875 37.269531 34.730469 34.777344 36.546875 30.53125 L 24.996094 30.53125 L 24.996094 20.175781 L 47.546875 20.207031 L 47.714844 21 C 48.890625 26.582031 47.949219 34.792969 43.183594 40.667969 C 39.238281 45.53125 33.457031 48 25.996094 48 Z"></path>
		</symbol>
		<symbol id="logo-twitter" viewBox="0 0 50 50">
			<path d="M 50.0625 10.4375 C 48.214844 11.257813 46.234375 11.808594 44.152344 12.058594 C 46.277344 10.785156 47.910156 8.769531 48.675781 6.371094 C 46.691406 7.546875 44.484375 8.402344 42.144531 8.863281 C 40.269531 6.863281 37.597656 5.617188 34.640625 5.617188 C 28.960938 5.617188 24.355469 10.21875 24.355469 15.898438 C 24.355469 16.703125 24.449219 17.488281 24.625 18.242188 C 16.078125 17.8125 8.503906 13.71875 3.429688 7.496094 C 2.542969 9.019531 2.039063 10.785156 2.039063 12.667969 C 2.039063 16.234375 3.851563 19.382813 6.613281 21.230469 C 4.925781 21.175781 3.339844 20.710938 1.953125 19.941406 C 1.953125 19.984375 1.953125 20.027344 1.953125 20.070313 C 1.953125 25.054688 5.5 29.207031 10.199219 30.15625 C 9.339844 30.390625 8.429688 30.515625 7.492188 30.515625 C 6.828125 30.515625 6.183594 30.453125 5.554688 30.328125 C 6.867188 34.410156 10.664063 37.390625 15.160156 37.472656 C 11.644531 40.230469 7.210938 41.871094 2.390625 41.871094 C 1.558594 41.871094 0.742188 41.824219 -0.0585938 41.726563 C 4.488281 44.648438 9.894531 46.347656 15.703125 46.347656 C 34.617188 46.347656 44.960938 30.679688 44.960938 17.09375 C 44.960938 16.648438 44.949219 16.199219 44.933594 15.761719 C 46.941406 14.3125 48.683594 12.5 50.0625 10.4375 Z"></path>
		</symbol>
		<symbol id="logo-facebook" viewBox="0 0 50 50">
			<path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z"></path>
		</symbol>
		<symbol id="logo-linkedin" viewBox="0 0 50 50">
			<path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z"></path>
		</symbol>
</svg>
</defs>
</svg>
<header class="header" role="banner">
	<div class="header__brand">
		<a title="<?php echo get_bloginfo( 'name', 'display' ); ?>" href="<?php echo network_home_url(); ?>">
			<?php if ( has_custom_logo() ) { ?>
				<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				printf(
					'<img class="header__logo--img" src="%1$s" srcset="%2$s" alt="%3$s" />',
					wp_get_attachment_image_src( $custom_logo_id, 'logo' )[0],
					wp_get_attachment_image_srcset( $custom_logo_id, 'large' ),
					/* translators: %s name of network */
						sprintf( esc_html__( 'Logo for %s', 'pressbooks-aldine' ), get_bloginfo( 'name', 'display' ) )
				);
				?>
			<?php } else { ?>
				<svg class="header__logo--svg">
					<use xlink:href="#logo-pressbooks" />
				</svg>
			<?php } ?>
		</a>
	</div>
</header>
<p class="signup--tagline"><?php _e( 'Start creating your <span id="typed"></span><span class="typed-cursor"></span> today', 'pressbooks-aldine' ); ?></p>
<h1 class="signup--page-title"><?php echo esc_html( $main_title ); ?></h1>
<?php do_action( 'pb_custom_signup_before_wrapper' ); ?>
<div class="signup--wrapper">
	<section class="signup--section">
		<h2 class="signup--header-title"><?php echo esc_html( $title ); ?></h2>
		<form class="form" action="<?php echo esc_html( $url ); ?>" method="post">
		<div class="form--input-wrapper">
			<?php if ( $action === 'signup' ) : ?>
			<input id="email" type="email" autocomplete="email" placeholder=" " name="user_email" required>
			<label for="email"><?php esc_html_e( 'Email address', 'pressbooks-aldine' ); ?></label>
			<p class="form--input-description"><?php esc_html_e( 'Will be used to send your registration details', 'pressbooks-aldine' ); ?></p>
			<?php else : ?>
			<input id="login" type="text" placeholder=" " name="user_login" required>
			<label for="login"><?php esc_html_e( 'Username or email address', 'pressbooks-aldine' ); ?></label>
			<?php endif; ?>
		</div>
			<?php if ( isset( $errors['user_email'] ) ) : ?>
				<p class="form--input-description error"><?php echo wp_kses( $errors['user_email'][0], true ); ?></p>
			<?php endif; ?>
			<?php if ( isset( $errors['invalid_username'] ) ) : ?>
				<p class="form--input-description error"><?php echo wp_kses( $errors['invalid_username'][0], true ); ?></p>
			<?php endif; ?>
		<div class="form--input-wrapper">
			<?php if ( $action === 'signup' ) : ?>
			<input id="new-pass" type="text" autocomplete="new-password" placeholder=" "  name="user_pwd" required>
			<label for="new-pass"><?php esc_html_e( 'Password', 'pressbooks-aldine' ); ?></label>
			<p class="form--input-description"><?php esc_html_e( 'At least 12 characters, with at least one upper case letter and one number', 'pressbooks-aldine' ); ?></p>
			<?php else : ?>
			<input id="password" type="password" autocomplete="password" placeholder=" "  name="password" required>
			<label for="password"><?php esc_html_e( 'Password', 'pressbooks-aldine' ); ?></label>
				<!-- TODO: Add 'show password button' like the one in the WP login form
				<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Show password">
					<span class="dashicons dashicons-visibility" aria-hidden="true"></span>
				</button>
				-->
			<p class="form--input-description"><a href="<?php echo wp_lostpassword_url(); ?>"><?php esc_html_e( 'Lost your password?', 'pressbooks-aldine' ); ?></a></p>
			<?php endif; ?>
		</div>
			<?php if ( isset( $errors['password_validation_error'] ) ) : ?>
				<p class="form--input-description error"><?php echo wp_kses( $errors['password_validation_error'][0], true ); ?></p>
			<?php endif; ?>
			<?php if ( isset( $errors['incorrect_password'] ) ) : ?>
				<p class="form--input-description error"><?php echo wp_kses( $errors['incorrect_password'][0], true ); ?></p>
			<?php endif; ?>
		<?php do_action( 'pb_custom_signup_extra_fields' ); ?>
		<button type="submit"><?php echo esc_html( $button_cta ); ?></button>
			<?php if ( $action === 'signup' ) : ?>
				<p class="form--input-description"><?php esc_html_e( 'By signing up for Pressbooks. you agree to our privacy policy and terms of service.', 'pressbooks-aldine' ); ?></p>
			<?php endif; ?>
		<?php wp_nonce_field( 'pb_nonce_signup', 'pb_nonce_signup' ); ?>
		</form>
		<h2 class="signup--header-title"><?php echo esc_html( $invite_cta ); ?> <a href="<?php echo esc_html( $invite_cta_link ); ?>"><?php echo esc_html( $invite_cta_link_text ); ?></a></h2>
	</section>
	<section class="signup--section">
		<h2 class="signup--header-title"><?php echo esc_html( $sign_action ); ?></h2>
		<div class="signup--social-buttons">
			<button class="signup--social-button google"><svg class="logo-google"><use xlink:href="#logo-google" /></svg>Google</button>
			<button class="signup--social-button twitter"><svg class="logo-twitter"><use xlink:href="#logo-twitter" /></svg>Twitter</button>
			<button class="signup--social-button facebook"><svg class="logo-facebook"><use xlink:href="#logo-facebook" /></svg>Facebook</button>
			<button class="signup--social-button linkedin"><svg class="logo-linkedin"><use xlink:href="#logo-linkedin" /></svg>LinkedIn</button>
		</div>
	</section>
</div>
<?php do_action( 'pb_custom_signup_after_wrapper' ); ?>
</body>
</html>
