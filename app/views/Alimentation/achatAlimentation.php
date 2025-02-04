<main>
    <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Achat d'alimentation</h1>

    <?php if(isset($insuf)) { ?>
        <p style="color: red"> Le solde actuel est insuffisant pour effectuer l'achat </p>
    <?php } ?>

    <form action="achatAlimentation" method="post" class="form-container">
        <div class="form-group">
            <label for="idAlimentation" class="form-label">Alimentation: </label>
            <select name="idAlimentation" id="idAlimentation" class="form-input" required>
                <option></option>
                <?php foreach($alimentations as $al) { ?>
                    <option value="<?php echo $al['idAlimentation'] ;?>"><?php echo $al['nomAlimentation'];?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantite" class="form-label">Quantite: </label>
            <input type="number" name="quantite" id="quantite" required>
        </div>

        <div class="form-group">
            <label for="prixTotal" class="form-label">Prix total: </label>
            <input type="number" name="prixTotal" id="prixTotal" required>
        </div>

        <div class="form-group">
            <label for="dateAchat" class="form-label">Prix total: </label>
            <input type="date" name="dateAchat" id="dateAchat" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="form-button">Valider</button>
            <button type="reset" class="form-button form-button-secondary">R&eacute;initialiser</button>
        </div>
    </form>
</main>