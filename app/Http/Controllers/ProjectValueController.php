<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectValueIndexRequest;
use App\Models\Language;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class ProjectValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProjectValueIndexRequest $request
     * @param Project $project
     */
    public function index(ProjectValueIndexRequest $request, Project $project)
    {
        /** @var Language $language */
        $language = Language::query()
            ->where('code', $request->input('language_code'))
            ->firstOrFail();

        $values = $project
            ->values()
            ->with('key')
            ->where('language_id', $language->id)
            ->get()
            ->mapWithKeys(function ($value) {
                return [
                    $value['key']['name'] => $value['text'],
                ];
            });

        $cacheKey = sprintf("projects_%s:languages_%s:values", $project->id, $language->id);

        return Cache::sear($cacheKey, function () use ($values) {
            return $values;
        });
    }
}
