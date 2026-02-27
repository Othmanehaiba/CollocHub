<p>Bonjour,</p>

<p>Vous avez été invité à rejoindre la colocation : <strong>{{ $colocation->name }}</strong>.</p>

<p>
    <a href="{{ route('register', ['invite' => $token]) }}"> <!-- i'll replace register with dahsboard -->
        Créer un compte et rejoindre la colocation
    </a>
</p>

<p>Ce lien expire dans 7 jours.</p>