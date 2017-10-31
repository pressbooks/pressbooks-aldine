<section class="banner" style="background-image: url(@if(is_front_page())
  @php(header_image())
@else
  @asset('images/catalog-header.jpg')
@endif);">
  <div class="container">
    <a class="toggle" href="#navigation">{{ __('Toggle menu', 'aldine') }}<span class="toggle__icon"></span></a>
    <a class="banner__brand" href="{{ home_url('/') }}"><span class="clip">{{ get_bloginfo('name', 'display') }}</span>{!! $site_logo !!}</a>
    <nav class="banner__navigation" id="navigation">
        @if(function_exists('pb_meets_minimum_requirements') && pb_meets_minimum_requirements())
          <a class="banner__navigation--catalog" href="{{ home_url('/catalog') }}">Catalog</a>
        @endif
        @if(get_option('pb_network_contact_form'))
          <a class="banner__navigation--contact" href="#contact">Contact</a>
        @endif
        @if(!is_user_logged_in())
          <a class="banner__navigation--signin" href="{{ wp_login_url() }}">{{ __('Sign in', 'aldine') }}</a>
          <span class="banner__navigation--sep">/</span>
          <a class="banner__navigation--signup" href="{{ network_home_url('/wp-signup.php') }}">{{ __('Sign up', 'aldine') }}</a>
        @else
          <a class="banner__navigation--admin" href="{{ admin_url() }}">{{ __('Admin', 'aldine') }}</a>
          <span class="banner__navigation--sep">/</span>
          <a class="banner__navigation--signout" href="{{ wp_logout_url() }}">{{ __('Sign out', 'aldine') }}</a>
        @endif
    </nav>
    <header class="banner__branding">
      <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
      <p>{{ get_bloginfo('description', 'display') }}</p>
    </header>
  </div>
</section>
