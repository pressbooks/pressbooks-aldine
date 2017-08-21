<header class="banner">
  <div class="container">
    <a class="toggle-menu" href="#primary-navigation">Toggle menu<span class="icon"></span></a>
    <nav id="primary-navigation" class="primary-navigation">
        <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
        <a href="{{ home_url('/catalog') }}">Catalog</a>
        <a href="#contact">Contact</a>
        <a href="{{ wp_login_url() }}">{{ __('Sign in') }}</a>
        <a href="{{ network_home_url('/wp-signup.php') }}">{{ __('Sign up') }}</a>
    </nav>
    <div class="branding">
      <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
      <h2>{{ get_bloginfo('description', 'display') }}</h2>
    </div>
  </div>
</header>
