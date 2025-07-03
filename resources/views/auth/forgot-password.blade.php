<x-guest-layout>
<h2 class="section-title text-[2.1rem] text-center mb-10 text-green-950 !important">Mot de passe oublié</h2>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Mot de passe oublié ? Aucun problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation qui vous permettra d’en choisir un nouveau.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="text-sm font-bold text-gray-700 mb-1">Email</label>
            <input 
            type="email" name="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-[--color1-green] hover:bg-green-900 border border-[--color1-green]  text-white font-medium py-2.5 px-5 rounded-lg transition-colors">
                Envoyer le lien de réinitialisation par e-mail
            </button>
        </div>

    </form>
</x-guest-layout>
