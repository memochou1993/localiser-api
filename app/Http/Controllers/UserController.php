<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $auth */
        $auth = Auth::user();

        $users = $auth->currentAccessToken()->can('restore-users')
            ? User::withTrashed()->get()
            : User::query()->get();

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
     * @param User $user
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        /** @var User $auth */
        $auth = Auth::user();

        $role = $request->input('role');

        if ($role) {
            if ($auth->currentAccessToken()->cant('update-users')) {
                throw new AccessDeniedHttpException('This action is unauthorized.');
            }

            $admins = User::query()->where('role', Role::ADMIN)->get();

            if ($admins->count() === 1 && $admins->contains($user)) {
                throw new AccessDeniedHttpException('This action is unauthorized.');
            }

            if ($user->role !== $role) {
                $user->tokens()->delete();
            }
        }

        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
