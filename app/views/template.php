<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Ferme - Système de Gestion d'Animaux</title>
    <link rel="stylesheet" href="public/assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-text">FermeGestion</div>
            <div class="nav-links">
                <a href="#">Tableau de Bord</a>
                <a href="#">Animaux</a>
                <a href="#">Santé</a>
                <a href="#">Inventaire</a>
                <a href="#">Rapports</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Animaux</div>
                <div class="stat-value">248</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">En Santé</div>
                <div class="stat-value">236</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">En Observation</div>
                <div class="stat-value">12</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Production Laitière</div>
                <div class="stat-value">1,850 L</div>
            </div>
        </div>

        <div class="animal-grid">
            <div class="animal-card">
                <span class="animal-status status-healthy">En Santé</span>
                <h3 class="feature-title">Vache #A123</h3>
                <p>Race: Holstein</p>
                <p>Âge: 3 ans</p>
                <p>Production: 28L/jour</p>
            </div>
            <div class="animal-card">
                <span class="animal-status status-attention">Observation</span>
                <h3 class="feature-title">Vache #A124</h3>
                <p>Race: Limousine</p>
                <p>Âge: 4 ans</p>
                <p>Dernier Contrôle: 12/02/24</p>
            </div>
            <div class="animal-card">
                <span class="animal-status status-healthy">En Santé</span>
                <h3 class="feature-title">Vache #A125</h3>
                <p>Race: Charolaise</p>
                <p>Âge: 2 ans</p>
                <p>Production: 25L/jour</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <h2 class="feature-title">Suivi Santé</h2>
                <p class="feature-text">Suivez l'état de santé de chaque animal avec des mises à jour quotidiennes et des alertes en temps réel.</p>
            </div>
            <div class="feature-card">
                <h2 class="feature-title">Gestion du Troupeau</h2>
                <p class="feature-text">Gérez efficacement votre troupeau avec des informations détaillées sur chaque animal.</p>
            </div>
            <div class="feature-card">
                <h2 class="feature-title">Production Laitière</h2>
                <p class="feature-text">Surveillez et analysez la production laitière quotidienne de votre troupeau.</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>À Propos</h3>
                <p>Solution de gestion complète pour votre ferme</p>
                <p>Version système: 2.1.4</p>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Tél: 01 23 45 67 89</p>
                <p>Email: contact@fermegestion.fr</p>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <p>Guide d'utilisation</p>
                <p>Centre d'aide</p>
            </div>
        </div>
    </footer>
</body>
</html>