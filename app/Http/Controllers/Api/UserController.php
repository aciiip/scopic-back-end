<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController {

    /**
     * Login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $post = $request->all();

        $validator = Validator::make($post, [
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        if ($post['username'] === 'user1' && $post['password'] === 'password') {
            return $this->responseSuccess([
                'user' => [
                    'name' => 'User 1'
                ],
                'token' => env('DUMMY_USER1_TOKEN')
            ]);
        }

        if ($post['username'] === 'user2' && $post['password'] === 'password') {
            return $this->responseSuccess([
                'user' => [
                    'name' => 'User 2'
                ],
                'token' => env('DUMMY_USER2_TOKEN')
            ]);
        }

        return $this->responseError('Incorrect username or password');
    }


    public function profile ()
    {
        return $this->responseSuccess([
            'user' => Auth::user()
        ]);
    }

}
