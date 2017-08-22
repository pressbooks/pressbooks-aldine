@extends('layouts.app')

@section('content')
  @if($block_count < 5)
    @for($i = 0; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @elseif($block_count === 5)
    <div class="one-two">
      @for($i = 0; $i < 2; $i++)
        <div class="block block-{{ $i + 1 }}">
          <div class="inside">
            @php(dynamic_sidebar($home_blocks[$i]))
          </div>
        </div>
      @endfor
    </div>
    @for($i = 2; $i < $block_count; $i++)
      <div class="block block-{{ $i + 1 }}">
        <div class="inside">
          @php(dynamic_sidebar($home_blocks[$i]))
        </div>
      </div>
    @endfor
  @else
    <div class="block block-1">
      <div class="inside">
        <h3>{{ __('About Pressbooks', 'pressbooks-aldine')}}</h3>
        <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'pressbooks-aldine')}}</p>
      </div>
    </div>
  @endif
@endsection
