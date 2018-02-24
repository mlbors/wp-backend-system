@if (!empty($data['action']) && $data['action'] !== 'none')

  @if ($data['action'] === 'image-link')
    <a href="{{ $data['url'] }}" target="{{ $data['target'] }}" class="{{ $data['action'] }}" data-action="{{ $data['action'] }}" title="{{ $data['name'] }}">
  @elseif ($data['action'] === 'link')
    <a href="{{ $data['link'] }}" target="{{ $data['target'] }}" class="{{ $data['action'] }}" data-action="{{ $data['action'] }}" title="{{ $data['name'] }}">
  @elseif ($data['action'] === 'lightbox')
    <a href="#" target="{{ $data['target'] }}" class="{{ $data['action'] }}" data-action="{{ $data['action'] }}" title="{{ $data['name'] }}">
  @endif

@endif

<img src="{{ $data['url'] }}" alt="{{ $data['name'] }}" />

@if (!empty($data['action']) && $data['action'] !== 'none')
  </a>
@endif