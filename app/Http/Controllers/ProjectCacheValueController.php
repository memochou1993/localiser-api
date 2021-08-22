<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProjectCacheValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function index(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'locale' => 'required',
        ]);

        $locale = $request->input('locale');

        /** @var Project $project */
        $project = Cache::sear(
            sprintf("project_%s", $id),
            function () use ($id) {
                return Project::query()->findOrFail($id);
            }
        );

        /** @var Language $language */
        $language =  Cache::sear(
            sprintf("language_%s", $locale),
            function () use ($project, $locale) {
                return $project
                    ->languages()
                    ->where('locale', $locale)
                    ->firstOrFail();
            }
        );

        $values = Cache::sear(
            sprintf("language_%s_values", $locale),
            function () use ($project, $language) {
                return $project
                    ->values()
                    ->with('key')
                    ->where('language_id', $language->id)
                    ->get()
                    ->mapWithKeys(function ($value) use ($project) {
                        $key = vsprintf("%s%s", [
                            $project->settings->keyPrefix ?? '',
                            $value['key']['name'],
                            $project->settings->keySuffix ?? '',
                        ]);
                        return [
                            $key => $value['text'],
                        ];
                    })
                    ->sortKeys();
            }
        );

        return response()->json($values);
    }

    /**
     * Remove the specified resource from cache.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        Cache::forget(sprintf("project_%s", $project->id));

        $project->languages->each(function ($language) use ($project) {
            Cache::forget(sprintf("language_%s", $language->locale));
            Cache::forget(sprintf("language_%s_values", $language->locale));
        });

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
