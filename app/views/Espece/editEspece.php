<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Espèce</title>
    <script>
        function updateEspece(event) {
            event.preventDefault();
            let formData = new FormData(document.getElementById("editEspeceForm"));

            fetch('/espece/update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Mise à jour réussie !");
                window.location.href = "/especes";
            })
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</head>
<body>
    <h2>Modifier l'espèce</h2>
    <form id="editEspeceForm" onsubmit="updateEspece(event)">
        <input type="hidden" name="idEspece" value="<?= $espece['idEspece'] ?>">
        <label>Nom: <input type="text" name="nomEspece" value="<?= $espece['nomEspece'] ?>"></label><br>
        <label>Poids Min: <input type="text" name="poidsMin" value="<?= $espece['poidsMin'] ?>"></label><br>
        <label>Poids Max: <input type="text" name="poidsMax" value="<?= $espece['poidsMax'] ?>"></label><br>
        <label>Prix Vente Kg: <input type="text" name="prixVenteKg" value="<?= $espece['prixVenteKg'] ?>"></label><br>
        <label>Jours Sans Manger: <input type="text" name="joursSansManger" value="<?= $espece['joursSansManger'] ?>"></label><br>
        <label>Perte Poids Jour: <input type="text" name="pertePoidsJour" value="<?= $espece['pertePoidsJour'] ?>"></label><br>
        <label>Quantité Nourriture Jour: <input type="text" name="quantiteNourritureJour" value="<?= $espece['quantiteNourritureJour'] ?>"></label><br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>
