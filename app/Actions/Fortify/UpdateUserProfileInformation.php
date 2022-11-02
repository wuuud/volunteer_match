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
            // ここから追加
            // 'birthdate' => ['nullable', 'date', 'max:8'],
            // 'gender' => ['required', 'date', 'max:8'],
            // 'zip' => ['required', 'date', 'max:10'],
            // 'prefecture_code' => ['nullable', 'string', 'max:8'],
            // 'prefecture' => ['required', 'string', 'max:40'],
            // 'address' => ['nullable', 'string', 'max:255'],
            // 'tel' => ['required', 'string', 'max:20'],
            // 'profile' => ['required', 'text', 'max:2000'],
            // 'want_to_do' => ['nullable', 'text', 'max:2000'],
            // 'my_job' => ['nullable', 'string', 'max:2000'],
            // 'language' => ['string', 'max:2000'],
            // 'university_name' => ['nullable', 'string', 'max:200'],
            // 'university_major' => ['nullable', 'string', 'max:2000'],
            // 'university_grade' => ['nullable', 'string', 'max:2000'],
            // 'volunteer_start' => ['required', 'string', 'max:2000'],
            // 'volunteer_region' => ['required', 'string', 'max:2000'],
            // 'volunteer_type' => ['required', 'tinyInteger', 'max:2000'],
            // 'volunteer_cause' => ['required', 'string', 'max:2000'],
            // 'volunteer_length' => ['nullable', 'tinyInteger', 'max:2000'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['npo'])) {
            Validator::make($input, [
                'npo.name' => ['required', 'string', 'max:255'],
                'npo.profile' => ['nullable', 'string', 'max:255'],
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
                // ここから追加
                // 'birthdate' => $input['birthdate'],
                // 'gender' => $input['gender'],
                // 'zip' => $input['zip'],
                // 'prefecture_code' => $input['prefecture_code'],
                // 'prefecture' => $input['prefecture'],
                // 'address' => $input['address'],
                // 'tel' => $input['tel'],
                // 'profile' => $input['profile'],
                // 'want_to_do' => $input['want_to_do'],
                // 'my_job' => $input['my_job'],
                // 'language' => $input['language'],
                // 'university_name' => $input['university_name'],
                // 'university_major' => $input['university_major'],
                // 'university_grade' => $input['university_grade'],
                // 'volunteer_start' => $input['university_start'],
                // 'volunteer_region' => $input['university_region'],
                // 'volunteer_type' => $input['university_type'],
                // 'volunteer_cause' => $input['university_cause'],
                // 'volunteer_length' => $input['university_length'],
            ])->save();
        }
        if (isset($input['npo'])) {
            $user->npo->forceFill([
                'name' => $input['npo']['name'],
                'profile' => $input['npo']['profile'],
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

            // ここから追加
            // 'profile' => $input['profile'],
            // 'birthdate' => $input['birthdate'],
            // 'gender' => $input['gender'],
            // 'zip' => $input['zip'],
            // 'prefecture_code' => $input['prefecture_code'],
            // 'prefecture' => $input['prefecture'],
            // 'address' => $input['address'],
            // 'tel' => $input['tel'],
            // 'want_to_do' => $input['want_to_do'],
            // 'my_job' => $input['my_job'],
            // 'language' => $input['language'],
            // 'university_name' => $input['university_name'],
            // 'university_major' => $input['university_major'],
            // 'university_grade' => $input['university_grade'],
            // 'volunteer_start' => $input['university_start'],
            // 'volunteer_region' => $input['university_region'],
            // 'volunteer_type' => $input['university_type'],
            // 'volunteer_cause' => $input['university_cause'],
            // 'volunteer_length' => $input['university_length'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
