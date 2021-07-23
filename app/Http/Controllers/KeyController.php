<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeyStoreRequest;
use App\Http\Requests\KeyUpdateRequest;
use App\Http\Resources\KeyResource;
use App\Models\Key;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return AnonymousResourceCollection
     */
    public function index(Project $project): AnonymousResourceCollection
    {
        $keys = $project->keys()->paginate();

        return KeyResource::collection($keys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KeyStoreRequest $request
     * @param Project $project
     * @return KeyResource
     */
    public function store(KeyStoreRequest $request, Project $project): KeyResource
    {
        $key = Key::query()->make($request->all());

        $project->keys()->save($key);

        return new KeyResource($key);
    }

    /**
     * Display the specified resource.
     *
     * @param Key $key
     * @return KeyResource
     */
    public function show(Key $key): KeyResource
    {
        return new KeyResource($key);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param KeyUpdateRequest $request
     * @param Key $key
     * @return KeyResource
     */
    public function update(KeyUpdateRequest $request, Key $key): KeyResource
    {
        $key->update($request->all());

        return new KeyResource($key);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Key $key
     * @return JsonResponse
     */
    public function destroy(Key $key): JsonResponse
    {
        $key->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
