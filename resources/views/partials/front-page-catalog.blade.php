<div id="latest-titles" class="latest-books w-100">
  <h3 class="tc ttu">{{ $latest_books_title }}</h3>
  <div class="track flex flex-row flex-wrap justify-center items-center">
    <div class="books flex flex-column justify-center items-center order-0 order-1-l flex-row-l justify-between-l" data-total-pages="{{ $catalog_data['pages'] }}" @if($next_page <= $catalog_data['pages'])data-next-page="{{ $next_page }}"@endif>
      @foreach($catalog_data['books'] as $book)
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
    @if($previous_page)<a class="previous db mr-auto f1 order-1 order-0-l" data-page="{{ $previous_page }}" href="{{ network_home_url("/page/$previous_page/#latest-titles") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/left-arrow.svg'))</a>@endif
      @if($next_page <= $catalog_data['pages'])<a class="next ml-auto order-2 db f1" data-page="{{ $next_page }}" href="{{ network_home_url("/page/$next_page/#latest-titles") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/right-arrow.svg'))</a>@endif
  </div>
  <div class="catalog-link tc">
    <a class="button button-inverse button-wide" href="{{ network_home_url('/catalog/') }}">{{ __('View Complete Catalog', 'aldine') }}</a>
  </div>
</div>
