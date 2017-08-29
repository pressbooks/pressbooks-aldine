<div class="block latest-books w-100">
  <div class="inside">
    <h3 class="tc ttu">{{ $latest_books_title }}</h3>
    <div class="books flex flex-column justify-center flex-row-m justify-between-m" data-total-pages="{{ $total_pages }}" data-next-page="2">
      @foreach(FrontPage::latestBooks( $current_page, 3 ) as $book)
        <div class="book w-100">
          <p class="subject tc ma0">
            <a href="">Fiction</a>
          </p>
          <p class="title tc ma0">
            <a href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
          </p>
          <p class="read-more tl ma0">
            <a href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
          </p>
        </div>
      @endforeach
    </div>
    <nav class="navigation flex flex-row justify-between mt2 tr" data-total="{{ $total_pages }}">
      <a class="previous f1 @if(!$previous_page) slick-disabled @endif" data-page="{{ $previous_page }}" href="{{ network_home_url("/page/$previous_page/") }}">&larr;</a>
      <a class="next f1" data-page="{{ $next_page }}" href="{{ network_home_url("/page/$next_page/") }}">&rarr;</a>
    </nav>
    <div class="catalog-link tc">
      <a class="button button-outline button-wide" href="{{ network_home_url('/catalog/') }}">{{ __('View Complete Catalog', 'aldine') }}</a>
    </div>
  </div>
</div>
