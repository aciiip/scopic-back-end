<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller {

    const PAGE_LIMIT = 10;

    /**
     * Response when success
     *
     * @param $data
     * @return JsonResponse
     */
    protected function responseSuccess($data): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Response when error
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function responseError($message, int $code = 403): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }

}
