<x-guest-layout >
    <h2 class="section-title text-[2.1rem] text-center mb-10 text-green-950 !important">Connexion</h2>
    <!-- component -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4 w-full">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
            type="email" name="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            placeholder="auhantik@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-3xl" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input 
            type="password" name="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-900 focus:border-[--color1-green] outline-none transition-all"
            placeholder="••••••••"
            />
        </div>

        <div class="flexBetween gap-4">
            <label class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
            <span class="ml-2 text-sm text-gray-600 font-medium">Se rappeler de moi</span>
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-[--color2-yellow] font-semibold">Mot de passe oublié ?</a>
            @endif  
        </div>

        <button type="submit" class="w-full bg-[--color1-green] hover:bg-white border border-[--color1-green] hover:text-[--color1-green] text-white font-medium py-2.5 rounded-lg transition-colors">
            Se connecter
        </button>
        <div class="mt-6 text-center text-sm text-gray-600 font-medium">
            Je n'ai pas de compte? 
            <a href="{{route('register')}}" class="text-[--color2-yellow] font-semibold">Inscription</a>
        </div>
    </form>
</x-guest-layout>
