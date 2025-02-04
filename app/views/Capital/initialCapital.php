<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Ferme - Système de Gestion d'Animaux</title>
    <link rel="stylesheet" href="public/assets/css/styles.css">
</head>
<body>
    <main>
<h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Définir le Capital Initial</h1>
<form action="ajoutCapitalInitial" method="POST" class="form-container">
    <div class="form-group">
        <label for="montant" class="form-label">Montant Initial (€)</label>
        <input type="number" id="montant" name="montant" class="form-input" placeholder="Entrez le montant initial" required>
    </div>
    <div class="form-actions">
        <button type="submit" class="form-button">Enregistrer</button>
    </div>
</form>
</main>
</body>