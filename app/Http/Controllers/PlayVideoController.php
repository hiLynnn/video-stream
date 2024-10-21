<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Movies;

class PlayVideoController extends Controller
{
    public function view($slug,$id)
    {
        $movies_info = Movies::where('status',1)->where('id',$id)->first();
        return view('pages.play-video.index', compact('movies_info'));
    }
}
