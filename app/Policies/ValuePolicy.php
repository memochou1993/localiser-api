<?php

namespace App\Policies;

use App\Constants\Ability;
use App\Models\User;
use App\Models\Value;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class ValuePolicy
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
        return Gate::authorize('view', request()->route('key')->project)->allowed();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Value  $value
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Value $value)
    {
        return Gate::authorize('view', $value->key->project)->allowed();
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
        $userProject = $user->projects->find(request()->route('key')->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::VALUE_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Value  $value
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Value $value)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($value->key->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::VALUE_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Value  $value
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Value $value)
    {
        /** @var Project $userProject */
        $userProject = $user->projects->find($value->key->project);

        if (!$userProject) {
            return false;
        }

        $role = $userProject->pivot->getAttribute('role');
        $abilities = config('roles')[$role]['abilities'];

        return collect($abilities)->contains(Ability::VALUE_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Value  $value
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Value $value)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Value  $value
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Value $value)
    {
        //
    }
}
