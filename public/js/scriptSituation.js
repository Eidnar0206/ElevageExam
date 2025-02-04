document.addEventListener("DOMContentLoaded", function () {
    const button = document.querySelector("button");
    const dateInput = document.querySelector("input[name='dateSituation']");
    const resultatDiv = document.getElementById("resultat");

    button.addEventListener("click", function () {
        const date = dateInput.value;

        if (!date) {
            resultatDiv.innerHTML = "<p style='color: red;'>Veuillez entrer une date.</p>";
            return;
        }

        fetch("animaux-valides?date=" + date)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    resultatDiv.innerHTML = "<p style='color: red;'>" + data.error + "</p>";
                    return;
                }

                if (data.length === 0) {
                    resultatDiv.innerHTML = "<p>Aucun animal valide à cette date.</p>";
                } else {
                    let html = "<ul>";
                    data.forEach(animal => {
                        html += `<li>
                                    <img src="${animal.image}" alt="Image de l'animal" class="animal-img">
                                    ${animal.espece} (ID: ${animal.idAnimal})
                                </li>`;
                    });
                    html += "</ul>";
                    resultatDiv.innerHTML = html;
                }
            })
            .catch(error => {
                console.error("Erreur:", error);
                resultatDiv.innerHTML = "<p style='color: red;'>Erreur lors du chargement des animaux.</p>";
            });
    });
});
