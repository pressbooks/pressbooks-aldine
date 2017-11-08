{{--
  Template Name: Catalog
--}}

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
            <a href="#{{ $key }}">{{ $val['label'] }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
            <ul class="filter-list">
              @foreach($val['children'] as $k => $v)
              @if(strlen($k) === 2)
                <li><a data-filter="{{ $k }}">{{ $v }}<span class="close">&times;</span></a></li>
              @endif
              @endforeach
            </ul>
          </div>
          @endforeach
        </div>
        <div class="licenses" id="licenses">
          <a href="#licenses">{{ __('Licenses', 'aldine' ) }}<svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
          <ul class="filter-list">
            @foreach($licenses as $key => $value)
              <li><a data-filter="{{ $key }}">{{ $value }}<span class="close">&times;</span></a></li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="sort">
        <a href="#sort">{{ __('Sort by', 'aldine') }} <svg class="arrow" width="13" height="8" viewBox="0 0 13 8" xmlns="http://www.w3.org/2000/svg"><path d="M6.255 8L0 0h12.51z" fill="#b01109" fill-rule="evenodd"/></svg></a>
        <ul id="sort" class="sorts">
          <li><a data-sort="title" href="{{ "/catalog/page/$current_page/?orderby=title" }}">{{ __('Title', 'aldine') }}</a></li>
          <li><a data-sort="subject" href="{{ "/catalog/page/$current_page/?orderby=subject" }}">{{ __('Subject', 'aldine') }}</a></li>
          <li><a data-sort="latest" href="{{ "/catalog/page/$current_page/?orderby=latest" }}">{{ __('Latest', 'aldine') }}</a></li>
        </ul>
      </div>
    </div>
    <div class="books">
      @foreach($catalog_data['books'] as $book)
        @include('partials.book', ['book' => $book])
      @endforeach
    </div>
    @if($catalog_data['pages'] > 1)
    <nav class="catalog-navigation">
      @if($previous_page)<a class="previous" data-page="{{ $previous_page }}" href="{{ network_home_url("/catalog/page/$previous_page/") }}">@php(include get_theme_file_path() . '/dist/' . Aldine\asset_dir('images/left-arrow.svg')) {{ __('Previous', 'aldine') }}</a>@endif
      <div class="pages">
      @for($i = 1; $i <= $catalog_data['pages']; $i++)
        @if($i === $current_page)
          <span class="current">{{ $i }}</span>
        @else
          <a href="{{ network_home_url("/catalog/page/$i/") }}">{{ $i }}</a>
        @endif
      @endfor
      </div>
      @if($next_page <= $catalog_data['pages'])<a class="next" data-page="{{ $next_page }}" href="{{ network_home_url("/catalog/page/$next_page/") }}">{{ __('Next', 'aldine') }} @php(include get_theme_file_path() . '/dist/' . Aldine\asset_dir('images/right-arrow.svg'))</a>@endif
    </nav>
    @endif
  </section>
@endsection
