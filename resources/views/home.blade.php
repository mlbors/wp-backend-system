{{--
  Template Name: Home
--}}

@extends('layouts.app')

@section('content')

  <pre>
  {{-- FrontPage::globals() --}}
  </pre>

  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    @include('partials.content-page')
    @include('partials.page-builder-content')
  @endwhile
      
@endsection