<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VolunteerOffer;
use Illuminate\Auth\Access\HandlesAuthorization;

class VolunteerOfferPolicy
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

    // 省略
    public function view(?User $user, VolunteerOffer $volunteer_offer)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isset($user->npo);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, VolunteerOffer $volunteer_offer)
    {
        return $user->id === $volunteer_offer->npo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\VolunteerOffer  $volunteer_offer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, VolunteerOffer $volunteer_offer)
    {
        return $user->id === $volunteer_offer->npo->user_id;
    }
}
