@extends('layouts.app')

@section('content')
  <div class="banner-one"></div>
  <div class="banner-two"></div>
  <div class="one-two">
    <div class="block one">
      <div class="inside">
      @if(is_active_sidebar('home-block-one'))
        @php(dynamic_sidebar('home-block-one'))
      @else
        <h3>{{ __('Welcome', 'pressbooks-aldine')}}</h3>
        <p>{{ __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'pressbooks-aldine')}}</p>
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
  </div>
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
