<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUserDestroyRequest;
use App\Http\Requests\ProjectUserStoreRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectUserStoreRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function store(ProjectUserStoreRequest $request, Project $project): JsonResponse
    {
        $users = collect($request->input('users'))
            ->mapWithKeys(function ($user) {
                return [
                    $user['id'] => [
                        'role' => $user['role'],
                    ]
                ];
            })
            ->toArray();

        $project->users()->syncWithoutDetaching($users);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProjectUserDestroyRequest $request
     * @param Project $project
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(ProjectUserDestroyRequest $request, Project $project, User $user): JsonResponse
    {
        if ($project->users->count() === 1) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        if ($project->users->contains($user)) {
            $project->users()->detach($user->id);
            return response()->json(null, Response::HTTP_OK);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
