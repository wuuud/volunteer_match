<?php

namespace App\Policies;

use App\Models\Volunteer;
use App\Models\User;
use App\Models\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(?User $user)
    {
        return true;
    }
    public function view(?User $user, Application $application)
    {
        return true;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param   \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isset($user->volunteer);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param   \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */

    // 募集内容の更新・削除に関係
    public function update(User $user, Application $application)
    {
        return $user->id === $application->volunteer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param   \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Application $application)
    {
        return $user->id === $application->volunteer->user_id;
    }
}
