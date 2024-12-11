<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Ticket - ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/ticket.css') }}">
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
            </ul>
        </nav>
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
