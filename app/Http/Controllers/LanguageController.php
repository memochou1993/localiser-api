<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageIndexRequest;
use App\Http\Requests\LanguageStoreRequest;
use App\Http\Requests\LanguageUpdateRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {
        $this->authorizeResource(Language::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param LanguageIndexRequest $request
     * @param Project $project
     * @return AnonymousResourceCollection
     */
    public function index(LanguageIndexRequest $request, Project $project): AnonymousResourceCollection
    {
        $languages = $project->languages()->get();

        return LanguageResource::collection($languages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LanguageStoreRequest $request
     * @param Project $project
     * @return LanguageResource
     */
    public function store(LanguageStoreRequest $request, Project $project): LanguageResource
    {
        $language = Language::query()->make($request->all());

        $project->languages()->save($language);

        return new LanguageResource($language);
    }

    /**
     * Display the specified resource.
     *
     * @param Language $language
     * @return LanguageResource
     */
    public function show(Language $language): LanguageResource
    {
        return new LanguageResource($language);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LanguageUpdateRequest $request
     * @param Language $language
     * @return LanguageResource
     */
    public function update(LanguageUpdateRequest $request, Language $language): LanguageResource
    {
        $language->update($request->all());

        return new LanguageResource($language);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $language
     * @return JsonResponse
     */
    public function destroy(Language $language): JsonResponse
    {
        $language->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
