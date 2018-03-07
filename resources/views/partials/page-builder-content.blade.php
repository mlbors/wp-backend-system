@php
    global $settings;
    $currentPost = $settings[0]['current_post']['post'];
    $builderContent = $currentPost->getPageBuilderContent();
@endphp

@if (!empty($builderContent))
    {!! html_entity_decode($builderContent) !!}
@endif
