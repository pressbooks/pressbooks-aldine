@extends('layouts.app')

@section('content')
  @if($block_count === 0)
    @component('partials.front-page-block', ['index' => 1])
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
    {!! $block['content'] !!}
    @endcomponent
  @elseif($block_count < 4)
    @foreach($blocks as $block)
      @component('partials.front-page-block', [
        'index' => $loop->iteration,
        'title' => (isset($block['title'])) ? $block['title'] : false,
        'button_title' => (isset($block['button_title'])) ? $block['button_title'] : false,
        'button_url' => (isset($block['button_url'])) ? $block['button_url'] : false,
      ])
      {!! $block['content'] !!}
      @endcomponent
    @endforeach
  @elseif($block_count === 4)
    <div class="one-two">
      @for($i = 0; $i < 2; $i++)
        @component('partials.front-page-block', [
          'index' => $i + 1,
          'title' => (isset($blocks[$i]['title'])) ? $blocks[$i]['title'] : false,
          'button_title' => (isset($blocks[$i]['button_title'])) ? $blocks[$i]['button_title'] : false,
          'button_url' => (isset($blocks[$i]['button_url'])) ? $blocks[$i]['button_url'] : false,
        ])
        {!! $blocks[$i]['content'] !!}
        @endcomponent
      @endfor
    </div>
    @for($i = 2; $i < $block_count; $i++)
      @component('partials.front-page-block', [
        'index' => $i + 1,
        'title' => (isset($blocks[$i]['title'])) ? $blocks[$i]['title'] : false,
        'button_title' => (isset($blocks[$i]['button_title'])) ? $blocks[$i]['button_title'] : false,
        'button_url' => (isset($blocks[$i]['button_url'])) ? $blocks[$i]['button_url'] : false,
      ])
      {!! $blocks[$i]['content'] !!}
      @endcomponent
    @endfor
  @endif
  @if(is_active_sidebar('front-page-block'))
    @component('partials.front-page-block', ['index' => 'custom', 'title' => false, 'button_title' => false, 'button_url' => false])
      @php(dynamic_sidebar('front-page-block'))
    @endcomponent
  @endif
  @if(get_option('pb_front_page_catalog'))
    @include('partials.front-page-catalog')
  @endif
@endsection
