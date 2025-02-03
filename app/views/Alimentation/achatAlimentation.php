<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat Alimentation</title>
</head>
<body>
    <form action="achatAlimentation" method="post">
        <p> Alimentation : </p>
        <select name="idAlimentation">
            <option></option>
            <?php foreach($alimentations as $al) { ?>
                <option value="<?php echo $al['idAlimentation'] ;?>"><?php echo $al['nomAlimentation'];?></option>
            <?php } ?>
        </select>

        <p>Quantite </p>
        <input type="number" name="quantite">

        <p> Prix total </p>
        <input type="number" name="prixTotal">

        <p> DateAchat : </p>
        <input type="date" name="dateAchat">

        <input type="submit" value="Valider">
    </form>
</body>
</html>