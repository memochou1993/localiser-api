<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Project;
use App\Models\Value;
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
        $project_id = hash_id((new Project())->getTable())->decodeHex($id);

        $request->validate([
            'locale' => 'required',
        ]);

        $locale = $request->input('locale');

        $cacheKey = sprintf("project_%s_locale_%s_values", $project_id, $locale);

        $values = Cache::sear($cacheKey, function () use ($project_id, $locale) {
                /** @var Project $project */
                $project = Project::query()
                    ->findOrFail($project_id);
                /** @var Language $language */
                $language = Language::query()
                    ->where('project_id', $project_id)
                    ->where('locale', $locale)
                    ->firstOrFail();
                $values = Value::query()
                    ->with('key')
                    ->where('project_id', $project_id)
                    ->where('language_id', $language->id)
                    ->get();
                return $values
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
        $project->languages->each(function ($language) use ($project) {
            $cacheKey = sprintf("project_%s_locale_%s_values", $project->id, $language->locale);
            Cache::forget($cacheKey);
        });

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
