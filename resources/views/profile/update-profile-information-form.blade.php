<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo"
                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
                !$this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
        {{-- ここより追加 --}}
        <!-- gender  -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="gender" value="{{ __('性別') }}" />
            <x-jet-input id="gender" type="gender" class="mt-1 block w-full" wire:model.defer="state.gender"
                autocomplete="gender" />
            <x-jet-input-error for="gender" class="mt-2" />
        </div>
        <!-- tel -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="tel" value="{{ __('電話番号') }}" />
            <x-jet-input id="tel" type="tel" class="mt-1 block w-full" wire:model.defer="state.tel"
                autocomplete="tel" />
            <x-jet-input-error for="tel" class="mt-2" />
        </div>
        <!-- Profile -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="profile" value="{{ __('自己紹介') }}" />
            <textarea name="profile" id="profile" cols="30" rows="5"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                wire:model.defer="state.profile"></textarea>
            <x-jet-input-error for="profile" class="mt-2" />
        </div>
        <!-- zip -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="zip" value="{{ __('郵便番号') }}" />
            <x-jet-input id="zip" type="zip" class="mt-1 block w-full" wire:model.defer="state.zip"
                autocomplete="zip" />
            <x-jet-input-error for="zip" class="mt-2" />
        </div>


        <!-- prefecture  prefecture_codeどうする？-->



        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="prefecture" value="{{ __('郵便番号') }}" />
            <x-jet-input id="prefecture" type="prefecture" class="mt-1 block w-full" wire:model.defer="state.prefecture"
                autocomplete="prefecture" />
            <x-jet-input-error for="prefecture" class="mt-2" />
        </div>
        <!-- address      -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="{{ __('住所') }}" />
            <textarea name="address" id="address" cols="30" rows="4"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                wire:model.defer="state.address"></textarea>
            <x-jet-input-error for="address" class="mt-2" />
        </div>
        <!-- birthdate -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="birthdate" value="{{ __('誕生日') }}" />
            <x-jet-input id="birthdate" type="birthdate" class="mt-1 block w-full"
                wire:model.defer="state.birthdate" autocomplete="birthdate" />
            <x-jet-input-error for="birthdate" class="mt-2" />
        </div>
        <!-- want_to_do     -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="want_to_do" value="{{ __('体験したいこと') }}" />
            <textarea name="want_to_do" id="want_to_do" cols="30" rows="4"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                wire:model.defer="state.want_to_do"></textarea>
            <x-jet-input-error for="want_to_do" class="mt-2" />
        </div>

        <!--   my_job   -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="my_job" value="{{ __('現在の仕事') }}" />
            <x-jet-input id="my_job" type="my_job" class="mt-1 block w-full" wire:model.defer="my_job"
                autocomplete="my_job" />
            <x-jet-input-error for="my_job" class="mt-2" />
        </div>
        <!--  language   -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="language" value="{{ __('話せる言語') }}" />
            <x-jet-input id="language" type="language" class="mt-1 block w-full" wire:model.defer="language"
                autocomplete="language" />
            <x-jet-input-error for="language" class="mt-2" />
        </div>
        <!--   university_name  -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="university_name" value="{{ __('大学名') }}" />
            <x-jet-input id="university_name" type="university_name" class="mt-1 block w-full" wire:model.defer="university_name"
                autocomplete="university_name" />
            <x-jet-input-error for="university_name" class="mt-2" />
        </div>
        <!--   university_major   -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="university_major" value="{{ __('大学の専攻') }}" />
            <x-jet-input id="university_major" type="university_major" class="mt-1 block w-full" wire:model.defer="university_major"
                autocomplete="university_major" />
            <x-jet-input-error for="university_major" class="mt-2" />
        </div>
        <!--   university_grade   -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="university_grade" value="{{ __('大学の学年') }}" />
            <x-jet-input id="university_grade" type="university_grade" class="mt-1 block w-full" wire:model.defer="university_grade"
                autocomplete="university_grade" />
            <x-jet-input-error for="university_grade" class="mt-2" />
        </div>
        <!--   volunteer_start  -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_start" value="{{ __('ボランティアの開始時期') }}" />
            <x-jet-input id="volunteer_start" type="volunteer_start" class="mt-1 block w-full" wire:model.defer="volunteer_start"
                autocomplete="volunteer_start" />
            <x-jet-input-error for="volunteer_start" class="mt-2" />
        </div>
        <!--   volunteer_region    -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_region" value="{{ __('ボランティアの地域') }}" />
            <x-jet-input id="volunteer_region" type="volunteer_region" class="mt-1 block w-full" wire:model.defer="volunteer_region"
                autocomplete="volunteer_region" />
            <x-jet-input-error for="volunteer_region" class="mt-2" />
        </div>
        <!--   volunteer_region    -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_region" value="{{ __('ボランティアの地域') }}" />
            <x-jet-input id="volunteer_region" type="volunteer_region" class="mt-1 block w-full" wire:model.defer="volunteer_region"
                autocomplete="volunteer_region" />
            <x-jet-input-error for="volunteer_region" class="mt-2" />
        </div>
        <!--   volunteer_type   -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_type" value="{{ __('ボランティアのタイプ(場所:1:現地へ行く 2:テレワーク)') }}" />
            <x-jet-input id="volunteer_type" type="volunteer_type" class="mt-1 block w-full" wire:model.defer="volunteer_type"
                autocomplete="volunteer_type" />
            <x-jet-input-error for="volunteer_type" class="mt-2" />
        </div>
        <!--  volunteer_cause    -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_cause" value="{{ __('ボランティアの地域') }}" />
            <x-jet-input id="volunteer_cause" type="volunteer_cause" class="mt-1 block w-full" wire:model.defer="volunteer_cause"
                autocomplete="volunteer_cause" />
            <x-jet-input-error for="volunteer_cause" class="mt-2" />
        </div>
        <!--  volunteer_length    -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer_length" value="{{ __('ボランティアの期間(期間:1:1ヶ月未満 2:1ヶ月以上)') }}" />
            <x-jet-input id="volunteer_length" type="volunteer_length" class="mt-1 block w-full" wire:model.defer="volunteer_length"
                autocomplete="volunteer_length" />
            <x-jet-input-error for="volunteer_length" class="mt-2" />
        </div>
        
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
