<?php
namespace App\Http\Controllers\Api;

use App\Models\AutoBidding;
use App\Models\AutoBidSetting;
use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BidController extends BaseController
{

    /**
     * Create Bid
     *
     * @param Request $request
     * @param $productId
     * @return JsonResponse
     */
    public function bid(Request $request, $productId)//: JsonResponse
    {
        $user = Auth::user();
        $post = $request->all();
        $validator = Validator::make($post, [
            'price' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        $product = Product::where('id', $productId)->first();
        if ($post['price'] <= $product->price) {
            return $this->responseError('Price should be more than product price');
        }

        $bid = Bid::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($bid) {
            $bid->update([
                'price' => $post['price']
            ]);
        } else {
            Bid::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'price' => $post['price']
            ]);
        }

        $this->checkAutoBidding($productId, $post['price']);

        $bid = Bid::where('user_id', $user->id)->where('product_id', $productId)->first();
        return $this->responseSuccess([
            'bid' => $bid
        ]);
    }

    /**
     * Check and crate bid by auto-bidding feature
     *
     * @param $productId
     * @param $lastPrice
     */
    private function checkAutoBidding ($productId, $lastPrice): void
    {
        $user = Auth::user();
        $autoBiddings = AutoBidding::where('product_id', $productId)->get();
        foreach ($autoBiddings AS $autoBidding) {
            $lastPrice++;
            $setting = AutoBidSetting::where('user_id', $autoBidding->user_id)->first();
            if ($setting && $lastPrice > $setting->max_amount) {
                continue;
            }
            if ($user->id !== $autoBidding->user_id) {
                $bid = Bid::where('product_id', $productId)->where('user_id', $autoBidding->user_id)->first();
                if ($bid) {
                    $bid->update([
                        'price' => $lastPrice
                    ]);
                } else {
                    Bid::create([
                        'user_id' => $autoBidding->user_id,
                        'product_id' => $productId,
                        'price' => $lastPrice
                    ]);
                }
            }
        }
    }

}
