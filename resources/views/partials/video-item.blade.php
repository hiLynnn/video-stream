<div class="swiper-slide">
    <div class="slide-item-wr">
        <div class="component-video-element">
            <video
                id="my-video-{{$item->id}}"
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

