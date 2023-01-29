<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends Controller
{
    public const MESSAGE_SUCCESS = 'Success';

    public function checkRequestValidation($request, $message = null): ?JsonResponse
    {
        $message = $message ?? 'The given data was invalid.';

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => $message,
                'errors' => $request->validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return null;
    }

    public function responseSuccess(array $data, $message = self::MESSAGE_SUCCESS): JsonResponse
    {
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
        ], Response::HTTP_OK);
    }
}
