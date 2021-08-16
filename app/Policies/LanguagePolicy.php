<?php

namespace App\Policies;

use App\Constants\Ability;
use App\Models\Language;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class LanguagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return Gate::authorize('view', request()->route('project'))->allowed();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\language  $language
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Language $language)
    {
        return Gate::authorize('view', $language->project)->allowed();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find(request()->route('project'));

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::LANGUAGE_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Language $language)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($language->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::LANGUAGE_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Language $language)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($language->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::LANGUAGE_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Language $language)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Language $language)
    {
        //
    }
}
