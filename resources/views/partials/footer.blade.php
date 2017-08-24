<footer class="content-info">
  <div class="container">
    <section class="network-footer">
      @if(is_active_sidebar('network-footer-block-1'))
        <div class="network-footer-block network-footer-block-1">
          @php(dynamic_sidebar('network-footer-block-1'))
        </div>
      @endif
      @if(is_active_sidebar('network-footer-block-2'))
        <div class="network-footer-block network-footer-block-2">
          @php(dynamic_sidebar('network-footer-block-2'))
        </div>
      @endif
      <div class="network-footer-block network-footer-menu">
        @php(wp_nav_menu('network-footer-menu'))
      </div>
    </section>
    <section class="pressbooks-footer">
      <a class="pressbooks-icon" href="https://pressbooks.com" title="Pressbooks">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/pb.svg'))</a>
      <div class="pressbooks-links">
        <h1><a href="https://pressbooks.com">{!! sprintf(__('Powered by %s', 'aldine'), '<span class="pressbooks">Pressbooks</span>') !!}</a></h1>
        <ul>
          <li>{{ __('Open Source', 'aldine') }}</li>
          <li>{{ __('Open Textbooks', 'aldine') }}</li>
          <li>{{ __('Open Book Publishing', 'aldine') }}</li>
          <li>{{ __('Learn More', 'aldine') }}</li>
        </ul>
      </div>
      <div class="social-media">
        <a class="facebook" href="https://facebook.com/pressbooks2" title="{{ __('Pressbooks on Facebook', 'aldine') }}"><i class="fa fa-facebook-official"></i></a>
        <a class="twitter" href="https://twitter.com/intent/follow?screen_name=pressbooks" title="{{ __('Pressbooks on Twitter', 'aldine') }}"><i class="fa fa-twitter"></i></a>
      </div>
    </section>
  </div>
</footer>
