@extends('layouts.app')
@section('title', 'Admin')

@section('content')
    <h1>Dashboard Admin</h1>

    <p>Utilisateurs : {{ $stats['users'] }}</p>
    <p>Colocations : {{ $stats['colocations'] }}</p>
    <p>Dépenses : {{ $stats['expenses'] }}</p>
    <p>Bannis : {{ $stats['banned'] }}</p>

    <hr>

    <h2>Utilisateurs</h2>

    @foreach($users as $user)
        <div style="margin-bottom:10px; border:1px solid #ccc; padding:10px;">
            <p>{{ $user->name }} ({{ $user->email }})</p>
            <p>Admin : {{ $user->is_admin ? 'Oui' : 'Non' }}</p>
            <p>Banni : {{ $user->is_banned ? 'Oui' : 'Non' }}</p>
            <p>Réputation : {{ $user->reputation }}</p>

            @if(!$user->is_admin)
                @if(!$user->is_banned)
                    <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                        @csrf
                        <button type="submit">Bannir</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                        @csrf
                        <button type="submit">Débannir</button>
                    </form>
                @endif
            @endif
        </div>
    @endforeach
@endsection