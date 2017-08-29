@extends('layouts.app')

@section('content')
  @if($block_count === 0)
    <div class="block block-1 flex flex-column items-center justify-center p-0 w-100">
      <div class="inside">
        <h3>{{ __('About Pressbooks', 'aldine') }}</h3>
        <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'aldine')}}</p>
      </div>
    </div>
  @elseif($block_count < 4)
    @for($i = 0; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }} flex flex-column items-center justify-center p-0 w-100">
        <div class="inside tc">
          @php(dynamic_sidebar($blocks[$i]))
        </div>
      </div>
    @endfor
  @elseif($block_count === 4)
    <div class="one-two">
      @for($i = 0; $i < 2; $i++)
        <div class="block block-{{ $i + 1 }} flex flex-column items-center justify-center p-0 w-100">
          <div class="inside tc">
            @php(dynamic_sidebar($blocks[$i]))
          </div>
        </div>
      @endfor
    </div>
    @for($i = 2; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }} flex flex-column items-center justify-center p-0 w-100">
        <div class="inside tc">
          @php(dynamic_sidebar($blocks[$i]))
        </div>
      </div>
    @endfor
  @endif
  @if(get_theme_mod('pb_front_page_catalog'))
    @include('partials.front-page-catalog')
  @endif
@endsection
