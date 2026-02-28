@extends('layouts.app')
@section('title', 'Créer une colocation')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour au tableau de bord
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                Créer une nouvelle colocation
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Remplissez les informations ci-dessous pour démarrer votre espace partagé.
            </p>
        </div>

        <form method="POST" action="{{ route('colocations.store') }}" class="p-8 space-y-6">
            @csrf

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Nom de la colocation <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Ex: La villa des potes"
                    class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Description <span class="text-gray-400 font-normal">(Optionnel)</span></label>
                <textarea id="description" name="description" rows="4" 
                    placeholder="Petite description de votre coloc..."
                    class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-x-4 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-600 transition">Annuler</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Créer la colocation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection