<main>
    <h1 style="margin-bottom: 2rem; color: var(--text-primary); font-size: 2rem;">Ajouter une alimentation</h1>
    <form action="goAlimentation" method="post" class="form-container">
        <div class="form-group">
            <label for="nom" class="form-label">date : </label>
            <input type="date" name="date" id="nom" class="form-input" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="form-button">Ajouter</button>
            <button type="reset" class="form-button form-button-secondary">R&eacute;initialiser</button>
        </div>
    </form>
</main>