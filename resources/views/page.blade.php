@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <section class="page-content">
      @include('partials.page-header')
      @include('partials.content-page')
    </section>
  @endwhile
@endsection
