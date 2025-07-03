<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label class="text-sm font-bold text-gray-700 mb-1">Email</label>
            <input 
            type="email" name="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            required :value="old('email', $request->email)"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="text-sm font-bold text-gray-700 mb-1">Mot de passe</label>
            <input 
            type="password" name="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            required :value="old('password')"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="text-sm font-bold text-gray-700 mb-1">Confirmer le mot de passe</label>
            <input 
            type="password" name="password_confirmation"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            required :value="old('password_confirmation')"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-[--color1-green] hover:bg-green-900 border border-[--color1-green]  text-white font-medium py-2.5 px-5 rounded-lg transition-colors">
                Réinitialiser 
            </button>
        </div>
    </form>
</x-guest-layout>
