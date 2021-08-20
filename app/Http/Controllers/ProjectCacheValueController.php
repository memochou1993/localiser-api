<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectValueCacheDestroyRequest;
use App\Http\Requests\ProjectValueIndexRequest;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectCacheValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProjectValueIndexRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function index(ProjectValueIndexRequest $request, Project $project): JsonResponse
    {
        $language_code = $request->input('language_code');

        $cacheKeyForLanguage = sprintf("projects_%s:languages_%s", $project->id, $language_code);

        /** @var Language $language */
        $language =  Cache::sear($cacheKeyForLanguage, function () use ($project, $language_code) {
            return $project
                ->languages()
                ->where('code', $language_code)
                ->firstOrFail();
        });

        $cacheKeyForValues = sprintf("projects_%s:languages_%s:values", $project->id, $language->id);

        $values = Cache::sear($cacheKeyForValues, function () use ($project, $language) {
            return $project
                ->values()
                ->with('key')
                ->where('language_id', $language->id)
                ->get()
                ->mapWithKeys(function ($value) {
                    return [
                        $value['key']['name'] => $value['text'],
                    ];
                });
        });

        return response()->json($values);
    }

    /**
     * Remove the specified resource from cache.
     *
     * @param ProjectValueCacheDestroyRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(ProjectValueCacheDestroyRequest $request, Project $project): JsonResponse
    {
        $language_code = $request->input('language_code');

        /** @var Language $language */
        $language = Language::query()
            ->where('code', $language_code)
            ->firstOrFail();

        $cacheKeyForLanguage = sprintf("projects_%s:languages_%s", $project->id, $language_code);

        Cache::forget($cacheKeyForLanguage);

        $cacheKeyForValues = sprintf("projects_%s:languages_%s:values", $project->id, $language->id);

        Cache::forget($cacheKeyForValues);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
