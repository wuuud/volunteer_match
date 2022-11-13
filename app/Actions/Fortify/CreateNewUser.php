<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Npo;
use App\Models\Volunteer;
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
            }else{
                Volunteer::create([
                    'user_id' => $user->id,
                    'career' => "準備中",
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            logger($th->getMessage());
            DB::rollBack();
        }
        return $user;
    }
}
