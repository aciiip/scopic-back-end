<?php
namespace App\Http\Controllers\Api;

use App\Models\AutoBidding;
use App\Models\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AutoBiddingController extends BaseController
{

    /**
     * Crate auto bidding
     *
     * @param $productId
     * @return JsonResponse
     */
    public function create ($productId): JsonResponse
    {
        $user = Auth::user();
        $autoBidding = AutoBidding::where('user_id', $user->id)->where('product_id', $productId)->first();
        if (!$autoBidding) {
            $autoBidding = AutoBidding::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
        }
        return $this->responseSuccess([
            'auto_bidding' => $autoBidding
        ]);
    }

    /**
     * Delete auto bidding
     *
     * @param $productId
     * @return JsonResponse
     */
    public function destroy ($productId): JsonResponse
    {
        $user = Auth::user();
        AutoBidding::where('product_id', $productId)->where('user_id', $user->id)->delete();
        return $this->responseSuccess([
            'message' => 'Auto bidding has been deleted'
        ]);
    }

    /**
     * Get by user_id and product_id
     *
     * @param $productId
     * @return JsonResponse
     */
    public function getByProductId($productId): JsonResponse
    {
        $user = Auth::user();
        $bid = AutoBidding::where('user_id', $user->id)->where('product_id', $productId)->first();
        return $this->responseSuccess([
            'auto_bidding' => $bid
        ]);
    }

}
