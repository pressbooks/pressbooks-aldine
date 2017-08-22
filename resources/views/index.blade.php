@extends('layouts.app')

@section('content')
  @debug('dump')
  @if(is_active_sidebar('home-block-one') && is_active_sidebar('home-block-two'))
  <div class="one-two">
  @endif
    <div class="block one">
      <div class="inside">
      @if(is_active_sidebar('home-block-one'))
        @php(dynamic_sidebar('home-block-one'))
      @else
        <h3>{{ __('About Pressbooks', 'pressbooks-aldine')}}</h3>
        <p>{{ __('Pressbooks is easy-to-use book writing software that lets you create a book in all the formats you need to publish.', 'pressbooks-aldine')}}</p>
      @endif
      </div>
    </div>
    @if(is_active_sidebar('home-block-two'))
      <div class="block two">
        <div class="inside">
        @php(dynamic_sidebar('home-block-two'))
        </div>
      </div>
    @endif
  @if(is_active_sidebar('home-block-one') && is_active_sidebar('home-block-two'))
  </div>
  @endif
  @if(is_active_sidebar('home-block-three'))
  <div class="block three">
    <div class="inside">
    @php(dynamic_sidebar('home-block-three'))
    </div>
  </div>
  @endif
  @if(is_active_sidebar('home-block-four'))
  <div class="block four">
    <div class="inside">
    @php(dynamic_sidebar('home-block-four'))
    </div>
  </div>
  @endif
  @if(is_active_sidebar('home-block-five'))
  <div class="block five">
    <div class="inside">
    @php(dynamic_sidebar('home-block-five'))
    </div>
  </div>
  @endif
@endsection
