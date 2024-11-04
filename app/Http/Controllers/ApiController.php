<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    protected function successResponse($data, $message='Success', $status = 200)
    {
           return response()->json([
            'message' => $message,
            'data' => $data
           ], $status);
    }
}