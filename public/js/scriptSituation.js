document.addEventListener("DOMContentLoaded", function () {
    // Sélection des éléments avec vérification
    const form = document.getElementById("animalForm");
    const dateInput = document.querySelector("input[name='dateSituation']");
    const resultatDiv = document.getElementById("resultat");

    // Vérification des sélecteurs
    console.log("Form trouvé:", form);
    console.log("Input date trouvé:", dateInput);
    console.log("Div résultat trouvée:", resultatDiv);

    // Gestionnaire d'événement sur le formulaire
    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Empêche le rechargement de la page
        console.log("Formulaire soumis");

        const date = dateInput.value;
        console.log("Date sélectionnée:", date);

        // Vérification de la date
        if (!date) {
            resultatDiv.innerHTML = "<p class='error-message'>Veuillez entrer une date.</p>";
            return;
        }

        // Affichage d'un message de chargement
        resultatDiv.innerHTML = "<p>Chargement en cours...</p>";

        // Requête vers le serveur avec logging
        fetch("animaux-valides?dateSituation=" + encodeURIComponent(date))
            .then(response => {
                console.log("Status de la réponse:", response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Données reçues:", data);
                
                if (data.error) {
                    resultatDiv.innerHTML = `<p class='error-message'>${data.error}</p>`;
                    return;
                }

                if (data.length === 0) {
                    resultatDiv.innerHTML = "<p>Aucun animal valide à cette date.</p>";
                    return;
                }

                // Construction de la liste des animaux
                let html = "<ul>";
                data.forEach(animal => {
                    console.log("Traitement animal:", animal);
                    html += `
                        <li>
                            <img src="${animal.image}" 
                                 alt="Image de ${animal.espece}" 
                                 class="animal-img"
                                 onerror="this.src='placeholder.jpg'">
                            <div>
                                <strong>${animal.espece}</strong>
                                <br>
                                ID: ${animal.idAnimal}
                            </div>
                        </li>`;
                });
                html += "</ul>";
                resultatDiv.innerHTML = html;
            })
            .catch(error => {
                console.error("Erreur détaillée:", error);
                resultatDiv.innerHTML = `
                    <p class='error-message'>
                        Erreur lors du chargement des animaux: ${error.message}
                    </p>`;
            });
    });
});