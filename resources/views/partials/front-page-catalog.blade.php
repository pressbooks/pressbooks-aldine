<div class="block latest-books">
  <div class="inside">
    <h3>{{ $latest_books_title }}</h3>
    <div class="books">
      @foreach( FrontPage::latestBooks( $current_page ) as $book )
        <div class="book">
            <a class="subject" href="">Fiction</a>
            <a class="title" href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
            <a class="read-more" href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
        </div>
      @endforeach
    </div>
    <nav class="navigation mt2" data-total="{{ $total_pages }}">
      @if($previous_page)
        <a class="previous f1" data-page="{{ $previous_page }}" href="{{ network_home_url("/page/$previous_page/") }}">&larr;</a>
      @endif
      @if($next_page)
        <a class="next f1" data-page="{{ $next_page }}" href="{{ network_home_url("/page/$next_page/") }}">&rarr;</a>
      @endif
    </nav>
  </div>
</div>
