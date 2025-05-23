<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Ticket - ShadyCorp</title>
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
            background-color: #f5f5f5;
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
        <section class="edit-ticket">
            <h1>Modifier le Ticket</h1>

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ticket.update', $demande->id_demande) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label for="description_demande">Description :</label>
                    <textarea name="description_demande" id="description_demande" rows="3" required>{{ old('description_demande', $demande->description_demande) }}</textarea>
                </div>

                <div>
                    <label for="date_resultat">Date Résultat :</label>
                    <input type="date" name="date_resultat" id="date_resultat" value="{{ old('date_resultat', $demande->date_resultat) }}" required>
                </div>

                <div>
                    <label for="prix">Prix :</label>
                    <input type="number" step="0.01" name="prix" id="prix" value="{{ old('prix', $demande->prix) }}" required>
                </div>

                <div>
                    <label for="statut">Statut :</label>
                    <select name="id_status" id="statut" required>
                        @foreach ($statuts as $statut)
                            <option value="{{ $statut->id_status }}" 
                                {{ $demande->id_status == $statut->id_status ? 'selected' : '' }}>
                                {{ $statut->label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Enregistrer les modifications</button>
                    <a href="{{ route('ticket') }}" class="btn-cancel">Annuler</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
