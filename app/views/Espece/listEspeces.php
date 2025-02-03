<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Especes</title>
</head>
<body>
    <table width=1200 border=1>
        <tr>
            <th>Nom de l'espece</th>
            <th>Poids minimal de vente</th>
            <th>Poids maximale</th>
            <th>Prix de vente au Kg</th>
            <th>Le nombre de jour sans manger avant de mourir</th>
            <th>% de perte de poids par jour sans manger</th>
            <th>Quantite de nourriture a consommer par jour</th>
        </tr>
        <?php foreach($especes as $e) { ?>
            <tr data-id="<?= $e['idEspece'] ?>">
                <td contenteditable="true"><?= $e['nomEspece'] ?></td>
                <td contenteditable="true"><?= $e['poidsMin'] ?></td>
                <td contenteditable="true"><?= $e['poidsMax'] ?></td>
                <td contenteditable="true"><?= $e['prixVenteKg'] ?></td>
                <td contenteditable="true"><?= $e['joursSansManger'] ?></td>
                <td contenteditable="true"><?= $e['pertePoidsJour'] ?></td>
                <td contenteditable="true"><?= $e['quantiteNourritureJour'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <button id="saveButton">Valider</button>

    <script src="public/js/script.js"></script>

</body>
</html>