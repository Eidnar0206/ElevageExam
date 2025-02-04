<main>
    <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Liste des Espèces</h1>
    <div class="table-container">
        <table class="styled-table">
            <form action="goVenteAnimaux" method="post">
            <label for="dateVente">Date de vente :</label>
            <input type="date" id="dateVente" name="dateVente">
            <thead>
                <tr>
                    <th>Espece</th>
                    <th>#</th>
                    <th>Prix de vente par Kg</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($animals as $a) { ?>
                    <tr>
                        <td><?= $a['nomEspece'] ?></td>
                        <td><?= $a['idAnimal'] ?></td>
                        <td><?= $a['prixVenteKg'] ?></td>
                        <td>
                            <input type="hidden" name="idAnimal" value="<?= $a['idAnimal'] ?>">
                            <button type="submit" class="form-button">Acheter</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>
</main>