<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Ticket #{{ $demande->id_demande }} - ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/ticket.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: #333;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 60px;
        }
        
        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        nav ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
            height: 100%;
        }
        
        nav ul li {
            margin-left: 20px;
            display: flex;
            align-items: center;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        nav ul li a:hover {
            color: #3498db;
        }
        
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        .ticket-details {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .ticket-info {
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }
        
        .ticket-info h2 {
            color: #333;
            margin-top: 0;
        }
        
        .confirmation-commande {
            margin-top: 20px;
            padding: 20px;
            background-color: #e8f5e9;
            border-radius: 8px;
            border: 1px solid #c8e6c9;
        }
        
        .btn-confirmer {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .btn-confirmer:hover {
            background-color: #388E3C;
        }
        
        .commentaires-section {
            margin-top: 20px;
            padding: 2rem;
            background-color: #fff;
            border-radius: 0;
            border-bottom: 1px solid #eee;
        }
        
        .commentaire {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        .commentaire-en-attente {
            border-left: 4px solid #ff9800;
            background-color: #fff8e1;
        }
        
        .commentaire-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .commentaire-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .commentaire-form {
            margin-top: 20px;
            padding: 2rem;
            background-color: #fff;
        }
        
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            resize: vertical;
        }
        
        .btn-commentaire {
            background-color: #2196F3;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .btn-commentaire:hover {
            background-color: #1976D2;
        }
        
        .btn-valider {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-supprimer {
            background-color: #f44336;
            color: white;
        }
        
        .actions {
            padding: 2rem;
            display: flex;
            gap: 15px;
        }
        
        .btn-action {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        
        .btn-chatbox {
            background-color: #9c27b0;
        }
        
        .btn-chatbox:hover {
            background-color: #7b1fa2;
        }
        
        .btn-retour {
            background-color: #607D8B;
        }
        
        .btn-retour:hover {
            background-color: #455A64;
        }
        
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 2rem;
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
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <h1>Détails du Ticket #{{ $demande->id_demande }}</h1>
        <p>{{ $demande->description_demande }}</p>
    </section>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        
        <section class="ticket-details">
            <div class="ticket-info">
                <h2>Informations du ticket</h2>
                <p><strong>Description:</strong> {{ $demande->description_demande }}</p>
                <p><strong>Date de la commande:</strong> {{ $demande->date_commande }}</p>
                <p><strong>Description du résultat:</strong> {{ $demande->description_resultat }}</p>
                <p><strong>Date de résultat attendue:</strong> {{ $demande->date_resultat }}</p>
                <p><strong>Prix:</strong> {{ $demande->prix }} €</p>
                <p><strong>Statut:</strong> {{ $demande->statut->label }}</p>
                <p><strong>Client:</strong> {{ $demande->user->name }}</p>
            </div>

            @if(auth()->user()->id === $demande->id && $demande->id_status === 1)
            <div class="confirmation-commande">
                <h3>Confirmation de commande</h3>
                <p>En confirmant cette commande, vous acceptez les termes et conditions associés au service demandé.</p>
                <form action="{{ route('ticket.accepter', $demande->id_demande) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="commentaire"><strong>Ajoutez un commentaire sur cette commande (optionnel) :</strong></label>
                        <p><em>Ce commentaire sera visible sur votre historique de tickets après validation par un administrateur.</em></p>
                        <textarea name="commentaire" id="commentaire" rows="3" placeholder="Partagez votre avis sur cette commande, la qualité du service, etc..."></textarea>
                    </div>
                    <button type="submit" class="btn-confirmer">Confirmer la commande</button>
                </form>
            </div>
            @endif

            <div class="commentaires-section">
                <h3>Commentaires</h3>
                
                @php
                    $isAdmin = auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2;
                    $commentaires = $isAdmin ? $demande->commentaires : $demande->commentaires->where('valide', 1);
                    
                    $aDejaCommente = $demande->commentaires->where('id', auth()->id())->isNotEmpty();
                    
                    $monCommentaireEnAttente = null;
                    if (!$isAdmin && $aDejaCommente) {
                        $monCommentaireEnAttente = $demande->commentaires->where('id', auth()->id())->where('valide', 0)->first();
                    }
                    
                    $commentaireAdmin = null;
                    if ($isAdmin) {
                        $commentaireAdmin = $demande->commentaires->where('id', auth()->id())->first();
                    }
                @endphp
                
                @if($monCommentaireEnAttente)
                    <div class="alert alert-info">
                        <p><strong>Information :</strong> Votre commentaire est en attente de validation par un administrateur.</p>
                    </div>
                @endif
                
                @if($commentaires->isEmpty() && !$monCommentaireEnAttente)
                    <p>Aucun commentaire pour le moment.</p>
                @else
                    @foreach($commentaires as $commentaire)
                        <div class="commentaire {{ $commentaire->valide ? '' : 'commentaire-en-attente' }}">
                            <div class="commentaire-header">
                                <strong>{{ $commentaire->user->name }}</strong>
                                <small>{{ $commentaire->date }}</small>
                            </div>
                            <p>{!! nl2br(e($commentaire->description)) !!}</p>
                            
                            @peutValiderCommentaire
                                <div class="commentaire-actions">
                                    @if(!$commentaire->valide)
                                    <form action="{{ route('commentaire.valider', $commentaire->id_commentaire) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-valider">Valider</button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('commentaire.supprimer', $commentaire->id_commentaire) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">Supprimer</button>
                                    </form>
                                </div>
                            @endpeutValiderCommentaire
                        </div>
                    @endforeach
                @endif
                
                @if(!$isAdmin && $monCommentaireEnAttente)
                <div class="commentaire-form">
                    <h3>Votre commentaire</h3>
                    <div class="commentaire commentaire-en-attente">
                        <div class="commentaire-header">
                            <strong>{{ auth()->user()->name }} (Vous)</strong>
                            <small>{{ $monCommentaireEnAttente->date }}</small>
                        </div>
                        <p>{!! nl2br(e($monCommentaireEnAttente->description)) !!}</p>
                        <p><em>Ce commentaire est en attente de validation par un administrateur et n'est pas encore visible publiquement.</em></p>
                    </div>
                </div>
                @endif
                
                @peutValiderCommentaire
                <div class="commentaire-form" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                    <h3>{{ $commentaireAdmin ? 'Modifier votre commentaire administrateur' : 'Ajouter un commentaire administrateur' }}</h3>
                    <form action="{{ route('ticket.commentaire.admin', $demande->id_demande) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="commentaire">Commentaire administrateur:</label>
                            <textarea name="commentaire" id="commentaire" rows="3" placeholder="Ajoutez un commentaire administrateur..." required>{{ $commentaireAdmin ? $commentaireAdmin->description : '' }}</textarea>
                        </div>
                        <button type="submit" class="btn-commentaire">{{ $commentaireAdmin ? 'Mettre à jour' : 'Ajouter' }} le commentaire</button>
                    </form>
                </div>
                @endpeutValiderCommentaire
            </div>

            <div class="actions">
                <a href="{{ route('chatbox', $demande->id_demande) }}" class="btn-action btn-chatbox">Ouvrir la chatbox</a>
                <a href="{{ route('ticket') }}" class="btn-action btn-retour">Retour à la liste des tickets</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html> 