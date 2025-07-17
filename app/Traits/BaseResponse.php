<?php

namespace App\Traits;

trait BaseResponse
{
    public static function success($message,  $data = [], $status_code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message'=> $message,
            'data'=> $data
        ],$status_code);
    }
    public static function error($message,  $data = [], $status_code = 422)
    {
        return response()->json([
            'status' => 'error',
            'message'=> $message,
            'data'=> $data
        ],$status_code);
    }
}
