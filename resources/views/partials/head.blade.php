<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @php
    global $settings;
    $currentPost = $settings[0]['current_post']['post'];
    echo $currentPost->getMetaTags();
  @endphp

  @php(wp_head())
</head>
