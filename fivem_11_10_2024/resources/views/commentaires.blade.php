<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires Clients - ShadyCorp</title>
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
            height: 60px; /* Hauteur fixe pour la navbar */
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
            height: 100%; /* Prend toute la hauteur de la navbar */
        }
        
        nav ul li {
            margin-left: 20px;
            display: flex;
            align-items: center; /* Centre verticalement */
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
        
        .commentaires-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            padding: 1rem;
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
        
        .commentaire-meta {
            font-size: 0.9rem;
            color: #666;
        }
        
        .commentaire-meta a {
            color: #3498db;
            text-decoration: none;
        }
        
        .commentaire-meta a:hover {
            text-decoration: underline;
        }
        
        .commentaire-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-action {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .btn-valider {
            background-color: #4CAF50;
        }
        
        .btn-valider:hover {
            background-color: #388E3C;
        }
        
        .btn-supprimer {
            background-color: #f44336;
        }
        
        .btn-supprimer:hover {
            background-color: #d32f2f;
        }
        
        .empty-message {
            padding: 2rem;
            text-align: center;
            color: #666;
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
        <h1>Commentaires Clients</h1>
        <p>Découvrez les avis et commentaires de nos clients sur nos services.</p>
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
        
        <section class="commentaires-section">
            <h2>Tous les commentaires</h2>
            
            @php
                $isAdmin = auth()->user()->role->id_role === 1 || auth()->user()->role->id_role === 2;
                
                if (!$isAdmin) {
                    $mesCommentairesEnAttente = App\Models\Commentaire::where('id', auth()->id())
                        ->where('valide', 0)
                        ->with(['demande'])
                        ->get();
                }
            @endphp
            
            @if($isAdmin && isset($nbCommentairesNonValides) && $nbCommentairesNonValides > 0)
                <div class="alert alert-warning" style="margin-bottom: 20px;">
                    <h3>Commentaires en attente de validation</h3>
                    <p>Il y a actuellement <strong>{{ $nbCommentairesNonValides }}</strong> commentaire(s) en attente de validation.</p>
                </div>
            @endif
            
            @if(!$isAdmin && isset($mesCommentairesEnAttente) && $mesCommentairesEnAttente->isNotEmpty())
                <div class="alert alert-info" style="margin-bottom: 20px;">
                    <h3>Vos commentaires en attente de validation</h3>
                    <p>Ces commentaires ne sont visibles que par vous et les administrateurs jusqu'à leur validation.</p>
                    
                    @foreach($mesCommentairesEnAttente as $commentaire)
                        <div class="commentaire commentaire-en-attente">
                            <div class="commentaire-header">
                                <strong>{{ auth()->user()->name }} (Vous)</strong>
                                <small>{{ $commentaire->date }}</small>
                            </div>
                            <p>{!! nl2br(e($commentaire->description)) !!}</p>
                            <div class="commentaire-meta">
                                <p>Ticket: <a href="{{ route('ticket.details', $commentaire->id_demande) }}">{{ $commentaire->demande->description_demande }}</a></p>
                                <p><em>En attente de validation</em></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            @if($commentaires->isEmpty())
                <p class="empty-message">Aucun commentaire validé pour le moment.</p>
            @else
                @foreach($commentaires as $commentaire)
                    <div class="commentaire {{ $commentaire->valide ? '' : 'commentaire-en-attente' }}">
                        <div class="commentaire-header">
                            <strong>{{ $commentaire->user->name }}</strong>
                            <small>{{ $commentaire->date }}</small>
                        </div>
                        <p>{!! nl2br(e($commentaire->description)) !!}</p>
                        <div class="commentaire-meta">
                            <p>Ticket: <a href="{{ route('ticket.details', $commentaire->id_demande) }}">{{ $commentaire->demande->description_demande }}</a></p>
                        </div>
                        
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
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html> 