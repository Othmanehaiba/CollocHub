<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
            Welcome back
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Log in to continue to <span class="font-semibold text-slate-700">CollocHub</span>
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Global Errors -->
    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700" />
            <x-text-input
                id="email"
                class="mt-1 block w-full rounded-xl border-slate-300 bg-white/80 px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-slate-700" />
                @if (Route::has('password.request'))
                    <a
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-700 hover:underline"
                        href="{{ route('password.request') }}"
                    >
                        Forgot?
                    </a>
                @endif
            </div>

            <x-text-input
                id="password"
                class="mt-1 block w-full rounded-xl border-slate-300 bg-white/80 px-4 py-2.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                >
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                {{ __('Log in') }}
            </button>
        </div>

        <!-- Register link -->
        <div class="text-center pt-2">
            <p class="text-sm text-slate-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                    Register
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>