<div class="block latest-books">
  <div class="inside">
    <h3>{{ $latest_books_title }}</h3>
    <div class="books">
      @foreach( FrontPage::latestBooks( $current_page ) as $book )
        <div class="book">
            <a class="subject" href="">TK</a>
            <a class="title" href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
            <a class="read-more" href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
        </div>
      @endforeach
    </div>
    <div class="navigation mt2">
      @if($previous_page)
        <a class="previous f1" href="{{ network_home_url("/page/$previous_page/") }}">&larr;</a>
      @endif
      @if($next_page)
        <a class="next f1" href="{{ network_home_url("/page/$next_page/") }}">&rarr;</a>
      @endif
    </div>
  </div>
</div>
