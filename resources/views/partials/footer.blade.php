<footer class="content-info">
  <div class="container">
    @php(dynamic_sidebar('sidebar-footer'))
    <section class="powered-by">
      <a class="pressbooks-icon" href="https://pressbooks.com" title="Pressbooks"><img src="@asset('images/pb.png')" srcset="1x @asset('images/pb.png'), 2x @asset('images/pb@2x.png')" alt="{{ __('The Pressbooks logo', 'aldine')}}" width="45" height="44" /></a>
      <div class="pressbooks-links">
        <h1><a href="https://pressbooks.com">{!! sprintf(__('Powered by %s', 'aldine'), '<span class="pressbooks">Pressbooks</span>') !!}</a></h1>
        <ul>
          <li><a href="https://github.com/pressbooks" title="{{ __('Open Source', 'aldine') }}">{{ __('Open Source', 'aldine') }}</a></li>
          <li><a href="https://github.com/pressbooks" title="{{ __('Open Textbooks', 'aldine') }}">{{ __('Open Textbooks', 'aldine') }}</a></li>
          <li><a href="https://github.com/pressbooks" title="{{ __('Open Book Publishing', 'aldine') }}">{{ __('Open Book Publishing', 'aldine') }}</a></li>
          <li><a href="https://github.com/pressbooks" title="{{ __('Learn More', 'aldine') }}">{{ __('Learn More', 'aldine') }}</a></li>
        </ul>
      </div>
      <div class="social-media">
        <a class="facebook" href="https://facebook.com/pressbooks2" title="{{ __('Pressbooks on Facebook', 'aldine') }}"><i class="fa fa-facebook-official"></i></a>
        <a class="twitter" href="https://twitter.com/intent/follow?screen_name=pressbooks" title="{{ __('Pressbooks on Twitter', 'aldine') }}"><i class="fa fa-twitter"></i></a>
      </div>
    </section>
  </div>
</footer>
