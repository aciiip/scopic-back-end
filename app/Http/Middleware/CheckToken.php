<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken()) {
            $user = null;
            switch ($request->bearerToken()) {
                case env('DUMMY_USER1_TOKEN') :
                    $user = factory(User::class)->make([
                        'id' => 1,
                        'name' => 'User1',
                        'username' => 'user1'
                    ]);
                    break;
                case env('DUMMY_USER2_TOKEN') :
                    $user = factory(User::class)->make([
                        'id' => 2,
                        'name' => 'User2',
                        'username' => 'user2'
                    ]);
                    break;
            }

            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 401);
    }
}
