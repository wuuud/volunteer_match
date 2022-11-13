<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            // 'profile' => ['nullable', 'string', 'max:2000'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['npo'])) {
            Validator::make($input, [
                'npo.name' => ['required', 'string', 'max:255'],
                // 'npo.profile' => ['nullable', 'string', 'max:255'],
                'npo_photo' => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            ])->validateWithBag('updateProfileInformation');
        }

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (isset($input['npo_photo'])) {
            $user->npo->updateProfilePhoto($input['npo_photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                // 'profile' => $input['profile'],
            ])->save();
        }
        if (isset($input['npo'])) {
            $user->npo->forceFill([
                'name' => $input['npo']['name'],
                // 'profile' => $input['npo']['profile'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            // 'profile' => $input['profile'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
