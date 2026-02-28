<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'CollocHub') }} - Simplifiez votre colocation</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
        <!-- Header -->
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5 flex items-center gap-2">
                        <span class="sr-only">CollocHub</span>
                        <svg class="h-8 w-auto text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-2xl font-bold tracking-tight text-indigo-600">CollocHub</span>
                    </a>
                </div>
                
                <div class="flex flex-1 justify-end gap-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition">Dashboard <span aria-hidden="true">&rarr;</span></a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 transition">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <div class="relative isolate px-6 pt-14 lg:px-8 min-h-screen flex items-center justify-center">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                        La gestion de colocation nouvelle génération. <a href="{{ route('register') }}" class="font-semibold text-indigo-600"><span class="absolute inset-0" aria-hidden="true"></span>En savoir plus <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-6">
                    Simplifiez la vie en <span class="text-indigo-600">colocation</span>
                </h1>
                
                <p class="mt-6 text-lg leading-8 text-gray-600 mb-10 text-balance">
                    Dépenses partagées, répartition des tâches, alertes et communication. CollocHub est l'outil ultime pour gérer votre cocon sereinement et éviter les prises de tête.
                </p>
                
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md bg-indigo-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition transform hover:-translate-y-1">
                            Accéder à mon Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition transform hover:-translate-y-1">
                            Commencer gratuitement
                        </a>
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-indigo-600 py-3.5 transition group">
                            Déjà membre ? <span class="group-hover:translate-x-1 inline-block transition-transform" aria-hidden="true">&rarr;</span>
                        </a>
                    @endauth
                </div>
            </div>

            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
        </div>

        <!-- Features (Brief presentation) -->
        <div class="py-24 sm:py-32 bg-gray-50">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600">Gérez tout plus rapidement</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Tout ce dont vous avez besoin</p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Oubliez les tableaux Excel compliqués et les discussions WhatsApp à rallonge. CollocHub centralise tout.
                    </p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Dépenses transparentes
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Sachez exactement qui a payé quoi et qui doit combien avec notre calculateur automatique de balances.</dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900">
                                <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                Gestion des membres
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">Invitez de nouveaux colocataires facilement, gérez les départs et gardez l'historique de votre colocation.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </body>
</html>
