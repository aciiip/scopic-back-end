<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    /**
     * List of products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $search = $request->get('search');
        $order = $request->get('order');

        $products = Product::where('id', '>', 0);

        if ($search) {
            $products
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        }
        if ($order) {
            $products = $products->orderBy('price', $order);
        }

        return $this->responseSuccess(
            $products->paginate(self::PAGE_LIMIT)
        );
    }

    /**
     * Detail product
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = Product::where('id', $id)->first();
        return $this->responseSuccess([
            'product' => $product
        ]);
    }
}
