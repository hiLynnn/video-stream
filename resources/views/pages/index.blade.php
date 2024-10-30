@extends('default')
@php
    $arr = [
        '',''
    ];
@endphp

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
                <div class="wr-component-video-reel">
                    <div class="component-video-reel">
                        <div class="swiper-reel">
                            <div class="swiper-wrapper">
                                @foreach ($data['upcoming_movies'] as $index => $item)
                                    <div class="swiper-slide">
                                        <div class="slide-item-wr">
                                            <div class="component-video-element">
                                                <video
                                                    id="my-video"
                                                    class="video-js"
                                                    controls
                                                    preload="auto"
                                                    poster="{{ asset($item->video_image_thumb) }}"
                                                    data-setup="{}"
                                                >
                                                    <source src="{{ asset($item->video_url) }}" type="video/mp4"/>
                                                </video>
                                            </div>
                                            <div class="button-group-bar">
                                                <div class="btn-grp-item">
                                                    <div class="btn-icon-circle">
                                                        <img src="{{asset('site_assets/icon/heart-no-fill.svg')}}" alt="icon" class="item-no-active">
                                                        <img src="{{asset('site_assets/icon/heart-fill.svg')}}" alt="icon" class="item-active">
                                                    </div>
                                                    <span class="title">357.8k</span>
                                                </div>
                                                <div class="btn-grp-item">
                                                    <div class="btn-icon-circle">
                                                        <img src="{{asset('site_assets/icon/comment.svg')}}" alt="icon" >
                                                    </div>
                                                    <span class="title">357.8k</span>
                                                </div>
                                                {{-- <div class="btn-grp-item">
                                                    <div class="btn-icon-circle">
                                                        <img src="{{asset('site_assets/icon/book.svg')}}" alt="icon" >
                                                    </div>
                                                </div> --}}
                                                <div class="btn-grp-item">
                                                    <div class="btn-icon-circle">
                                                        <img src="{{asset('site_assets/icon/share.svg')}}" alt="icon" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if(!Auth::check() || (Auth::check() && Auth::User()->plan_id == 0))
                    <!-- <div style="position:fixed;width:100px!important;top:70px;right:0;height: 100% !important;z-index:1000;">
                        <div style="display:flex;justify-content:center;">
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
                                crossorigin="anonymous"></script>
                            <ins class="adsbygoogle"
                                style="display:block;width:100px !important;height: 100% !important;z-index:1000;position:fixed"
                                data-ad-client="ca-pub-7220843961648970"
                                data-ad-slot="9408765007"
                            >
                            </ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                    </div> -->
                        <div class="ads-banner">
                            <div style="display:flex;justify-content:center;">
                                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7220843961648970"
                                    crossorigin="anonymous"></script>
                                <ins class="adsbygoogle"
                                    style="display:block;width:100px !important;height: 100% !important;z-index:1000;position:fixed"
                                    data-ad-client="ca-pub-7220843961648970"
                                    data-ad-slot="9408765007"
                                >
                                </ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

                  