<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Login the user.
     * 
     * @param App\Http\Requests\LoginRequest  $request
     * @return Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('username', $validated['username'])->first();
        if ($user && Hash::check($validated['password'], $user->password)) {
            $userInfo = array_merge(
                $user->attributesToArray(),
                ['token' => $user->api_token]
            ) ;
            return response()->json($userInfo, 200);
        }

        return response('', 401);
    }
}
