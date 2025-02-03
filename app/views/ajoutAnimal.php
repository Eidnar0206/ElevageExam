<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal</title>
</head>
<body>
    <h2>Ajouter un Animal</h2>
    <form action="ajoutAnimal" method="POST" enctype="multipart/form-data">
        <label for="idEspece">Espèce:</label>
        <select name="idEspece" id="idEspece" required>
            <option value="">Sélectionner une espèce</option>
            <?php foreach ($especes as $espece): ?>
                <option value="<?= htmlspecialchars($espece['idEspece']) ?>">
                    <?= htmlspecialchars($espece['nomEspece']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="prixAchat">Prix d'Achat (€):</label>
        <input type="number" name="prixAchat" id="prixAchat" required><br>

        <label for="poidsInitial">Poids Initial (kg):</label>
        <input type="number" step="0.01" name="poidsInitial" id="poidsInitial" required><br>

        <label for="dateAchat">Date d'Achat:</label>
        <input type="date" name="dateAchat" id="dateAchat" required><br>

        <label for="photos">Photos:</label>
        <input type="file" name="photos[]" id="photos" multiple accept="image/*"><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
