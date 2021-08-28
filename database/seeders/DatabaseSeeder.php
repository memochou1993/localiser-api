<?php

namespace Database\Seeders;

use App\Constants\Role;
use App\Models\Key;
use App\Models\Language;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $admin */
        $admin = User::query()->create([
            'name' => 'root',
            'email' => 'root@email.com',
            'password' => 'root',
            'role' => Role::ADMIN,
        ]);

        /** @var Project $project */
        $project = Project::query()->create([
            'name' => 'Localiser',
            'settings' => [
               'keyPrefix' => '__',
               'keySuffix' => '',
            ],
        ]);

        $admin->projects()->attach($project, [
            'role' => Role::PROJECT_OWNER,
        ]);

        $languages = [
            'en' => 'English',
            'zh_TW' => 'Chinese Traditional',
        ];

        collect($languages)
            ->each(function ($language, $locale) use ($project, $languages) {
                /** @var Language $language */
                $language = $project->languages()->create([
                    'name' => $language,
                    'locale' => $locale,
                ]);
                $path = sprintf('%s/%s.json', database_path('seeders/lang'), $locale);
                $items = json_decode(File::get($path));
                collect($items)
                    ->each(function ($item, $index) use ($project, $language) {
                        /** @var Key $key */
                        $key = $project->keys()->firstOrCreate([
                            'name' => Str::of($index)
                                ->replaceFirst($project->settings->keyPrefix, '')
                                ->replaceLast($project->settings->keySuffix, ''),
                        ]);
                        $key->values()->create([
                            'text' => $item,
                            'project_id' => $project->id,
                            'language_id' => $language->id,
                        ]);
                    });
            });
    }
}
