@extends('layouts.app')

@section('content')
  <div class="block block-one">
    @php(dynamic_sidebar('home-block-one'))
  </div>
  <div class="block block-two">
    @php(dynamic_sidebar('home-block-two'))
  </div>
  <div class="block block-three">
    @php(dynamic_sidebar('home-block-three'))
  </div>
  <div class="block block-four">
    @php(dynamic_sidebar('home-block-four'))
  </div>
  <div class="block block-five">
    @php(dynamic_sidebar('home-block-five'))
  </div>
@endsection
