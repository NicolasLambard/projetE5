<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets - ShadyCorp</title>
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
                @if (isset($isAdmin) && $isAdmin)
                    <li><a href="{{ route('ticket') }}?view=all">Voir tous les tickets</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1>Mes Tickets</h1>
        <p>Liste des demandes de service associées.</p>
    </section>

    <main>
        <section class="ticket-list">
            @if ($demandes->isEmpty())
                <p>Aucune demande trouvée.</p>
            @else
                <table>
    <thead>
        <tr>
            <th>Description</th>
            <th>Date Résultat</th>
            <th>Prix</th>
            <th>Statut</th>
            @if (isset($isAdmin) && $isAdmin && $viewAll)
                <th>Actions</th>
            @else
                <th>Chatbox</th>
            @endif
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
