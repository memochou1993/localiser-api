<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectCacheLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $project_id
     * @return JsonResponse
     */
    public function index(string $project_id): JsonResponse
    {
        $cacheKey = sprintf("project_%s_languages", $project_id);

        $languages = Cache::sear($cacheKey, function () use ($project_id) {
                $languages = Language::query()
                    ->where('project_id', $project_id)
                    ->get();
                return $languages->map(function ($language) {
                    return [
                        'name' => $language->name,
                        'locale' => $language->locale,
                    ];
                });
            }
        );

        return response()->json($languages);
    }

    /**
     * Remove the specified resource from cache.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $cacheKey = sprintf("project_%s_languages", $project->id);

        Cache::forget($cacheKey);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
