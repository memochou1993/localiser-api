<?php

namespace App\Policies;

use App\Constants\Ability;
use App\Models\Key;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class KeyPolicy
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
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Key $key)
    {
        return Gate::authorize('view', $key->project)->allowed();
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

        return collect($abilities)->contains(Ability::KEY_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Key $key)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($key->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::KEY_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Key $key)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($key->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::KEY_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Key $key)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Key  $key
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Key $key)
    {
        //
    }
}
