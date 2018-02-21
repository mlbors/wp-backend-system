<pre>::: SHORTCODE ::: list theme objects</pre>

<pre>
@php
print_r($data);
@endphp

@foreach ($data as $i => $item)
    <p>{{ $item->getExcerpt() }}</p>
@endforeach

</pre>

