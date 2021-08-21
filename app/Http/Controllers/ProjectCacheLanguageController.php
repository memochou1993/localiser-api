<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectCacheLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function index(Project $project): JsonResponse
    {
        $languages = Cache::sear(
            sprintf("project_%s_languages", $project->id),
            function () use ($project) {
                return $project->languages->map(function ($language) {
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
        Cache::forget(sprintf("project_%s_languages", $project->id));

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
