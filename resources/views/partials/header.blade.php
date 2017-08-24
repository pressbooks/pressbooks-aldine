<header class="banner">
  <div class="container">
    <a class="toggle-menu" href="#primary-navigation">Toggle menu<span class="icon"></span></a>
    <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <nav id="primary-navigation" class="primary-navigation">
        <a class="catalog" href="{{ home_url('/catalog') }}">Catalog</a>
        <a class="contact" href="#contact">Contact</a>
        @if(!is_user_logged_in())
          <a class="signin" href="{{ wp_login_url() }}">{{ __('Sign in', 'aldine') }}</a>
          <span class="sep">/</span>
          <a class="signup" href="{{ network_home_url('/wp-signup.php') }}">{{ __('Sign up', 'aldine') }}</a>
        @else
          <a class="admin" href="{{ admin_url() }}">{{ __('Admin', 'aldine') }}</a>
          <span class="sep">/</span>
          <a class="signin" href="{{ wp_logout_url() }}">{{ __('Sign out', 'aldine') }}</a>
        @endif
    </nav>
    <div class="branding">
      <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
      <h2>{{ get_bloginfo('description', 'display') }}</h2>
    </div>
  </div>
</header>
