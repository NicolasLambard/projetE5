<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire une Demande de Service - ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/demande.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShadyCorp</div>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ url('/services') }}">Service</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1>Faire une Demande de Service</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre une demande personnalisée</p>
    </section>

    <main>
        <section class="form-section">
            <h2>Formulaire de Demande de Service</h2>
            <form action="{{ url('/soumettre-demande') }}" method="POST">
                {{ csrf_field() }}
                
                <label for="description">Description du service souhaité :</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="date">Date souhaitée :</label>
                <input type="date" id="date" name="date" required>
                
                <label for="services">Sélectionnez le service :</label>
                <select id="services" name="services" required>
                    <option value="">-- Choisissez un service --</option>
                    <option value="environnement">Création d'Environnement Sur Mesure</option>
                    <option value="debugging">Débogage de Script</option>
                    <option value="custom-dev">Développement Sur Mesure</option>
                </select>
                
                <label for="tarif">Proposition de tarif (optionnel) :</label>
                <input type="number" id="tarif" name="tarif" placeholder="Tarif proposé en euros">
                
                <button type="submit">Soumettre la Demande</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
