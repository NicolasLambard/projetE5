<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire une Demande de Service - ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/demande.css') }}">
    <style>
        /* Couleurs d'origine restaurées */
        header {
            background-color: #333;
        }
        
        .hero {
            background-color: #3498db;
        }
        
        .btn-primary {
            background-color: #3498db;
        }
        
        footer {
            background-color: #333;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShadyCorp</div>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ url('/demande') }}">Demande</a></li>
                <li><a href="{{ url('/services') }}">Services</a></li>
                <li><a href="{{ route('ticket') }}">Mes Tickets</a></li>
                <li><a href="{{ route('commentaires') }}">Commentaires</a></li>
                @if(auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2)
                    <li><a href="{{ route('ticket.all') }}">Voir tous les tickets</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1>Faire une Demande de Service</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre une demande personnalisée.</p>
    </section>

    <main>
        <section class="form-section">
            <h2>Formulaire de Demande de Service</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('demandes.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="description">Description du service souhaité :</label>
                <textarea id="description" name="description_demande" class="form-control" required>{{ old('description_demande') }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_resultat">Date souhaitée :</label>
                <input type="date" id="date_resultat" name="date_resultat" class="form-control" value="{{ old('date_resultat') }}" required>
            </div>

            <div class="form-group">
    <label for="services">Sélectionnez le service :</label>
    <select id="services" name="description_resultat" class="form-control" required>
        <option value="">-- Choisissez un service --</option>
        @foreach($services as $service)
            <option value="{{ $service->nom_service }}" {{ old('description_resultat') == $service->nom_service ? 'selected' : '' }}>
                {{ $service->nom_service }}
            </option>
        @endforeach
    </select>
</div>



            <div class="form-group">
                <label for="tarif">Proposition de tarif (en euros) :</label>
                <input type="number" id="tarif" name="prix" class="form-control" step="0.01" placeholder="Tarif proposé" value="{{ old('prix') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>

        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
