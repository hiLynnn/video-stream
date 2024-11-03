<!DOCTYPE html>
<html lang="{{getcong('default_language')}}">
<head>
{{-- META --}}
<meta name="theme-color" content="#ff0015">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="author" content="">
<meta name="description" content="@yield('head_description', getcong('site_description'))" />
<meta name="keywords" content="@yield('head_keywords', getcong('site_keywords'))" />
<meta property="og:type" content="movie" />
<meta property="og:title" content="@yield('head_title',  getcong('site_name'))" />
<meta property="og:description" content="@yield('head_description', getcong('site_description'))" />
<meta property="og:image" content="@yield('head_image', URL::asset('/'.getcong('site_logo')))" />
<meta property="og:url" content="@yield('head_url', url('/'))" />
<meta property="og:image:width" content="1024" />
<meta property="og:image:height" content="1024" />
<meta name="csrf-token" content="{{csrf_token()}}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="@yield('head_image', URL::asset('/'.getcong('site_logo')))">
<meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport">
{{-- script && css --}}
<link rel="canonical" href="@yield('head_url', url('/'))">
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap" rel="stylesheet">
<link rel="icon" href="{{ URL::asset('/'.getcong('site_favicon')) }}">
<link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="{{ URL::asset('build/css/common.css') }}">
{{-- title page --}}
<link rel="icon" href="{{ URL::asset('/'.getcong('site_favicon')) }}">
<link rel="image_src" href="@yield('head_image', URL::asset('/'.getcong('site_logo')))">
<title>@yield('head_title', getcong('site_name'))</title>

<!-- ads -->
<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
crossorigin="anonymous"></script>
<meta name="google-adsense-account" content="ca-pub-7220843961648970">
</head>
<body>
@yield("content")
<script src="{{ URL::asset('site_assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ URL::asset('site_assets/js/jquery.easing.min.js') }}"></script>
<script src="https://vjs.zencdn.net/8.16.1/video.min.js"></script>
<script src="{{ URL::asset('build/js/common.js') }}"></script>
</body>
</html>
