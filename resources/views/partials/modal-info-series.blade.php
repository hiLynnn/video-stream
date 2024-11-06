<div id="modal-info" class="container">
    <div class="row">
        <div class="title">{{$data['name']}}</div>
        <img src="{{asset($data['video_image'])}}" alt="">
        {!! $data['video_description'] !!}
    </div>
</div>
