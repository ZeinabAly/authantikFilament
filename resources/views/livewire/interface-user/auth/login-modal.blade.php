<div x-data="{ loginModal: false, RegisterModal: false }" x-cloak
     @open-login-modal.window="loginModal = true"
     @close-login-modal.window="loginModal = false">

    <div x-show="loginModal"
         class="fixed inset-0 z-[1000] bg-[#000000c7] flexCenter py-20 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">

        <div class="bg-white rounded-xl shadow-md sm:min-w-[450px] min-w-[90%] p-8 relative">
            <!-- Close button -->
            <button class="absolute top-3 right-3" @click="loginModal = false">
                <x-icon name="btn-fermer" size="20" fill="#b90808" />
            </button>

            <!-- Title -->
            <h2 class="section-title text-[2.1rem] text-center mb-1 text-green-950">Connexion</h2>
            <p class="text-center text-gray-500 text-xs mb-5">Vous devez être connecté pour effectuer cette action</p>

            <!-- Login Form -->
            <form wire:submit="login" class="space-y-4 w-full">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                           placeholder="auhantik@email.com">
                    @error('email')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" wire:model="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Guest (not connected) -->
                @guest
                    <button type="submit"
                            class="w-full bg-[--color1-green] hover:bg-white border border-[--color1-green] hover:text-[--color1-green] text-white font-medium py-2.5 rounded-lg transition-colors">
                        Se connecter
                    </button>

                    <div class="mt-6 text-center text-sm text-gray-600 font-medium">
                        Je n'ai pas de compte ?
                        <button type="button"
                                @click="$dispatch('close-login-modal'); $dispatch('open-register-modal')"
                                class="text-[--color2-yellow] font-semibold ml-1">
                            Inscription
                        </button>
                    </div>
                @endguest

                <!-- Authenticated -->
                @auth
                    <p @click="loginModal = false"
                       class="w-full flexCenter cursor-pointer gap-3 bg-[--color2-yellow] border border-[--color2-yellow] py-2.5 text-white font-medium rounded-lg transition-colors">
                        <x-icon name="success" fill="#fff" />
                        <span>Vous êtes connecté !</span>
                    </p>
                    <p @click="loginModal = false"
                       class="font-semibold text-xs text-gray-700 text-center cursor-pointer mt-2">
                        Cliquez pour fermer
                    </p>
                @endauth
            </form>
        </div>
    </div>
</div>
