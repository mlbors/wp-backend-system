<div class="single-post-shortcode">
  <article class="h-entry" itemscope itemtype="http://schema.org/Article">

    @if (has_post_thumbnail($data->ID))
      <div class="post-image">
        <img class="u-photo" itemprop="image" src="{{ esc_url(wp_get_attachment_image_src(get_post_thumbnail_id($data->ID), 'medium')[0]) }}"/>
      </div>
    @endif
    
    <h2 class="post-title p-name" itemprop="name">{{ $data->post_title }}</h2>
    <time class="post-date dt-published" datetime="{{ $data->post_date }}" itemprop="dateCreated">{{ $data->post_date }}</time>
    <div class="post-content e-entry" itemprop="text">
        {{ $data->post_content }}
    </div>
    
  </article>
</div>