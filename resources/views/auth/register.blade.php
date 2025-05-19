<x-guest-layout>
    <h2 class="section-title text-[2.1rem] text-center mb-10 text-green-950 !important">Inscription</h2>
    <form method="POST" action="{{ route('register') }}" class="space-y-4 w-full" >
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="name" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="email" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input id="phone" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all" type="number" name="phone" :value="old('phone')" required autocomplete="" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700 mb-1" />

            <x-text-input id="password" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="block text-sm font-medium text-gray-700 mb-1" />

            <x-text-input placeholder="••••••••" id="password_confirmation" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="">
            <div class="mt-7 flex justify-center" >
                <button type="submit" class="w-full bg-[--color1-green] hover:bg-white border border-[--color1-green] hover:text-[--color1-green] text-white font-medium py-2.5 rounded-lg transition-colors">
                    S'inscrire
                </button>
            </div>
            <div class="mt-4 flex justify-center">
                <div class="mt-1 text-center text-sm text-gray-600 font-medium">
                    J'ai déjà un compte !
                    <a href="{{route('login')}}" class="text-[--color2-yellow] font-semibold">Connexion</a>
                </div>
            </div>

        </div>

    </form>
</x-guest-layout>
