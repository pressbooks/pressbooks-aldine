<div id="latest-titles" class="latest-books">
  <h3>{{ $latest_books_title }}</h3>
  <div class="track">
    <div class="books" data-total-pages="{{ $catalog_data['pages'] }}" @if($next_page <= $catalog_data['pages'])data-next-page="{{ $next_page }}"@endif>
      @foreach($catalog_data['books'] as $book)
        @include('partials.book', ['book' => $book])
      @endforeach
    </div>
    @if($previous_page)<a class="previous" data-page="{{ $previous_page }}" href="{{ network_home_url("/page/$previous_page/#latest-titles") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/left-arrow.svg'))</a>@endif
      @if($next_page <= $catalog_data['pages'])<a class="next" data-page="{{ $next_page }}" href="{{ network_home_url("/page/$next_page/#latest-titles") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/right-arrow.svg'))</a>@endif
  </div>
  <div class="catalog-link">
    <a class="button button-inverse button-wide" href="{{ network_home_url('/catalog/') }}">{{ __('View Complete Catalog', 'aldine') }}</a>
  </div>
</div>
