@extends('default')
@section('content')
    <div class="page-common">
        @include("partials.header")
        <div class="area-body-home container-page">
            <div class="banner-ads-wr">
                <div class="container-ads">
                    <img src="{{asset('site_assets/ads/banner-ads.jpg')}}" alt="">
                </div>
            </div>

            <div class="category-component">
                <div class="heading">
                    <h3 class="caption">
                        {{__('Movies Up coming')}}
                    </h3>
                </div>
                <div class="list-movies">
                    @foreach ($data['upcoming_movies'] ?? [] as $index => $movie)
                        {{-- @dd($movie) --}}
                        <div class="movie-item-item">
                            <a href="{{route('public.play.view',Arr::get($movie,'video_slug',''))}}" >
                                <div class="thumb">
                                    <img src="{{Arr::get($movie,'video_image','')}}" alt="">
                                </div>
                                <div class="play-icon">
                                    <img src="{{asset('site_assets/icon/circle-play.svg')}}" alt="">
                                </div>
                                <div class="title">
                                    <span>{{Arr::get($movie,'video_title','')}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="category-component">
                <div class="heading">
                    <h3 class="caption">
                        {{__('Series Up coming')}}
                    </h3>
                </div>
                <div class="list-movies">
                    @foreach ($data['upcoming_series'] ?? [] as $index => $sery)
                        <div class="movie-item-item">
                            <a href="{{route('public.play.view',Arr::get($sery,'series_slug',''))}}" >
                                <div class="thumb">
                                    <img src="{{Arr::get($sery,'series_poster','')}}" alt="">
                                </div>
                                <div class="title">
                                    <span>{{Arr::get($sery,'series_name','')}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="common-footer">
            <div class="container-page">

            </div>
        </div>
        <div class="ads-script">
            <div class="close-btn">
                đóng
            </div>
            <div class="banner-ads-wr">
                <div class="container-ads">
                    <img src="{{asset('site_assets/ads/banner-ads.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
