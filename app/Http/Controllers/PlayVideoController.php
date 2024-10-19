<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class PlayVideoController extends Controller
{
    public function view($id)
    {
        return view('pages.play-video.index', []);
    }
}
