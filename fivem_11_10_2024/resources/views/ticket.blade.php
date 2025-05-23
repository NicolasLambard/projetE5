<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets - ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/ticket.css') }}">
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
        .hero {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 2rem 0;
        }
        
        .hero h1 {
            margin: 0;
            font-size: 2rem;
        }
        
        main {
            flex: 1;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        .ticket-list {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: left;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .ticket-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .en.cours {
            background-color: #ffecb3;
            color: #ff6f00;
        }
        
        .terminé {
            background-color: #c8e6c9;
            color: #2e7d32;
        }
        
        .inconnu {
            background-color: #e0e0e0;
            color: #757575;
        }
        
        .btn-action {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 5px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }
        
        .btn-chatbox {
            background-color: #9c27b0;
        }
        
        .btn-chatbox:hover {
            background-color: #7b1fa2;
        }
        
        .btn-details {
            background-color: #2196f3;
        }
        
        .btn-details:hover {
            background-color: #1976d2;
        }
        
        .btn-edit {
            background-color: #ff9800;
        }
        
        .btn-edit:hover {
            background-color: #f57c00;
        }
        
        .btn-delete {
            background-color: #f44336;
            border: none;
            cursor: pointer;
        }
        
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: auto;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        
        .empty-message {
            padding: 2rem;
            text-align: center;
            color: #666;
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

    <section class="hero">
        <h1>Les Tickets</h1>
        <p>Liste des demandes de service associées.</p>
    </section>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <section class="ticket-list">
            @if ($demandes->isEmpty())
                <p class="empty-message">Aucune demande trouvée.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date Résultat</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandes as $demande)
                            <tr>
                                <td>{{ $demande->description_demande }}</td>
                                <td>{{ $demande->date_resultat }}</td>
                                <td>{{ $demande->prix }} €</td>
                                <td>
                                @if ($demande->statut)
                                    <span class="ticket-status {{ strtolower($demande->statut->label) }}">
                                        {{ $demande->statut->label }}
                                    </span>
                                @else
                                    <span class="ticket-status inconnu">Inconnu</span>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('chatbox', $demande->id_demande) }}" class="btn-action btn-chatbox">Ouvrir Chatbox</a>
                                    <a href="{{ route('ticket.details', $demande->id_demande) }}" class="btn-action btn-details">Détails commande</a>
                                    
                                    @if (isset($isAdmin) && $isAdmin && $viewAll)
                                        <a href="{{ route('ticket.edit', $demande->id_demande) }}" class="btn-action btn-edit">Modifier</a>
                                        <form action="{{ route('ticket.destroy', $demande->id_demande) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');">Supprimer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
