<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display information about current user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $attributes = $user->attributesToArray();
        $data = array_merge(
            $attributes,
            ['token' => $user->api_token]
        );

        return response($data, 200);
    }
}
