@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())

    @php
      global $settings;
      echo '<pre>';
      print_r($settings);
      echo '</pre>';
    @endphp

    @include('partials.content-single-'.get_post_type())
  @endwhile
@endsection
