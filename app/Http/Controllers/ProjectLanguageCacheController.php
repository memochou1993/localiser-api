<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectLanguageCacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function index(Project $project): JsonResponse
    {
        $cacheKey = sprintf("projects_%s:languages", $project->id);

        $languages = Cache::sear($cacheKey, function () use ($project) {
            return $project->languages->map(function ($language) {
                return [
                    'name' => $language->name,
                    'code' => $language->code,
                ];
            });
        });

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
        $cacheKey = sprintf("projects_%s:languages", $project->id);

        Cache::forget($cacheKey);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
