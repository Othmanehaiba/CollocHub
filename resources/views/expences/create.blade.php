@extends('layouts.app')
@section('title', 'Ajouter une dépense')

@section('content')
    <h1>Ajouter une dépense</h1>

    <form method="POST" action="{{ route('colocations.expenses.store', $colocation) }}">
        @csrf

        <div>
            <label>Titre</label>
            <input type="text" name="title" value="{{ old('title') }}">
        </div>

        <div>
            <label>Catégorie</label>
            <select name="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Montant</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}">
        </div>

        <div>
            <label>Date</label>
            <input type="date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}">
        </div>

        <div>
            <label>Payé par</label>
            <select name="paid_by">
                @foreach($members as $membership)
                    <option value="{{ $membership->user->id }}">
                        {{ $membership->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Enregistrer</button>
    </form>
@endsection