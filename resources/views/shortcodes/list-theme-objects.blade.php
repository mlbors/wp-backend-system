@if (!empty($data) && is_array($data) && count(array_filter($data)) > 0)

  <div class="posts-list-theme-object-shortcode">

    @foreach ($data as $i => $item)

      @php 
        $img = $item->getCoverImgUrl();
        $title = $item->getTitle();
        $date = $item->getDate();
        $content = $item->getContent();
        $permalink = $item->getPermalink();
      @endphp

        <article class="h-entry" itemscope itemtype="http://schema.org/Article">

          @if ($img)
            <div class="post-image">
                <img class="u-photo" itemprop="image" src="{{ $img }}" />
            </div>
          @endif
          
          <h2 class="post-title p-name" itemprop="name">{{ $title }}</h2>
          <time class="post-date dt-published" datetime="{{ $date }}" itemprop="dateCreated">{{ $date }}</time>
          <div class="post-content e-entry" itemprop="text">
              {{ $content }}
          </div>

          <div class="post-permalink">
              <a class="u-url" href="{{ $permalink }}" itemprop="url">See more</a>
          </div>

        </article>
      
    @endforeach

  </div>

@endif