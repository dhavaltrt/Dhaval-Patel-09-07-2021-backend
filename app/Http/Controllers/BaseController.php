<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message = '', $result = [])
    {
        $response = [
            'message' => $message,
            'data'    => (empty($result)) ? (object)[] : $result,
        ];

        return response()->json($response, 200);
    }

    /**
     * error response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 400)
    {
        $response = [
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}