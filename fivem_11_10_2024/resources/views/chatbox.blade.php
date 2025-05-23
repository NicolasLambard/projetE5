<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox - Demande #{{ $demande->id_demande }}</title>
    <link rel="stylesheet" href="{{ asset('styles/chatbox.css') }}">
    <style>
        /* Styles globaux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header et Navigation */
        header {
            background-color: #333;
            color: white;
            padding: 0;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
        }
        
        .logo {
            font-weight: bold;
            font-size: 1.5rem;
            padding-left: 20px;
        }
        
        .nav-links {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #3498db;
        }
        
        .logout-btn {
            padding-right: 20px;
        }
        
        .logout-btn button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .logout-btn button:hover {
            color: #3498db;
        }
        
        /* Reste des styles */
        main {
            flex: 1;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">ShadyCorp</div>
            <div class="nav-links">
                <a href="{{ url('/') }}">Accueil</a>
                <a href="{{ url('/demande') }}">Demande</a>
                <a href="{{ url('/services') }}">Services</a>
                <a href="{{ route('ticket') }}">Mes Tickets</a>
                <a href="{{ route('commentaires') }}">Commentaires</a>
                @if(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)
                    <a href="{{ route('ticket.all') }}">Voir tous les tickets</a>
                @endif
            </div>
            <div class="logout-btn">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
            </div>
        </div>
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
