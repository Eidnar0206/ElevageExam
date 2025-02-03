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
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">Ajout</a>
                    <div class="dropdown-menu">
                        <a href="ajoutAnimal">Ajout Animal</a>
                        <a href="ajoutEspece">Ajout Espece</a>
                        <a href="ajoutAlimentation">Ajout Alimentation</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle">Liste</a>
                    <div class="dropdown-menu">
                        <a href="listEspece">Liste des Especes</a>
                    </div>
                </div>
                <a href="#">Inventaire</a>
                <a href="#">Rapports</a>
            </div>
        </div>
    </nav>
        <?php
            if(isset(($page))) {
                include($page.'.php'); 
            }
        ?>
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