@extends('default')
@section('content')
    <div class="page-common">
        @include("partials.header")
        <div class="area-body-home container-page">
        @if(!Auth::check() || (Auth::check() && Auth::User()->plan_id == 0))
            <div class="banner-ads-wr">
                <div class="container-ads">
                    <img src="{{asset('site_assets/ads/banner-ads.jpg')}}" alt="">
                </div>
            </div>
        @endif

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
                            <a href="{{route('public.play-movies.view',['slug' => Arr::get($movie,'video_slug',''), 'id' => Arr::get($movie,'id','')])}}" >
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
                <div class="container-full">
                    <a href="">Xem thêm</a>
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
                            <a href="{{ route('public.play-movies.view', ['slug' => Arr::get($sery,'series_slug',''), 'id' =>  Arr::get($sery,'id','')]) }}" >
                                <div class="thumb">
                                    <img src="{{Arr::get($sery,'series_poster','')}}" alt="">
                                </div>
                                <div class="play-icon">
                                    <img src="{{asset('site_assets/icon/circle-play.svg')}}" alt="">
                                </div>
                                <div class="title">
                                    <span>{{Arr::get($sery,'series_name','')}}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="container-full">
                    <a href="/category">Xem thêm</a>
                </div>
            </div>
        </div>
        <div class="common-footer">
            <div class="container-page">

            </div>
        </div>
    </div>
@endsection
