{{--
  Template Name: Home
--}}

@extends('layouts.app')

@section('content')

  <pre>
  {{ FrontPage::globals() }}
  </pre>

  @php
    global $settings;
    $currentPost = $settings[0]['current_post']['post'];
    $builderContent = $currentPost->getPageBuilderContent();
  @endphp

  @if (!empty($builderContent))
    {!! html_entity_decode($builderContent) !!}
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    @include('partials.content-page')
  @endwhile

    {{-- 
    @if(!empty($sections))
    @foreach($sections as $section)
      <section id="{{ $section->post_name }}" class="page-section home-section">
        {{ $section->post_title }}
        @php echo apply_filters('the_content', $section->post_content); @endphp
      </section>
    @endforeach
  @endif
  --}}
      
@endsection