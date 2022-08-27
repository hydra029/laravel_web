<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
	public function successResponse($data, $message = '', $status = 200): JsonResponse
	{
		return response()->json([
			                        'success' => true,
			                        'data'    => $data,
			                        'message' => $message,
		                        ], $status);
	}

	public function errorResponse($data, $message = '', $status = 400): JsonResponse
	{
		return response()->json([
			                        'success' => false,
			                        'data'    => $data,
			                        'message' => $message,
		                        ], $status);
	}
}
