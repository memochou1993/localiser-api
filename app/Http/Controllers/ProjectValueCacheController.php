<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectValueCacheDestroyRequest;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectValueCacheController extends Controller
{
    /**
     * Remove the specified resource from cache.
     *
     * @param ProjectValueCacheDestroyRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function __invoke(ProjectValueCacheDestroyRequest $request, Project $project): JsonResponse
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
