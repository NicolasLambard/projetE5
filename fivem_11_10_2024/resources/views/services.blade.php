<?php
// index.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShadyCorp</title>
    <link rel="stylesheet" href="{{ asset('styles/services.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ShadyCorp</div>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li> 
                <li><a href="{{ url('/demande') }}">Demande</a></li> 
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Solutions de Développement Sur Mesure</h1>
            <p>Expertise en développement FiveM et création d'environnements personnalisés</p>
        </section>

        <section id="services" class="services">
            <h2>Nos Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🔧</div>
                    <h3>Création d'Environnement Sur Mesure</h3>
                    <ul>
                        <li>Base de données optimisée</li>
                        <li>Panel administrateur</li>
                        <li>Base de jeu personnalisée</li>
                    </ul>
                    <button class="btn-contact">En savoir plus</button>
                </div>

                <div class="service-card">
                    <div class="service-icon">🔍</div>
                    <h3>Débogage de Script</h3>
                    <ul>
                        <li>Analyse approfondie</li>
                        <li>Correction des erreurs</li>
                        <li>Optimisation des performances</li>
                    </ul>
                    <button class="btn-contact">En savoir plus</button>
                </div>

                <div class="service-card">
                    <div class="service-icon">⚙️</div>
                    <h3>Développement Sur Mesure</h3>
                    <ul>
                        <li>Scripts personnalisés</li>
                        <li>Framework ESX-Legacy</li>
                        <li>Solutions adaptées à vos besoins</li>
                    </ul>
                    <button class="btn-contact">En savoir plus</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> ShadyCorp. Tous droits réservés.</p>
    </footer>
</body>
</html>
