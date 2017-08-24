@extends('layouts.app')

@section('content')
  @if($block_count === 0)
    <div class="block block-1">
      <div class="inside">
        <h3>{{ __('About Pressbooks', 'aldine')}}</h3>
        <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'aldine')}}</p>
      </div>
    </div>
  @elseif($block_count < 5)
    @for($i = 0; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @elseif($block_count === 5)
    <div class="one-two">
      @for($i = 0; $i < 2; $i++)
        <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
          <div class="inside">
            @php(dynamic_sidebar($home_blocks[$i]))
          </div>
        </div>
      @endfor
    </div>
    @for($i = 2; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}@if($latest_books_block === $home_blocks[$i]) latest-books @endif">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @endif
@endsection
