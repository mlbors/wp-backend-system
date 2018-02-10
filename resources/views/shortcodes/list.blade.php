<pre>::: SHORTCODE ::: list</pre>

<pre>
@php

{{-- print_r($data); --}}

if ($data->have_posts()) {

    while ($data->have_posts()) {

        $data->the_post();

        echo get_the_title() . "<br />";

    }
    
}

@endphp
</pre>