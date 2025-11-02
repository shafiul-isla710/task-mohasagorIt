<?php

namespace App\Helper;

trait ApiResponseTrait
{
    public function successResponse($status = true, $message = 'Success', $data = [], $code = 200)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data,
            
        ], $code);
    }

    public function errorResponse($status = false, $message = 'Failed', $code = 400)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
        ], $code);
    }
}
