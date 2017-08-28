<pre>::: SHORTCODE ::: list</pre>

<pre>
@php

print_r($data); 

if ($data['results']->have_posts()) {

    while ($data['results']->have_posts()) {

        $data['results']->the_post();

        echo get_the_title() . "<br />";

    }
    
}


@endphp
</pre>