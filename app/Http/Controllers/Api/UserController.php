<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return apiControllerIndex($request, User::class, [
            'sort' => ['name' => 'asc']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        return response(
            User::create($request->validated()),
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update($validated);

        return response($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $authUser = request()->user();
        if ($user->id === $authUser->id) {
            // Suicide is not allowed.
            return response('', 409);
        }

        $user->delete();

        return response()->json('', 204);
    }
}
