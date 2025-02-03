<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Espece</title>
</head>
<body>
    <form action="ajoutEspece" method="post">
        <input type="text" name="nomEspece" placeholder="Nom de l'espece"> <br>
        <input type="number" name="poidsMin" placeholder="Poids minimal de vente"> <br>
        <input type="number" name="poidsMax" placeholder="Poids maximale"> <br>
        <input type="number" name="prixVenteKg" placeholder="Prix de vente au Kg"> <br>
        <input type="number" name="nbJour" placeholder="Le nombre de jour sans manger avant de mourir"> <br>
        <input type="number" name="pertePoids" placeholder=" % de perte de poids par jour sans manger"> <br>
        <input type="number" name="qte" placeholder="Quantite de nourriture a consommer par jour"> <br>
        <button type="submit">Ajouter</button>
    </form>
    <a href="listEspece">Liste</a>
</body>
</html>