<div id="modal-info" class="container">
    <div class="row">
        <div class="col">
            <figure class="figure">
                <img src="{{asset($data['video_image'])}}" class="img-thumbnail" alt="">
                <figcaption class="figure-caption">
                    {{$data['name']}}
                </figcaption>
            </figure>
        </div>
        <div class="col">
            {!! $data['video_description'] !!}
        </div>
    </div>
</div>
