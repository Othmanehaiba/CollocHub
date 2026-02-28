@extends('layouts.app')
@section('title', 'Ajouter une dépense')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-8">
        <a href="{{ route('colocations.show', $colocation) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la colocation
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                Ajouter une dépense
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Saisissez les détails de la dépense pour mettre à jour les soldes de la colocation.
            </p>
        </div>

        <form method="POST" action="{{ route('colocations.expenses.store', $colocation) }}" class="p-8 space-y-6">
            @csrf

            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Titre de la dépense <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required autofocus
                    placeholder="Ex: Courses Carrefour"
                    class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catégorie & Montant (Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Montant -->
                <div>
                    <label for="amount" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Montant (€) <span class="text-red-500">*</span></label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required
                            class="block w-full rounded-md border-0 py-2 pl-7 pr-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                            placeholder="0.00"
                        >
                    </div>
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div>
                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Catégorie <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" required
                        class="block w-full rounded-md border-0 py-2 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                    >
                        <option value="" disabled selected>Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Date & Payeur (Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div>
                    <label for="expense_date" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Date de la dépense <span class="text-red-500">*</span></label>
                    <input type="date" id="expense_date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}" required
                        class="block w-full rounded-md border-0 py-2 pl-3 pr-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                    >
                    @error('expense_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payé par -->
                <div>
                    <label for="paid_by" class="block text-sm font-medium leading-6 text-gray-900 mb-2">Payé par <span class="text-red-500">*</span></label>
                    <select id="paid_by" name="paid_by" required
                        class="block w-full rounded-md border-0 py-2 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 transition"
                    >
                        @foreach($members as $membership)
                            <option value="{{ $membership->user->id }}" {{ (old('paid_by') == $membership->user->id || auth()->id() == $membership->user->id) ? 'selected' : '' }}>
                                {{ $membership->user->name }} {{ auth()->id() == $membership->user->id ? '(Vous)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('paid_by')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-x-4 border-t border-gray-100">
                <a href="{{ route('colocations.show', $colocation) }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-600 transition">Annuler</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Enregistrer la dépense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection