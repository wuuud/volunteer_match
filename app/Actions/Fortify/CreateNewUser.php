<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Npo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'npo_name' => ['string', 'max:255', 'unique:npos,name'],
            // ここから追加
            // 'birthdate' => ['nullable', 'date', 'max:8'],
            // 'gender' => ['required', 'date', 'max:8'],
            // 'zip' => ['required', 'date', 'max:10'],
            // 'prefecture_code' => ['nullable', 'string', 'max:8'],
            // 'prefecture' => ['required', 'string', 'max:40'],
            // 'address' => ['nullable', 'string', 'max:255'],
            //  'tel' => ['required', 'string', 'max:20'],
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

        ])->validate();

        DB::beginTransaction();
        try {
            // ユーザーの登録
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            // 企業情報の登録
            if(isset($input['npo_name'])) {
                Npo::create([
                    'user_id' => $user->id,
                    'name' => $input['npo_name'],
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return $user;
        // return User::create([
        //     'name' => $input['name'],
        //     'email' => $input['email'],
        //     'password' => Hash::make($input['password']),
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
        //  ]);
    }
}
