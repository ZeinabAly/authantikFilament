<!-- mon-compte-manager -->
<div>
    <main class="monCompte">

        <div class="section-img-infos">
            <section class="section1">
                <div class="">
                    <h2 class="sectionTitre">
                        {{-- __('Mofifier l\'image') --}}
                        {{auth()->user()->name}}
                    </h2>
                    <div class="img-btn-content">
                        <div class="">
                            @if(is_null(auth()->user()->image))
                            <div class="userImgContent" id="userImgContent">
                                <x-icon name="user-plein" fill="#1A1F2C" size="90" class="border-2 border-[#1A1F2C] p-3 rounded-full" />
                            </div>
                            @else
                                <div class="userImgContent" id="userImgContent">
                                    <img src="{{asset('storage/'.auth()->user()->image)}}" alt="image utilisateur {{auth()->user()->name}}" class="w-[150px] h-[150px] border-2 border-[#1A1F2C] p-3 rounded-full object-top">
                                </div>
                            @endif
                        </div>
                        <div class="">
                            <!-- Le component pour modifier la photo -->
                            <livewire:client.update-profile-image :user="$user" />
                        </div>
                    </div>
                </div>
            </section>
    
            <section class="section2 mt-10 bg-white">
                <header>
                    <h2 class="sectionTitre">
                        {{ __('Mes Informations') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Modifier mes informations personnelles") }}
                    </p>
                </header>
            
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            
                <form method="post" class="mt-6 space-y-6" wire:submit="updateInformations">
                    @csrf
                    @method('patch')
            
                    <div>
                        <x-input-label for="name" :value="__('Nom')" class="formLabel" />
                        <x-text-input id="name" name="name" type="text" class="profilInput" :value="old('name', $user->name)" required autofocus autocomplete="name" wire:model.live="name" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="formLabel" />
                        <x-text-input id="email" name="email" type="email" wire:model.live="email" class="profilInput" :value="old('email', $user->email)" required autocomplete="email" wire:model.live="email" />
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}
            
                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
            
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
    
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" class="formLabel" />
                        <x-text-input id="phone" name="phone" type="text" class="profilInput" :value="old('phone', $user->phone)" required autofocus autocomplete="phone" wire:model.live="phone" />
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="flex items-center gap-4">
                        <x-primary-button class="btnCommander">{{ __('Modifier') }}</x-primary-button>
            
                        @if (session('status') === 'Profil modifié')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Modifié !') }}</p>
                        @endif
                    </div>
                </form>
            </section>
            
        </div>

        <!-- Modifier le mot de passe -->
        <section class="" x-data = "{ passwordEdit : false}" x-cloak>
            <header @click = "passwordEdit = !passwordEdit" class="flex justify-between">
                <div class="">
                    <h2 class="sectionTitre">
                        {{ __('Modifier mon mot de passe') }}
                    </h2>
    
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>
                <div class="icon-light">
                    <x-icon name="angle-up" fill="#000" />
                </div>
                <div class="icon-dark">
                    <x-icon name="angle-up" fill="#fff" />
                </div>
            </header>

            <form method="post" wire:submit.prevent="updatePassword"  class="mt-6 space-y-6" x-show="passwordEdit" @click.outside="passwordEdit = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                @csrf
                <!-- @method('put') -->

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="formLabel" />
                    <x-text-input wire:model.live="current_password" id="update_password_current_password" name="current_password" type="password" class="profilInput" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('Nouveau mot de passe ')" class="formLabel" />
                    <x-text-input wire:model.live="password" id="update_password_password" name="password" type="password" class="profilInput" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" class="formLabel" />
                    <x-text-input wire:model.live="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="profilInput" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="btnCommander">{{ __('Valider') }}</x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class=""
                        >{{ __('Modifié.') }}</p>
                    @endif
                </div>
            </form>
        </section>

        <!-- Supprimer le compte -->
            
        {{-- <section class="space-y-6 mt-10 bg-white">
            <header>
                <h2 class="sectionTitre">
                    {{ __('Supprimer mon compte') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
                </p>
            </header>

            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="btnCommander btnAnnuler"
            >{{ __('Supprimer') }}</x-danger-button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" wire:submit="destroyAccount" class="p-6">
                    @csrf
                    <!-- @method('delete') -->

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Une fois votre compte supprimé, toutes vos ressources et données seront définitivement supprimées. Veuillez entrez votre mot de passe pour confirmer la suppression.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only formLabel" />

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}" wire:model.live="password" 
                        />

                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <x-secondary-button x-on:click="$dispatch('close')" class="btnCommander">
                            {{ __('Annuler') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3 btnAnnuler" type="submit" wire:submit="destroyAccount">
                            {{ __('Supprimer') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </section> --}}

        @yield('dashAdmin')
    </main>
</div>
