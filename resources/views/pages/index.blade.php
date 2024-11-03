@extends('default')
@section('content')
    <div class="page-common">
        @include("partials.header")
        <div class="body-container">
            @include("pages.new-home.menu")
            @if(!Auth::check() || (Auth::check() && Auth::User()->plan_id == 0))
            <div class="ads-banner">
                <div style="display:flex;justify-content:center;">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
                        crossorigin="anonymous"></script>
                    <ins class="adsbygoogle"
                        style="display:inline-block;width:728px;height:80px !important"
                        data-ad-client="ca-pub-7220843961648970"
                        data-ad-slot="6041774171">
                    </ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            @endif
            <div class="area-video">
                <div id="layer-loading-page">
                    <div class="loader"></div>
                </div>
                <div class="wr-component-video-reel">
                    <div class="component-video-reel">
                        <div class="swiper-reel">
                            <div class="swiper-wrapper" id="append-list-video">
                            </div>
                        </div>
                    </div>
                    @if(!Auth::check() || (Auth::check() && Auth::User()->plan_id == 0))
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
                            crossorigin="anonymous"></script>
                        <ins class="adsbygoogle"
                            style="display:inline-block;width:120px;height:1000px !important;positon:fixed !important;"
                            data-ad-client="ca-pub-7220843961648970"
                            data-ad-slot="6041774171">
                        </ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

