<div id="latest-titles" class="latest-books w-100">
  Page {{ $current_page }}
  Total: {{ App::totalPages(3) }}
  <h3 class="tc ttu">{{ $latest_books_title }}</h3>
  <div class="track flex flex-row flex-wrap justify-center items-center">
    <div class="books flex flex-column justify-center items-center order-0 order-1-l flex-row-l justify-between-l" data-total-pages="{{ App::totalPages(3) }}" data-next-page="2">
      @foreach(App::books($current_page, 3) as $book)
        <div class="book flex flex-column justify-end w-100">
          @if(isset($book['metadata']['keywords']))
          <p class="subject tc ma0">
            <a href="{{ network_home_url('/catalog/#') . $book['metadata']['keywords'] }}">{{ $book['metadata']['keywords'] }}</a>
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
    @if(App::previousPage($current_page))<a class="previous db mr-auto f1 order-1 order-0-l" data-page="{{ App::previousPage($current_page) }}" href="{{ network_home_url('/page/' . App::previousPage($current_page) . '/#latest-titles') }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/left-arrow.svg'))</a>@endif
    @if(App::nextPage($current_page, 3))<a class="next ml-auto order-2 db f1" data-page="{{ App::nextPage($current_page, 3) }}" href="{{ network_home_url('/page/' . App::nextPage($current_page, 3) . '/#latest-titles') }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/right-arrow.svg'))</a>@endif
  </div>
  <div class="catalog-link tc">
    <a class="button button-inverse button-wide" href="{{ network_home_url('/catalog/') }}">{{ __('View Complete Catalog', 'aldine') }}</a>
  </div>
</div>
