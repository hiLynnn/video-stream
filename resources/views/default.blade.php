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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap" rel="stylesheet">
    <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('build/css/common.css') }}">
    <link rel="icon" href="{{ URL::asset('/'.getcong('site_favicon')) }}">
    {{-- title page --}}
    <link rel="icon" href="{{ URL::asset('/'.getcong('site_favicon')) }}">
    <link rel="image_src" href="@yield('head_image', URL::asset('/'.getcong('site_logo')))">

    <!-- ads -->
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
    crossorigin="anonymous"></script>
    <meta name="google-adsense-account" content="ca-pub-7220843961648970">
    <title>Video stream</title>
</head>
<body>
    @yield("content")
    <div id="modal-popup" class="video-model">
        <div class="wr-relative">
            <div class="video-model-layer"></div>
            <div class="video-model-content">
                <div style="position: relative;height: 100%;">
                    <div class="layer-loading-page">
                        <div class="loader"></div>
                    </div>
                    <div class="modal-header">
                        <span>
                            <img src="{{asset('site_assets/icon/close.svg')}}" alt="">
                        </span>
                    </div>
                    <div id="append-html-modal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('site_assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ URL::asset('site_assets/js/jquery.easing.min.js') }}"></script>
    <script src="https://vjs.zencdn.net/8.16.1/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/js/common.js') }}"></script>
</body>
</html>
