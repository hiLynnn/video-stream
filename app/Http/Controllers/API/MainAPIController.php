<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
class MainAPIController extends Controller
{
    public function toReponse($data = [], $message = '', $error = false, $code = 200){
        return response()->json([
            'data' => $data,
            'message' => $message,
            'error' => $error
        ])->setStatusCode($code);
    }
}
