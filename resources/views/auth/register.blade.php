<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Créer un compte
        </h2>
        <p class="mt-2 text-sm leading-6 text-gray-500">
            Rejoignez CollocHub pour simplifier votre vie en communauté
        </p>
    </div>

    @if($invitation)
        <div class="mb-6 rounded-md bg-blue-50 p-4 border border-blue-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-700">
                        Invitation détectée ! Créez votre compte pour rejoindre <strong>{{ $invitation->colocation->name }}</strong>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="invite_token" value="{{ $invitation?->token }}">

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Nom') }}</label>
            <div class="mt-2">
                <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required autofocus class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Email') }}</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email', $invitation?->email) }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            <x-input-error :messages="$errors->get('invite_token')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Mot de passe') }}</label>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Confirmer le mot de passe') }}</label>
            <div class="mt-2">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                {{ __('S\'inscrire') }}
            </button>
        </div>

        <!-- Login link -->
        <p class="mt-10 text-center text-sm text-gray-500">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500 transition">
                Connectez-vous ici
            </a>
        </p>
    </form>
</x-guest-layout>