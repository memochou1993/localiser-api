<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::query()->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::query()->create($request->all());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return UserResource
     */
    public function show(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @return UserResource
     */
    public function update(UserUpdateRequest $request): UserResource
    {
        $user = $request->user();

        $user->update($request->all());

        return new UserResource($user);
    }
}
