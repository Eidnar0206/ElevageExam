<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Achat Animal</h1>
    <form action="achatAnimal" method="post">
        <select name="espece">
            <?php foreach($especes as $e) { ?>
                <option value="<?= $e['idEspece'] ?>"><?= $e['nomEspece'] ?></option>
            <?php } ?>
        </select> <br>
        <input type="number" name="prixAchat" placeholder="Prix d'achat"> <br>
        <input type="number" name="poidsInitial" placeholder="Poids Initial"> <br>
        <input type="date" name="dateAchat"> <br>
        <button type="submit">Valider</button>
    </form>
</body>
</html>