<main>
        <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Ajouter une Espèce</h1>
        <form action="ajoutEspece" method="post" class="form-container">
            <div class="form-group">
                <label for="nomEspece" class="form-label">Nom de l'Espèce</label>
                <input type="text" id="nomEspece" name="nomEspece" class="form-input" placeholder="Entrez le nom de l'espèce" required>
            </div>

            <div class="form-group">
                <label for="poidsMin" class="form-label">Poids Minimal de Vente (kg)</label>
                <input type="number" id="poidsMin" name="poidsMin" class="form-input" placeholder="Entrez le poids minimal" required>
            </div>

            <div class="form-group">
                <label for="poidsMax" class="form-label">Poids Maximal (kg)</label>
                <input type="number" id="poidsMax" name="poidsMax" class="form-input" placeholder="Entrez le poids maximal" required>
            </div>

            <div class="form-group">
                <label for="prixVenteKg" class="form-label">Prix de Vente au Kg (€)</label>
                <input type="number" id="prixVenteKg" name="prixVenteKg" class="form-input" placeholder="Entrez le prix de vente au kg" required>
            </div>

            <div class="form-group">
                <label for="nbJour" class="form-label">Nombre de Jours Sans Manger</label>
                <input type="number" id="nbJour" name="nbJour" class="form-input" placeholder="Entrez le nombre de jours sans manger" required>
            </div>

            <div class="form-group">
                <label for="pertePoids" class="form-label">Perte de Poids par Jour (%)</label>
                <input type="number" id="pertePoids" name="pertePoids" class="form-input" placeholder="Entrez le pourcentage de perte de poids" required>
            </div>

            <div class="form-group">
                <label for="qte" class="form-label">Quantité de Nourriture par Jour (kg)</label>
                <input type="number" id="qte" name="qte" class="form-input" placeholder="Entrez la quantité de nourriture par jour" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="form-button">Ajouter</button>
                <button type="reset" class="form-button form-button-secondary">Réinitialiser</button>
            </div>
        </form>
    </main>