@php
  $row = 1;
  $cell = 1;
  $nbImages = 0;
  $itemsPerRow = 4;
  $colSize = 12/$itemsPerRow;
@endphp

<div class="gallery-shortcode gallery-wrapper">
  @foreach ($data as $i => $image)

    @if ($cell === 1)
      <div class="row gallery-row">
    @endif

      <div class="col-md-{{ $colSize }}">
        <a href="{{ $image['image_data']['full_path'] }}" target="_blank" class="image-link">
          <img src="{{ $image['image_data']['sizes']['medium']['full_path'] }}"  class="image-thumbnail" />
        </a>
      </div>

    @if ($cell === $itemsPerRow || $nbImages === count($data) - 1)
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