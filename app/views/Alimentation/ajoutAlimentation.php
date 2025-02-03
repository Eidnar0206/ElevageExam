<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Alimentation</title>
</head>
<body>
    <form action="ajoutAlimentation" method="post">
        <p> Nom : </p>
        <input type="text" name="nom">
        <p> Espece : </p>
        <select name="idEspece">
            <option></option>
            <?php foreach($Especes as $esp) { ?>
                <option value="<?php echo $esp['idEspece'] ;?>"><?php echo $esp['nomEspece'];?></option>
            <?php } ?>
        </select>
        <p> Pourcentage de gain de poids pour cette alimentation : </p>
        <input type="text" name="gainPoids">

        <input type="submit" value="Valider">
    </form>
</body>
</html>