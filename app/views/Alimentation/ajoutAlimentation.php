<main>
    <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Ajouter une alimentation</h1>
    <form action="ajoutAlimentation" method="post" class="form-container">
        <div class="form-group">
            <label for="nom" class="form-label">Nom : </label>
            <input type="text" name="nom" id="nom" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="espece" class="form-label">Espece : </label>
            <select name="idEspece" id="espece" class="form-input" required>
                <option></option>
                <?php foreach($Especes as $esp) { ?>
                    <option value="<?php echo $esp['idEspece'] ;?>"><?php echo $esp['nomEspece'];?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="gainPoids" class="form-label">Pourcentage de gain de poids pour cette alimentation : </label>
            <input type="text" name="gainPoids" id="gainPoids">
        </div>

        <div class="form-actions">
            <button type="submit" class="form-button">Ajouter</button>
            <button type="reset" class="form-button form-button-secondary">Réinitialiser</button>
        </div>
        
    </form>
</main>