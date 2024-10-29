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
            <div class="area-video">
                <div class="wr-component-video-reel">
                    <div class="component-video-reel">
                        <div class="swiper-reel">
                            <div class="swiper-wrapper">
                                @foreach ($data['upcoming_movies'] as $index => $item)
                                    <div class="swiper-slide">
                                        <div class="slide-item-wr">
                                            <div class="component-video-element">
                                                <video autoplay="autoplay" controls>
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
                    <div class="ads-banner-vetical">
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
                </div>
            </div>
        </div>
    </div>
@endsection
