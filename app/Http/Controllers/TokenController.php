<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenStoreRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TokenStoreRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function store(TokenStoreRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->firstWhere('email', $request->input('email'));

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            throw new AuthenticationException();
        }

        $token = $user->createToken('')->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
