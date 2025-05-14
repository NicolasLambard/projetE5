<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox - Demande #{{ $demande->id_demande }}</title>
    <link rel="stylesheet" href="{{ asset('styles/chatbox.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShadyCorp</div>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ url('/services') }}">Service</a></li>
                <li><a href="{{ url('/demande') }}">Demande</a></li>
                <li><a href="{{ route('ticket') }}">Mes Tickets</a></li>
                @if(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)
                    <li><a href="{{ route('ticket.all') }}">Voir tous les tickets</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Chatbox pour la demande #{{ $demande->id_demande }}</h1>
            <p>Communiquez facilement avec le support ou l'administrateur.</p>
        </section>

        <section class="chat-messages">
            @foreach ($demande->chatBoxLogs as $log)
                <div class="chat-message 
                    {{ $log->user->role->id_role === 1 || $log->user->role->id_role === 2 ? 'admin-message' : 'client-message' }}">
                    <strong>
                        {{ $log->user->name ?? 'Utilisateur inconnu' }}
                        ({{ $log->user->role->nom ?? 'Rôle inconnu' }}):
                    </strong>
                    <p>{{ $log->description }}</p>
                    <small>{{ $log->date }}</small>
                </div>
            @endforeach
        </section>

        <section class="chat-form">
            <form action="{{ route('sendMessage', $demande->id_demande) }}" method="POST">
                @csrf
                <textarea name="message" rows="3" placeholder="Écrivez votre message ici..." required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
