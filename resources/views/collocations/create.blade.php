@extends('layouts.app')
@section('title', 'Créer une colocation')

@section('content')
    <h1>Créer une colocation</h1>

    <form method="POST" action="{{ route('colocations.store') }}">
        @csrf

        <div>
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>Description</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">Créer</button>
    </form>
@endsection