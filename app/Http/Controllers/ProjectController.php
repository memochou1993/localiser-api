<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        $this->authorizeResource(Project::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $projects = $request
            ->user()
            ->projects()
            ->with(['languages'])
            ->orderByDesc('updated_at')
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectStoreRequest $request
     * @return ProjectResource
     */
    public function store(ProjectStoreRequest $request): ProjectResource
    {
        /** @var Project $project */
        $project = Project::query()->create($request->all());

        $request->user()->projects()->attach($project, [
            'role' => Role::PROJECT_OWNER,
        ]);

        $languages = $request->input('languages', []);

        foreach ($languages as $language) {
            $project->languages()->create($language);
        }

        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        /** @var User $auth */
        $auth = Auth::user();

        return new ProjectResource($auth->projects()->with(['users', 'languages'])->find($project->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectUpdateRequest $request
     * @param Project $project
     * @return ProjectResource
     */
    public function update(ProjectUpdateRequest $request, Project $project): ProjectResource
    {
        $project->update($request->all());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
