<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class ClientController extends Controller
{
    protected function ok(string $message, mixed $data = null, int $status = 200)
    {
        if ($data instanceof JsonResource) {
            $data = $data->resolve(request());
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
        ], $status);
    }
}
