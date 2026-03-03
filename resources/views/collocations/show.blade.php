@extends('layouts.app')
@section('title', $colocation->name)

@section('content')

@php
    $myMembership = $colocation->memberships
        ->where('user_id', auth()->id())
        ->where('left_at', null)
        ->first();

    $isOwner = $myMembership && $myMembership->role === 'owner';
    $isAdmin = auth()->user()->is_admin;
@endphp

<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Hero Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute top-0 inset-x-0 h-2 bg-indigo-600"></div>
        <div class="px-8 py-8 md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900 leading-tight">
                        {{ $colocation->name }}
                    </h1>
                    @if($colocation->status === 'active')
                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ ucfirst($colocation->status) }}
                        </span>
                    @endif
                </div>
                
                @if($colocation->description)
                    <p class="text-base text-gray-500 max-w-2xl">{{ $colocation->description }}</p>
                @endif
                
                <div class="mt-4 flex items-center text-sm">
                    <div class="bg-indigo-50 text-indigo-700 font-semibold px-4 py-2 rounded-lg inline-flex items-center gap-2 border border-indigo-100">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Mon solde : 
                        <span class="{{ $myBalance < 0 ? 'text-red-600' : 'text-indigo-700' }}">
                            {{ number_format($myBalance, 2) }} €
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex flex-col sm:flex-row gap-3 md:mt-0 md:ml-4">
                @if($isOwner || $isAdmin)
                    <!-- <a href="{{ route('colocations.edit', $colocation) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Modifier
                    </a> -->
                @elseif($myMembership)
                    <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-red-300 rounded-lg text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?')">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Quitter
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Owner / Admin Actions Zone -->
    @if($isOwner || $isAdmin)
        <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
            <h2 class="text-sm font-bold text-amber-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Zone d'administration
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @if($isOwner)
                <div class="bg-white rounded-lg p-5 shadow-sm border border-amber-100">
                    <h3 class="font-semibold text-gray-900 mb-1">Créer une catégorie</h3>
                    <p class="text-xs text-gray-500 mb-3">Ajoutez une nouvelle catégorie pour les dépenses.</p>

                    <form method="POST" action="{{ route('colocations.categories.store', $colocation) }}" class="flex items-start gap-3">
                        @csrf

                        <div class="flex-1">
                            <label for="category_name" class="sr-only">Nom de la catégorie</label>
                            <input
                                type="text"
                                id="category_name"
                                name="name"
                                placeholder="Ex: Courses, Loyer, Internet..."
                                required
                                class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            >

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                        >
                            Ajouter
                        </button>
                    </form>
                </div>
            @endif
                <!-- Manage Coloc -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-amber-100 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Gestion de la colocation</h3>
                        <p class="text-xs text-gray-500 mb-4">Actions critiques à utiliser avec précaution.</p>
                    </div>
                    
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('colocations.cancel', $colocation) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-1.5 border border-amber-300 shadow-sm text-xs font-medium rounded text-amber-700 bg-white hover:bg-amber-50 transition" onclick="return confirm('Suspendre/Annuler la colocation ?')">
                                Annuler
                            </button>
                        </form>
                        
                        <!-- <form method="POST" action="{{ route('colocations.destroy', $colocation) }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 transition" onclick="return confirm('Êtes-vous sûr de vouloir SIMPRIMER DÉFINITIVEMENT cette colocation ?')">
                                Supprimer
                            </button>
                        </form> -->
                    </div>
                </div>
                
                <!-- Invite -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-amber-100 md:col-span-1 lg:col-span-2">
                    <h3 class="font-semibold text-gray-900 mb-1">Inviter un nouveau membre</h3>
                    <p class="text-xs text-gray-500 mb-3">Envoyez une invitation par e-mail pour rejoindre cette colocation.</p>
                    
                    <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="flex items-start gap-3">
                        @csrf
                        <div class="flex-1">
                            <label for="email" class="sr-only">Email du membre</label>
                            <input type="email" id="email" name="email" placeholder="adresse@email.com" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Inviter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Sidebar (Members & Balances) -->
        <div class="space-y-8 lg:col-span-1">
            
            <!-- Members List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="text-base font-semibold text-gray-900">Membres</h2>
                    <span class="inline-flex items-center justify-center bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ $colocation->memberships->where('left_at', null)->count() }}
                    </span>
                </div>
                
                <ul class="divide-y divide-gray-100">
                    @foreach($colocation->memberships->where('left_at', null) as $membership)
                        <li class="px-6 py-4 hover:bg-gray-50/50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0">
                                        {{ substr($membership->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $membership->user->name }}
                                            @if($membership->user_id === auth()->id())
                                                <span class="text-gray-400 text-xs font-normal ml-1">(Vous)</span>
                                            @endif
                                        </p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($membership->role === 'owner')
                                                <span class="text-[10px] uppercase font-bold text-indigo-600 tracking-wider">Owner</span>
                                            @endif
                                            <span class="text-xs text-amber-600 flex items-center">
                                                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                {{ $membership->user->reputation }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(($isOwner || $isAdmin) && $membership->role !== 'owner')
                                    <form method="POST" action="{{ route('colocations.remove', [$colocation, $membership->user]) }}">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition p-1" title="Retirer" onclick="return confirm('Retirer ce membre ?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Global Balances -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-base font-semibold text-gray-900">Soldes globaux</h2>
                </div>
                
                <ul class="divide-y divide-gray-100">
                    @foreach($balances as $row)
                        <li class="px-6 py-4 flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $row['user']->name }}</span>
                                <span class="text-sm font-bold {{ $row['balance'] >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $row['balance'] >= 0 ? '+' : '' }}{{ number_format($row['balance'], 2) }} €
                                </span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Payé : {{ number_format($row['paid'], 2) }} €</span>
                                <span>Part : {{ number_format($row['share'], 2) }} €</span>
                            </div>
                            
                            <!-- Progress bar visualization -->
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                @php
                                    // Visual clue logic for balance
                                    $percent = ($row['paid'] > 0 || $row['share'] > 0) ? min(100, max(0, ($row['paid'] / max($row['share'], 0.01)) * 50)) : 0;
                                    $color = $row['balance'] >= 0 ? 'bg-green-500' : 'bg-red-500';
                                @endphp
                                <div class="{{ $color }} h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        
        <!-- Main Content Area (Expenses & Settlements) -->
        <div class="space-y-8 lg:col-span-2">
            
            <!-- Settlements Alert Zone (Who owes who) -->
            @if(count($settlements) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-orange-100 bg-orange-50/50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        <h2 class="text-base font-semibold text-orange-900">Qui doit à qui ?</h2>
                    </div>
                    
                    <ul class="divide-y divide-gray-100">
                        @foreach($settlements as $s)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-orange-50/30 transition">
                                <div class="flex items-center gap-3">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ $s['from']->name }}</span>
                                        <span class="text-xs text-gray-500">Doit à</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ $s['to']->name }}</span>
                                        <span class="text-xs font-bold text-orange-600">{{ number_format($s['amount'], 2) }} €</span>
                                    </div>
                                </div>
                                
                                @if($s['from']->id === auth()->id())
                                    <form method="POST" action="{{ route('payments.store', $colocation) }}">
                                        @csrf
                                        <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                        <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 shadow-sm transition">
                                            Marqué Payé
                                        </button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Expenses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Dépenses
                    </h2>

                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('colocations.show', $colocation) }}" class="flex items-center gap-2">
                            <label for="month" class="sr-only">Mois</label>
                            <select id="month" name="month" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-xs">
                                <option value="">Tous les mois</option>
                                @foreach($availableMonths as $month)
                                    <option value="{{ $month }}" {{ request('month') === $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y') }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="p-1.5 text-gray-500 hover:text-indigo-600 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('colocations.expenses.create', $colocation) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-1.5 px-3 rounded text-sm font-medium transition shadow-sm inline-flex items-center gap-1 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="hidden sm:inline">Ajouter</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Sujet</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payé par</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($expenses as $expense)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-100 text-gray-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $expense->title }}</div>
                                                <div class="flex items-center text-xs text-gray-500 space-x-2 mt-0.5">
                                                    <span>{{ $expense->expense_date->translatedFormat('d M Y') }}</span>
                                                    <span>•</span>
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800">
                                                        {{ $expense->category->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ number_format($expense->amount, 2) }} €</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs font-bold mr-2">
                                                {{ substr($expense->payer->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-900">{{ $expense->payer->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        
                                            <span class="text-gray-300">-</span>
                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500 bg-gray-50/30">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                                        Aucune dépense enregistrée sur cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection