@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, but the page you were trying to view does not exist.', 'aldine') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  {!! get_the_posts_navigation() !!}
@endsection
