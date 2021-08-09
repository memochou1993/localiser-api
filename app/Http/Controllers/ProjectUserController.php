<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUserDestroyRequest;
use App\Http\Requests\ProjectUserUpdateRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectUserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param ProjectUserUpdateRequest $request
     * @param Project $project
     * @param User $user
     * @return JsonResponse
     */
    public function update(ProjectUserUpdateRequest $request, Project $project, User $user): JsonResponse
    {
        if ($request->user()->id === $user->id) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        if (!$project->users->contains($user)) {
            $project->users()->attach($user->id);
            return response()->json(null, Response::HTTP_OK);
        }

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
