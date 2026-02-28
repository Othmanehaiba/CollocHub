@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
            <div class="p-2 bg-red-100 rounded-lg text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            Tableau de Bord Administrateur
        </h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Users Stat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-gray-500 font-medium text-sm text-transform uppercase tracking-wide">Utilisateurs</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['users'] }}</p>
        </div>

        <!-- Colocs Stat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <h3 class="text-gray-500 font-medium text-sm text-transform uppercase tracking-wide">Colocations</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['colocations'] }}</p>
        </div>

        <!-- Expenses Stat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-gray-500 font-medium text-sm text-transform uppercase tracking-wide">Dépenses</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['expenses'] }}</p>
        </div>

        <!-- Banned Stat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                <h3 class="text-gray-500 font-medium text-sm text-transform uppercase tracking-wide">Bannis</h3>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['banned'] }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-semibold text-gray-900">Gestion des utilisateurs</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="uppercase tracking-wider border-b-2 border-gray-100 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-gray-500 font-medium">Utilisateur</th>
                        <th scope="col" class="px-6 py-4 text-gray-500 font-medium">Rôle</th>
                        <th scope="col" class="px-6 py-4 text-gray-500 font-medium">Réputation</th>
                        <th scope="col" class="px-6 py-4 text-gray-500 font-medium">Statut</th>
                        <th scope="col" class="px-6 py-4 text-gray-500 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_admin)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Membre
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-500 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900">{{ $user->reputation }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_banned)
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Banni
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Actif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(!$user->is_admin)
                                    @if(!$user->is_banned)
                                        <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md text-red-700 bg-white border border-red-200 hover:bg-red-50 hover:border-red-300 transition shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?')">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                Bannir
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md text-emerald-700 bg-white border border-emerald-200 hover:bg-emerald-50 hover:border-emerald-300 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Débannir
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400 italic">Action impossible</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(count($users) === 0)
            <div class="px-6 py-12 text-center">
                <p class="text-gray-500">Aucun utilisateur trouvé.</p>
            </div>
        @endif
    </div>
</div>
@endsection