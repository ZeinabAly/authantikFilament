<div x-data="{RegisterModal: false}" x-cloak @open-register-modal.window="RegisterModal = true" @close-register-modal.window="RegisterModal = false">
    <div x-show="RegisterModal"
        class="fixed inset-0 z-[1000] bg-[#000000c7] flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95">

        <!-- Wrapper with scroll -->
        <div class="relative sm:min-w-[450px] min-w-[90%] max-h-screen overflow-y-auto bg-white rounded-xl shadow-md p-8">
            
            <!-- Button close -->
            <button class="absolute top-3 right-3" @click="RegisterModal = false">
                <x-icon name="btn-fermer" size="20" fill="#b90808" />
            </button>

            <!-- Titre -->
            <h2 class="section-title text-[2.1rem] text-center mb-1 text-green-950">Inscription</h2>
            <p class="text-center text-gray-500 text-xs mb-5">Vous devez être connecté pour effectuer cette action</p>

            <!-- Formulaire -->
            <form wire:submit="register" class="space-y-4 w-full">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input id="name" type="text" wire:model="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                         autofocus autocomplete="name">
                    @error('name') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" wire:model="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                        placeholder="auhantik@email.com" autocomplete="username">
                    @error('email') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <!-- Téléphone -->
                <div class="mt-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input id="phone" type="number" wire:model="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                        >
                    @error('phone') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input id="password" type="password" wire:model="password" placeholder="••••••••"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                         autocomplete="new-password">
                    @error('password') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                <!-- Confirmer le mot de passe -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" wire:model="password_confirmation" placeholder="••••••••"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                         autocomplete="new-password">
                    @error('password_confirmation') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                </div>

                @guest
                    <button type="submit"
                        class="w-full bg-[--color1-green] hover:bg-white border border-[--color1-green] hover:text-[--color1-green] text-white font-medium py-2.5 rounded-lg transition-colors">
                        Se connecter
                    </button>
                    <div class="mt-6 text-center text-sm text-gray-600 font-medium">
                        J'ai déjà un compte !
                        <button @click="$dispatch('close-register-modal'); $dispatch('open-login-modal')">
                            <p class="text-[--color2-yellow] font-semibold">Connexion</p>
                        </button>
                    </div>
                @endguest

                @auth
                    <p @click="RegisterModal = false"
                        class="w-full flexCenter cursor-pointer gap-3 bg-[--color2-yellow] border border-[--color2-yellow] py-2.5 text-white font-medium rounded-lg transition-colors">
                        <x-icon name="success" fill="#fff" />
                        <span>Vous êtes connecté !</span>
                    </p>
                    <p @click="RegisterModal = false"
                        class="font-semibold text-xs text-gray-700 cursor-pointer">Cliquez pour fermer</p>
                @endauth
            </form>
        </div>
    </div>
</div>
