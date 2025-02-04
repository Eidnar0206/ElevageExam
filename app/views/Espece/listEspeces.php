
<main>
        <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Liste des Espèces</h1>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Nom de l'espèce</th>
                        <th>Poids minimal de vente (kg)</th>
                        <th>Poids maximal (kg)</th>
                        <th>Prix de vente au Kg (€)</th>
                        <th>Jours sans manger</th>
                        <th>Perte de poids par jour (%)</th>
                        <th>Quantité de nourriture par jour (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($especes as $e) { ?>
                        <tr data-id="<?= $e['idEspece'] ?>">
                            <td contenteditable="true"><?= htmlspecialchars($e['nomEspece']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['poidsMin']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['poidsMax']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['prixVenteKg']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['joursSansManger']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['pertePoidsJour']) ?></td>
                            <td contenteditable="true"><?= htmlspecialchars($e['quantiteNourritureJour']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="form-actions" style="margin-top: 2rem;">
            <button id="saveButton" class="form-button">Valider</button>
        </div>
        <script src="public/js/script.js"></script>
    </main>
