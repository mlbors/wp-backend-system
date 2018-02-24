<meta name="description" content="{{ $data['description'] }}" />
<meta name="keywords" content="{{ $data['keywords'] }}" />
<meta name="author" content="{{ $data['author'] }}" />
<meta name="date" content="{{ $data['date'] }}" scheme="YYYY-MM-DD H:i:s">
<meta name="modified" content="{{ $data['modified'] }}" scheme="YYYY-MM-DD H:i:s">

<meta itemprop="name" content="{{ $data['title'] }}" />
<meta itemprop="description" content="{{ $data['description'] }}" />
<meta itemprop="image" content="{{ $data['image'] }}" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $data['title'] }}" />
<meta name="twitter:description" content="{{ $data['description'] }}'" />
<meta name="twitter:image:src" content="{{ $data['image'] }}" />

<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $data['title'] }}" />
<meta property="og:url" content="{{ $data['permalink'] }}" />
<meta property="og:image" content="{{ $data['image'] }}" />
<meta property="og:description" content="{{ $data['description'] }}" />
<meta property="og:site_name" content="{{ $data['site_name'] }}" />