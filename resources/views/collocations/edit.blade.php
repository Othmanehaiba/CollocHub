@extends('layouts.app')
@section('title', 'Modifier la colocation')

@section('content')
    <h1>Modifier la colocation</h1>

    <form method="POST" action="{{ route('colocations.update', $colocation) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $colocation->name) }}">
        </div>

        <div>
            <label>Description</label>
            <textarea name="description">{{ old('description', $colocation->description) }}</textarea>
        </div>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection