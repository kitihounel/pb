<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $validated = $request->validated();
        $fillable = Arr::except($validated, 'password');

        $user = new User($fillable);
        $user->password = Hash::make($validated['password']);
        $user->api_token = Str::random(User::tokenLength());
        $user->save();
        $location = route('users.show', ['user' => $user->id]);

        return response($user, 201)->header('Location', $location);
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
        $fillable = Arr::except($validated, 'password');

        $user->fill($fillable);
        if (Arr::exists($validated, 'password')) {
            $newPass = Hash::make($validated['password']);
            $user->password = $newPass;
        }
        $user->update();

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

        return response('', 204);
    }
}
