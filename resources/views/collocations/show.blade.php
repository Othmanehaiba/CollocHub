@extends('layouts.app')
@section('title', $colocation->name)

@section('content')
    <h1>{{ $colocation->name }}</h1>
    <p>Status : {{ $colocation->status }}</p>
    <p>Description : {{ $colocation->description ?: 'Aucune description' }}</p>
    <p>Mon solde : €{{ number_format($myBalance, 2) }}</p>

    @php
        $myMembership = $colocation->memberships
            ->where('user_id', auth()->id())
            ->where('left_at', null)
            ->first();

        $isOwner = $myMembership && $myMembership->role === 'owner';
    @endphp

    @if($isOwner || auth()->user()->is_admin)
        <hr>
        <h2>Actions owner</h2>

        <a href="{{ route('colocations.edit', $colocation) }}">Modifier la colocation</a>

        <form method="POST" action="{{ route('colocations.cancel', $colocation) }}">
            @csrf
            <button type="submit">Annuler la colocation</button>
        </form>

        <form method="POST" action="{{ route('colocations.destroy', $colocation) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer définitivement</button>
        </form>

        <h3>Inviter un membre</h3>
        <form method="POST" action="{{ route('invitations.store', $colocation) }}">
            @csrf
            <input type="email" name="email" placeholder="Email du membre">
            <button type="submit">Envoyer l’invitation</button>
        </form>
    @elseif($myMembership)
        <form method="POST" action="{{ route('colocations.leave', $colocation) }}">
            @csrf
            <button type="submit">Quitter la colocation</button>
        </form>
    @endif

    <hr>
    <h2>Membres</h2>
    @foreach($colocation->memberships->where('left_at', null) as $membership)
        <p>
            {{ $membership->user->name }}
            ({{ $membership->role }})
            — réputation : {{ $membership->user->reputation }}

            @if(($isOwner || auth()->user()->is_admin) && $membership->role !== 'owner')
                <form method="POST" action="{{ route('colocations.remove', [$colocation, $membership->user]) }}" style="display:inline;">
                    @csrf
                    <button type="submit">Retirer</button>
                </form>
            @endif
        </p>
    @endforeach

    <hr>
    <h2>Balances</h2>
    @foreach($balances as $row)
        <p>
            {{ $row['user']->name }} :
            payé €{{ number_format($row['paid'], 2) }},
            part €{{ number_format($row['share'], 2) }},
            solde €{{ number_format($row['balance'], 2) }}
        </p>
    @endforeach

    <hr>
    <h2>Qui doit à qui ?</h2>
    @forelse($settlements as $s)
        <p>
            {{ $s['from']->name }} doit {{ $s['to']->name }}
            — €{{ number_format($s['amount'], 2) }}

            @if($s['from']->id === auth()->id())
                <form method="POST" action="{{ route('payments.store', $colocation) }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                    <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                    <button type="submit">Marquer payé</button>
                </form>
            @endif
        </p>
    @empty
        <p>Aucun remboursement en attente.</p>
    @endforelse

    <hr>
    <h2>Dépenses</h2>
    <a href="{{ route('colocations.expenses.create', $colocation) }}">Ajouter une dépense</a>

    <form method="GET" action="{{ route('colocations.show', $colocation) }}">
        <label>Filtrer par mois</label>
        <select name="month">
            <option value="">Tous les mois</option>
            @foreach($availableMonths as $month)
                <option value="{{ $month }}" {{ request('month') === $month ? 'selected' : '' }}>
                    {{ $month }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrer</button>
    </form>

    @forelse($expenses as $expense)
        <div style="margin-top:12px; border:1px solid #ccc; padding:10px;">
            <p><strong>{{ $expense->title }}</strong></p>
            <p>Catégorie : {{ $expense->category->name }}</p>
            <p>Montant : €{{ number_format($expense->amount, 2) }}</p>
            <p>Date : {{ $expense->expense_date->format('Y-m-d') }}</p>
            <p>Payé par : {{ $expense->payer->name }}</p>

            @if($expense->paid_by === auth()->id() || $isOwner || auth()->user()->is_admin)
                <a href="{{ route('colocations.expenses.edit', [$colocation, $expense]) }}">Modifier</a>

                <form method="POST" action="{{ route('colocations.expenses.destroy', [$colocation, $expense]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            @endif
        </div>
    @empty
        <p>Aucune dépense.</p>
    @endforelse
@endsection