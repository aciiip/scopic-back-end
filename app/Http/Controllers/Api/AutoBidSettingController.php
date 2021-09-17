<?php
namespace App\Http\Controllers\Api;

use App\Models\AutoBidding;
use App\Models\AutoBidSetting;
use App\Models\Bid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AutoBidSettingController extends BaseController
{
    /**
     * Get auto bid setting
     *
     * @return JsonResponse
     */
    public function index (): JsonResponse
    {
        $user = Auth::user();
        $setting = AutoBidSetting::where('user_id', $user->id)->first();
        return $this->responseSuccess([
            'setting' => $setting
        ]);
    }

    /**
     * Create or Update auto bid setting
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request): JsonResponse
    {
        $user = Auth::user();
        $post = $request->all();
        $validator = Validator::make($post, [
            'max_amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        $setting = AutoBidSetting::where('user_id', $user->id)->first();
        if ($setting) {
            $setting->update([
                'max_amount' => $post['max_amount']
            ]);
        } else {
            $setting = AutoBidSetting::create([
                'user_id' => $user->id,
                'max_amount' => $post['max_amount']
            ]);
        }

        return $this->responseSuccess([
            'setting' => AutoBidSetting::where('user_id', $user->id)->first()
        ]);
    }
}
