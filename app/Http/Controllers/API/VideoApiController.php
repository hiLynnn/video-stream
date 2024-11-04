<?php

namespace App\Http\Controllers\API;
use App\Movies;
use App\Repository\VideoRepository;

class VideoApiController extends MainAPIController
{
    public function __construct(protected VideoRepository $repository = new VideoRepository(new Movies()))
    {

    }
    public function index(){
        $except = request()->input('except') ?? 0;
        $data = $this->repository->getCursorBy([
            'upcoming' => 0,
            'except' => $except,
            'order_by' => [['updated_at', 'DESC']]
        ],[],
        ['id', 'video_access', 'video_title', 'duration', 'video_description', 'video_slug', 'video_image_thumb', 'video_image', 'trailer_url', 'video_url', 'updated_at']);

        if(blank($data)){
            return $this->toReponse([],'No Video found!',true,404);
        }
        $html = [];
        foreach ($data as $key => $value) {
            $html[] = view('partials.video-item',['item'=> $value])->render();
        }
        return $this->toReponse([
            'html' => $html,
            'id_reload' => $data->pluck('id')->toArray(),
            'next_page_url' => $data->nextPageUrl(),
        ]);
    }
}
