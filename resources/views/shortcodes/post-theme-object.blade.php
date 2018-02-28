<div class="single-post-theme-object-shortcode">
  <article class="h-entry" itemscope itemtype="http://schema.org/Article">

    @php
      $img = $data->getCoverImgUrl();
      $title = $data->getTitle();
      $date = $data->getDate();
      $content = $data->getContent();
    @endphp

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

  </article>
</div>