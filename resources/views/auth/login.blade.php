<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Bon retour
        </h2>
        <p class="mt-2 text-sm leading-6 text-gray-500">
            Connectez-vous pour accéder à votre colocation
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Global Errors -->
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email') }}</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required autofocus class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Mot de passe') }}</label>
                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                            Mot de passe oublié ?
                        </a>
                    </div>
                @endif
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
            <label for="remember_me" class="ml-3 block text-sm leading-6 text-gray-900">
                {{ __('Se souvenir de moi') }}
            </label>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                {{ __('Se connecter') }}
            </button>
        </div>

        <!-- Register link -->
        <p class="mt-10 text-center text-sm text-gray-500">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500 transition">
                Créez-en un ici
            </a>
        </p>
    </form>
</x-guest-layout>