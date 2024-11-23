<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Return a JSON response
     */
    public function response(array $data, int $code): JsonResponse
    {
        return response()->json(['code' => $code, ...$data], $code);
    }

    /**
     * Return an unauthorized JSON response with the data
     */
    public function unauthorizedResponse(): JsonResponse
    {
        return response()->json(['status' => false, 'message' => 'unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Return a success JSON response with the data
     */
    public function successResponse(array $data = [], string $message = '', int $code = 200): JsonResponse
    {
        return response()->json(['status' => true, 'message' => $message, ...$data], status: $code);
    }

    /**
     * Return an error JSON response with the message
     */
    public function errorResponse(
        string $message = 'Error happened.',
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY
    ): JsonResponse {
        return response()->json(['status' => false, 'message' => $message], $code);

    }

    /**
     * Return a validation error JSON response with the errors
     *
     * @param [type] $errors
     */
    public function validationErrorResponse($errors): JsonResponse
    {
        return response()->json(['status' => false, 'message' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Return a not found JSON response with the message
     */
    public function notFoundErrorResponse(string $message = 'Not Found'): JsonResponse
    {
        return response()->json(['status' => false, 'message' => $message], Response::HTTP_NOT_FOUND);
    }
}
