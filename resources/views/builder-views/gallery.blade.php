@php
  $row = 1;
  $cell = 1;
  $nbImages = 0;
@endphp

<div class="gallery-wrapper">
  @foreach ($data['images'] as $i => $image)

    @if ($cell === 1)
      <div class="row gallery-row">
    @endif

      <div class="col-md-{{ $data['col_size'] }}">

        @if (!empty($data['action']) && $data['action'] !== 'none')

          @if ($data['action'] === 'image-link')
            <a href="{{ $image['url'] }}" target="{{ $data['target'] }}" class="{{ $data['action'] }}" data-action="{{ $data['action'] }}" title="{{ $image['name'] }}">
          @elseif ($data['action'] === 'lightbox')
            <a href="#" target="{{ $data['target'] }}" class="{{ $data['action'] }}" data-action="{{ $data['action'] }}" title="{{ $image['name'] }}">
          @endif

              <img src="{{ $image['thumbnail'] }}" alt="{{ $image['name'] }}" />

            </a>

        @else
          <img src="{{ $image['url'] }}" alt="{{ $image['name'] }}" />
        @endif

      </div>

    @if ($cell === $data['items_per_row'] || $nbImages === count($data['images']) - 1)
      </div>
      @php
        $cell = 1;
        $row++
      @endphp
    @else
      @php
        $cell++;
      @endphp
    @endif

    @php
      $nbImages++;
    @endphp

  @endforeach
</div>