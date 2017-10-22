<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class('no-js'))>
    @include('partials.uio')
    @php(do_action('get_header'))
    @include('partials.header')
    <div class="wrap container" role="document">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
      </div>
    </div>
    @php(do_action('get_footer'))
    @include('partials.footer')
    @php(wp_footer())
    @include('partials.uio-script')
  </body>
</html>
