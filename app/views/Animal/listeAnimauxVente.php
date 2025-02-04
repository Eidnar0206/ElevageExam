<form action="" method="post">
    <label for="dateVente">Date de vente :</label>
    <input type="date" id="dateVente" name="dateVente">
    <table border=700>
        <tr>
            <th>Espece</th>
            <th>#</th>
            <th>Prix de vente par Kg</th>
            <th>Action</th>
        </tr>
        <?php foreach($animals as $a) { ?>
            <tr>
                <td><?= $a['nomEspece'] ?></td>
                <td><?= $a['idAnimal'] ?></td>
                <td><?= $a['prixVenteKg'] ?></td>
                <td>
                    <input type="hidden" name="idAnimal" value="<?= $a['idAnimal'] ?>">
                    <button type="submit">Acheter</button>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>