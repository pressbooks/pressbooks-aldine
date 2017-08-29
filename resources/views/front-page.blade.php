@extends('layouts.app')

@section('content')
  <section class="blocks blocks-{{ $block_count }}">
  @if(is_active_sidebar('front-page-block'))
    @php(dynamic_sidebar('front-page-block'))
  @else
    @component('front-page-block')
      @slot('title')
        {{ __('About Pressbooks', 'aldine') }}
      @endslot
      <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'aldine')}}</p>
      @slot('button_title')
        {{ __('Learn More', 'aldine') }}
      @endslot
      @slot('button_url')
        {{ network_home_url('/about/') }}
      @endslot
    @endcomponent
  @endif
  @if(get_option('pb_front_page_catalog'))
    @include('partials.front-page-catalog')
  @endif
  </section>
@endsection
