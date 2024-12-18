@extends('default')
@php
    $arr = [
        '',
    ]
@endphp

@section('content')
    <div class="page-common">
        @include("partials.header")
        <div class="body-container">
            @include("pages.new-home.menu")
            <div class="area-video">
                <div class="component-video-reel">
                    <div class="swiper-reel">
                        <div class="swiper-wrapper">
                            @foreach ($arr as $index => $item)
                                <div class="swiper-slide">
                                    <div class="slide-item-wr">
                                        <div class="component-video-element">
                                            <video autoplay="autoplay" controls>
                                                <source src="{{ asset($movies_info->video_url) }}" type="video/mp4"/>
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
            </div>
        </div>
    </div>
@endsection
