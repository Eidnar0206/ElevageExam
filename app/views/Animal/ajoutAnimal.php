
<main>
    <?php if (isset($message)): ?>
    <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
        <?php endif; ?>

        <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Ajouter un Animal</h1>
        <form action="ajoutAnimal" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="idEspece" class="form-label">Espèce</label>
                <select name="idEspece" id="idEspece" class="form-input" required>
                    <option value="">Sélectionner une espèce</option>
                    <?php foreach ($especes as $espece): ?>
                        <option value="<?= htmlspecialchars($espece['idEspece']) ?>">
                            <?= htmlspecialchars($espece['nomEspece']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prixAchat" class="form-label">Prix d'Achat (€)</label>
                <input type="number" name="prixAchat" id="prixAchat" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="poidsInitial" class="form-label">Poids Initial (kg)</label>
                <input type="number" step="0.01" name="poidsInitial" id="poidsInitial" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="dateAchat" class="form-label">Date d'Achat</label>
                <input type="date" name="dateAchat" id="dateAchat" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="photos" class="form-label">Photos</label>
                <input type="file" name="photos[]" id="photos" class="form-input" multiple accept="image/*">
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <label class="form-label" style="margin-right: 10px;">AutoVente</label>
                <input type="radio" name="autoVente" id="autoVenteOui" class="form-input" value="1" checked>
                <label for="autoVenteOui">Oui</label>   
                <input type="radio" name="autoVente" id="autoVenteNon" class="form-input" value="0">
                <label for="autoVenteNon">Non</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="form-button">Ajouter</button>
                <button type="reset" class="form-button form-button-secondary">Réinitialiser</button>
            </div>
        </form>
    </main>
