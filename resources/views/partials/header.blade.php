<section class="banner bg-bottom cover">
  <div class="container flex flex-column justify-between items-center w-100 mw-100">
    <a class="toggle-menu db dn-l absolute" href="#primary-navigation">{{ __('Toggle menu', 'aldine') }}<span class="icon db absolute"></span></a>
    <a class="brand db self-start self-center-l" href="{{ home_url('/') }}"><span class="clip>"{{ get_bloginfo('name', 'display') }}</a></a>
    <nav id="primary-navigation" class="primary-navigation absolute flex flex-column justify-center items-start top-0 w-100 bg-transparent bg-animate flex-row-l justify-start-l items-center-l">
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
    <header class="branding flex flex-column justify-start items-center tc">
      <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
      <p>{{ get_bloginfo('description', 'display') }}</p>
    </header>
  </div>
</section>
