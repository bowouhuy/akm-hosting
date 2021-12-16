<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\IndexRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

Trait ResponseWithHttpStatus
{
    public function trueResponse($message="",$data=[],$httpcode=200){
        return response()->json([
            "status"    => true,
            "data"      => $data,
            "message"   => $message,
        ],$httpcode);
    }

    public function falseResponse($message="",$data=[],$httpcode=422){
        return response()->json([
            "status"    => false,
            "data"      => $data,
            "message"   => $message,
        ],$httpcode);
    }
}
