<div class="latest-books w-100">
  <h3 class="tc ttu">{{ $latest_books_title }}</h3>
  <div class="track flex flex-row flex-wrap justify-center items-center">
    <div class="books flex flex-column justify-center items-center order-0 order-1-l flex-row-l justify-between-l @if($current_page === 1){{ 'ml-auto' }}@elseif(!$next_page){{ 'mr-auto' }}@endif" data-total-pages="{{ $total_pages }}" data-next-page="2">
      @foreach(FrontPage::latestBooks( $current_page, 3 ) as $book)
        <div class="book flex flex-column justify-end w-100 bg-secondary b--secondary">
          @if(isset($book['metadata']['keywords']))
          <p class="subject tc ma0">
            <a href="#">{{ $book['metadata']['keywords'] }}</a>
          </p>
          @endif
          <p class="title tl ma0">
            <a href="{{ $book['link'] }}">{{ $book['metadata']['name'] }}</a>
          </p>
          <p class="read-more tl ma0">
            <a href="{{ $book['link'] }}">{{ __('About this book &rarr;', 'aldine') }}</a>
          </p>
        </div>
      @endforeach
    </div>
    @if($previous_page)<a class="secondary previous db mr-auto f1 order-1 order-0-l" data-page="{{ $previous_page }}" href="{{ network_home_url("/page/$previous_page/") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/left-arrow.svg'))</a>@endif
    @if($next_page)<a class="secondary next ml-auto order-2 db f1" data-page="{{ $next_page }}" href="{{ network_home_url("/page/$next_page/") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/right-arrow.svg'))</a>@endif
  </div>
  <div class="catalog-link tc">
    <a class="button button-primary button-outline button-wide" href="{{ network_home_url('/catalog/') }}">{{ __('View Complete Catalog', 'aldine') }}</a>
  </div>
</div>
