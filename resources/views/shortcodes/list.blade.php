@if ($data->have_posts())

  <div class="posts-list-shortcode">

    @while ($data->have_posts())

      @php 
        $data->the_post(); 
        $id = get_the_ID();
      @endphp

        <article class="h-entry" itemscope itemtype="http://schema.org/Article">

          @if (has_post_thumbnail($id))
            <div class="post-image">
              <img class="u-photo" itemprop="image" src="{{ esc_url(wp_get_attachment_image_src(get_post_thumbnail_id($id), 'medium')[0]) }}"/>
            </div>
          @endif

          <h2 class="post-title p-name" itemprop="name">{{ the_title() }}</h2>
          <time class="post-date dt-published" datetime="{{ the_time('Y-m-d H:i:s') }}" itemprop="dateCreated">{{ the_time('Y-m-d H:i:s') }}</time>
          <div class="post-summary p-summary" itemprop="text">
              {{ the_excerpt() }}
          </div>
          <div class="post-permalink">
              <a class="u-url" href="{{ the_permalink() }}" itemprop="url">See more</a>
          </div>
          
        </article>
      
    @endwhile

  </div>

@endif