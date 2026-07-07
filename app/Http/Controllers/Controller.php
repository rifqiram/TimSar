<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected int $perPage = 10;

    protected function successResponse($data = null, string $message = 'Berhasil', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function paginatedResponse($resourceCollection, string $message = 'Berhasil', int $code = 200)
    {
        $response = $resourceCollection->response()->getData(true);
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $response['data'],
            'meta' => $response['meta'] ?? null,
            'links' => $response['links'] ?? null,
        ], $code);
    }

    protected function errorResponse(string $message = 'Gagal', int $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    protected function authorizeAdmin(Request $request)
    {
        $user = $request->user();

        if (! $user || $user->role !== User::ROLE_ADMIN) {
            return $this->errorResponse('Forbidden', 403);
        }

        return null;
    }
}
