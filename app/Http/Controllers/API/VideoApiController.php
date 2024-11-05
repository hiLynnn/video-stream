<?php

namespace App\Http\Controllers\API;

use App\ComboVideo;
use App\Episodes;
use App\Movies;
use App\Repository\VideoRepository;
use App\Series;

class VideoApiController extends MainAPIController
{
    public function __construct(protected VideoRepository $repository= new VideoRepository(new ComboVideo()))
    {

    }
    public function index(){
        $except = request()->input('except') ?? 0;
        $data = $this->repository->getCursorBy($except,10);

        if(blank($data)){
            return $this->toReponse([],'No Video found!',true,404);
        }
        $collection = [];
        $id_reload = [];
        foreach ($data as $key => $value) {
            if($value->model == Series::class){
                try {
                    $episode = Episodes::where("episode_series_id", $value->ref_id)
                        ->orderBy("episode_season_id")
                        ->orderBy("created_at")
                        ->first();
                    if(blank($episode)){
                        continue;
                    }
                    $collection[] = [
                        "id" => $episode->id,
                        "video_slug" => $episode->video_slug,
                        "video_url" => $episode->video_url,
                        "video_image" => $episode->video_image,
                        "video_image_thumb" => $episode->video_image,
                        "name" => $episode->video_title,
                        "is_serie" => true,
                        "url_get_info" => route('api.get-video-info', ["id"=> $value?->id]),
                        "url" => route('public.view-series',['slug'=> $episode->video_slug,'id'=> $value->ref_id,'episode'=> $episode->id])
                    ];
                    $id_reload[] = $episode->id;
                } catch (\Throwable $th) {
                    continue;
                }
            }else {
                try {
                    $movie = Movies::where("id", $value->ref_id)->first();
                    if(blank($movie)){
                        continue;
                    }
                    $collection[] = [
                        "id" => $movie->id,
                        "video_slug" => $movie->video_slug,
                        "video_url" => $movie->video_url,
                        "video_image" => $movie->video_image,
                        "video_image_thumb" => $movie->video_image_thumb,
                        "name" => $movie->video_title,
                        "is_serie" => false,
                        "url_get_info" => route('api.get-video-info', ["id"=> $value?->id]),
                        "url" => route('public.view-video',['slug'=> $movie->video_slug,'id'=> $movie->id])
                    ];
                    $id_reload[] = $movie->id;
                } catch (\Throwable $th) {
                    continue;
                }
            }
        }

        $html = [];
        foreach ($collection as $key => $value) {
            $html[] = view('partials.video-item',['item'=> $value])->render();
        }

        return $this->toReponse([
            'html' => $html,
            'id_reload' => $id_reload,
            'next_page_url' => $data->nextPageUrl(),
        ]);
    }

    public function getEpisodes($id){
        try {
            // $data = ComboVideo::where('id',$id)->first();
            $data = [];
            $data['name'] = "name";
            return $this->toReponse([
                'html' => view('partials.modal-info',compact('data'))->render()
            ]);
        } catch (\Throwable $th) {
            return $this->toReponse([],$th->getMessage(),true,500);
        }

    }

   
}
