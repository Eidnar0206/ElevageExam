<main>
    <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Ajouter une alimentation</h1>
    <form action="goAlimentation" method="post" class="form-container">
        <div class="form-group">
            <label for="nom" class="form-label">date : </label>
            <input type="date" name="date" id="nom" class="form-input" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="form-button">Ajouter</button>
            <button type="reset" class="form-button form-button-secondary">Réinitialiser</button>
        </div>
    </form>

    <?php if(isset($data)): ?>
        <div style="margin-top: 2rem;">
            <h2 style="color: var(--text-primary); font-size: 1.5rem; margin-bottom: 1rem;">État des stocks</h2>
            <div style="display: grid; gap: 2rem;">
                <!-- Stock Section -->
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="color: var(--text-primary); font-size: 1.2rem; margin-bottom: 1rem;">Stocks par espèce</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">ID Espèce</th>
                                <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: right;">Quantité en stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['stock'] as $especeId => $quantity): ?>
                            <tr>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6;"><?= htmlspecialchars($especeId) ?></td>
                                <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: right;"><?= number_format($quantity, 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Animals Section -->
                <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h3 style="color: var(--text-primary); font-size: 1.2rem; margin-bottom: 1rem;">État des animaux par espèce</h3>
                    <?php foreach ($data['animals'] as $especeId => $animals): ?>
                        <div style="margin-bottom: 1.5rem;">
                            <h4 style="color: var(--text-primary); font-size: 1.1rem; margin-bottom: 0.5rem;">Espèce <?= htmlspecialchars($especeId) ?></h4>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f8f9fa;">
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">ID Animal</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">ID Espece</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">Prix Achat</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">Poids Initial</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">Date Achat</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">Quantité Nourriture/Jour</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: left;">Jours Sans Manger</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: right;">Jours sans nourriture</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: right;">Can Be Sold</th>
                                        <th style="padding: 0.75rem; border-bottom: 2px solid #dee2e6; text-align: right;">Poids Actuel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($animals as $animal): ?>
                                    <?php
                                        // Handle both data structures
                                        $animalId = isset($animal['idAnimal']) ? $animal['idAnimal'] : (isset($animal['details']['idAnimal']) ? $animal['details']['idAnimal'] : '');
                                        $idEspece = isset($animal['idEspece']) ? $animal['idEspece'] : (isset($animal['details']['idEspece']) ? $animal['details']['idEspece'] : '');
                                        $prixAchat = isset($animal['prixAchat']) ? $animal['prixAchat'] : (isset($animal['details']['prixAchat']) ? $animal['details']['prixAchat'] : '');
                                        $poidsInitial = isset($animal['poidsInitial']) ? $animal['poidsInitial'] : (isset($animal['details']['poidsInitial']) ? $animal['details']['poidsInitial'] : '');
                                        $dateAchat = isset($animal['dateAchat']) ? $animal['dateAchat'] : (isset($animal['details']['dateAchat']) ? $animal['details']['dateAchat'] : '');
                                        $quantiteNourritureJour = isset($animal['quantiteNourritureJour']) ? $animal['quantiteNourritureJour'] : (isset($animal['details']['quantiteNourritureJour']) ? $animal['details']['quantiteNourritureJour'] : '');
                                        $joursSansManger = isset($animal['joursSansManger']) ? $animal['joursSansManger'] : (isset($animal['details']['joursSansManger']) ? $animal['details']['joursSansManger'] : '');
                                        $daysWithoutFood = isset($animal['daysWithoutFood']) ? $animal['daysWithoutFood'] : 0;
                                        $canBeSold = isset($animal['canBeSold']) ? $animal['canBeSold'] : false;
                                        $poidsActuel = isset($animal['poidsActuel']) ? $animal['poidsActuel'] : $poidsInitial;
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($animalId) ?></td>
                                        <td><?= htmlspecialchars($idEspece) ?></td>
                                        <td><?= htmlspecialchars($prixAchat) ?></td>
                                        <td><?= htmlspecialchars($poidsInitial) ?></td>
                                        <td><?= htmlspecialchars($dateAchat) ?></td>
                                        <td><?= htmlspecialchars($quantiteNourritureJour) ?></td>
                                        <td><?= htmlspecialchars($joursSansManger) ?></td>
                                        <td style="color: <?= $daysWithoutFood > 0 ? '#dc3545' : '#28a745' ?>;">
                                            <?= $daysWithoutFood ?>
                                        </td>
                                        <td><?= $canBeSold ? 'Yes' : 'No' ?></td>
                                        <td><?= htmlspecialchars($poidsActuel) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>