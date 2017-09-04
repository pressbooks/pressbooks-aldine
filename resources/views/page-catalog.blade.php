@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  <section class="network-catalog">
    <div class="controls">
      <div class="search">
        <h2><a href="#search">{{ __('Search by titles or keyword', 'aldine') }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a></h2>
      </div>
      <div class="filters">
        <a href="#filter">{{ __('Filter by', 'aldine') }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
        <div id="filter" class="filter-groups">
          @foreach($subject_groups as $key => $val)
          <div class="{{ $key }} subjects" id="{{ $key }}">
            <a href="#{{ $key }}">{{ $val['title'] }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
            <ul class="filter-list">
              @foreach($val['subjects'] as $k => $v)
              <li><a data-filter="{{ $k }}">{{ $v }}<span class="close">&times;</span></a></li>
              @endforeach
            </ul>
          </div>
          @endforeach
          <div class="licenses" id="licenses">
            <a href="#licenses">{{ __('Licenses', 'aldine' ) }}<svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
            <ul class="filter-list">
              @foreach($licenses as $key => $value)
          		  <li><a data-filter="{{ $key }}">{{ $value }}<span class="close">&times;</span></a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="sort">
        <a href="#sort">{{ __('Sort by', 'aldine') }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
        <ul id="sort" class="sorts">
          <li><a class="is-active" href="#title">{{ __('Title', 'aldine') }}</a></li>
          <li><a href="#subject">{{ __('Subject', 'aldine') }}</a></li>
          <li><a href="#latest">{{ __('Latest', 'aldine') }}</a></li>
        </ul>
      </div>
    </div>
    <div class="books">
      @foreach(App::books($current_page, 9) as $book)
        @include('partials.book', ['book' => $book])
      @endforeach
    </div>
    <nav class="catalog-navigation">
      @if(App::previousPage($current_page))<a class="previous" data-page="{{ App::previousPage($current_page) }}" href="{{ network_home_url('/catalog/page/' . App::previousPage($current_page) . '/') }}">@php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/left-arrow.svg')) {{ __('Previous', 'aldine') }}</a>@endif
      <div class="pages">
      @for($i = 1; $i <= App::totalPages(9); $i++)
        @if($i === $current_page)
          <span class="current">{{ $i }}</span>
        @else
          <a href="{{ network_home_url("/catalog/page/$i/") }}">{{ $i }}</a>
        @endif
      @endfor
      </div>
      @if(App::nextPage($current_page, 9))<a class="next" data-page="{{ App::nextPage($current_page, 9) }}" href="{{ network_home_url('/catalog/page/' . App::nextPage($current_page, 9) . '/') }}">{{ __('Next', 'aldine') }} @php(include get_theme_file_path() . '/dist/' . Aldine\svg_path('images/right-arrow.svg'))</a>@endif
    </nav>
  </section>
@endsection
