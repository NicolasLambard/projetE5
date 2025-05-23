@extends('layouts.main')

@section('title', 'ShadyCorp')

@section('styles')
/* Couleurs d'origine restaurées */
.hero {
    background-color: #3498db;
}

.btn-contact {
    background-color: #3498db;
}

.btn-back {
    background-color: #e74c3c;
}

/* Main Content */
main {
    flex: 1;
}

/* Services specific styles */
.hero {
    background-color: #3498db;
    color: white;
    text-align: center;
    padding: 3rem 0;
}

.hero h1 {
    margin-bottom: 1rem;
    font-size: 2.5rem;
}

.services {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 1rem;
}

.services h2 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 2rem;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.service-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    height: 300px;
    perspective: 1000px;
}

.card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s;
    transform-style: preserve-3d;
}

.card-inner.flipped {
    transform: rotateY(180deg);
}

.card-front, .card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1.5rem;
}

.card-back {
    transform: rotateY(180deg);
    background-color: #f8f9fa;
}

.service-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.service-card h3 {
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.service-card ul {
    list-style-position: inside;
    text-align: left;
    margin-bottom: 1.5rem;
}

.service-card li {
    margin-bottom: 0.5rem;
}

.btn-contact, .btn-back {
    border: none;
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-weight: bold;
}

.btn-contact:hover {
    background-color: #2980b9;
}

.btn-back:hover {
    background-color: #c0392b;
}

.cta-section {
    background-color: #f8f9fa;
    padding: 3rem 1rem;
    text-align: center;
}

.cta-container {
    max-width: 800px;
    margin: 0 auto;
}

.cta-section h2 {
    margin-bottom: 1.5rem;
}

.cta-section p {
    margin-bottom: 2rem;
    line-height: 1.6;
}

.btn-demande {
    display: inline-block;
    background-color: #3498db;
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-demande:hover {
    background-color: #2980b9;
}
@endsection

@section('content')
<section class="hero">
    <h1>Solutions de Développement Sur Mesure</h1>
    <p>Expertise en développement FiveM et création d'environnements personnalisés</p>
</section>

<section id="services" class="services">
    <h2>Nos Services</h2>
    <div class="services-grid">

        <div class="service-card">
            <div class="card-inner">
                <div class="card-front">
                    <div class="service-icon">🔧</div>
                    <h3>Création d'Environnement Sur Mesure</h3>
                    <ul>
                        <li>Base de données optimisée</li>
                        <li>Panel administrateur</li>
                        <li>Base de jeu personnalisée</li>
                    </ul>
                    <button class="btn-contact" onclick="flipCard(this)">En savoir plus</button>
                </div>
                <div class="card-back">
                    <h3>Plus d'informations</h3>
                    <p>Nous créons des environnements uniques adaptés à vos projets FiveM.</p>
                    <button class="btn-back" onclick="flipCard(this)">Retour</button>
                </div>
            </div>
        </div>

        <div class="service-card">
            <div class="card-inner">
                <div class="card-front">
                    <div class="service-icon">🔍</div>
                    <h3>Débogage de Script</h3>
                    <ul>
                        <li>Analyse approfondie</li>
                        <li>Correction des erreurs</li>
                        <li>Optimisation des performances</li>
                    </ul>
                    <button class="btn-contact" onclick="flipCard(this)">En savoir plus</button>
                </div>
                <div class="card-back">
                    <h3>Plus d'informations</h3>
                    <p>Nous corrigeons les erreurs et optimisons vos scripts pour de meilleures performances.</p>
                    <button class="btn-back" onclick="flipCard(this)">Retour</button>
                </div>
            </div>
        </div>

        <div class="service-card">
            <div class="card-inner">
                <div class="card-front">
                    <div class="service-icon">⚙️</div>
                    <h3>Développement Sur Mesure</h3>
                    <ul>
                        <li>Scripts personnalisés</li>
                        <li>Framework ESX-Legacy</li>
                        <li>Solutions adaptées à vos besoins</li>
                    </ul>
                    <button class="btn-contact" onclick="flipCard(this)">En savoir plus</button>
                </div>
                <div class="card-back">
                    <h3>Plus d'informations</h3>
                    <p>Nous créons des solutions adaptées à vos besoins pour un maximum d'efficacité.</p>
                    <button class="btn-back" onclick="flipCard(this)">Retour</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-container">
        <h2>Besoin d'un Service Personnalisé ?</h2>
        <p>Contactez-nous dès aujourd'hui pour discuter de votre projet et obtenir une consultation gratuite.</p>
        <a href="{{ url('/demande') }}" class="btn-demande">Faire une Demande</a>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function flipCard(button) {
        const card = button.closest('.card-inner');
        card.classList.toggle('flipped');
    }
</script>
@endsection
