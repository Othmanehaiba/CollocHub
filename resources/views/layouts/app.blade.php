<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollocHub – @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>

        @auth
            @if(auth()->user()->activeMembership)
                @php $id = auth()->user()->activeMembership->colocation_id; @endphp
                <a href="{{ route('colocations.show', $id) }}">Ma colocation</a>
                <a href="{{ route('colocations.expenses.index', $id) }}">Dépenses</a>
            @else
                <a href="{{ route('colocations.create') }}">Créer une colocation</a>
            @endif

            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}">Admin</a>
            @endif

            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </nav>

    <main>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        @if($errors->any())
            <ul style="color: red;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @yield('content')
    </main>
</body>
</html>