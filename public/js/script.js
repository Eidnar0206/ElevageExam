document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const saveButton = document.getElementById("saveButton");
    let modifiedRows = new Set(); // Pour tracker les lignes modifiées

    // Au lieu d'envoyer à chaque modification, on garde trace des lignes modifiées
    table.addEventListener("input", function (event) {
        const row = event.target.closest("tr");
        modifiedRows.add(row);
    });

    // Envoie les données quand on clique sur le bouton
    saveButton.addEventListener("click", function() {
        const updatedDataArray = [];

        // Collecte les données de toutes les lignes modifiées
        modifiedRows.forEach(row => {
            const updatedData = {
                idEspece: row.getAttribute("data-id"),
                nomEspece: row.cells[0].innerText.trim(),
                poidsMin: row.cells[1].innerText.trim(),
                poidsMax: row.cells[2].innerText.trim(),
                prixVenteKg: row.cells[3].innerText.trim(),
                joursSansManger: row.cells[4].innerText.trim(),
                pertePoidsJour: row.cells[5].innerText.trim(),
                quantiteNourritureJour: row.cells[6].innerText.trim()
            };
            updatedDataArray.push(updatedData);
        });

        // S'il y a des modifications à envoyer
        if (updatedDataArray.length > 0) {
            fetch("especes/update", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(updatedDataArray)
            })
            .then(response => response.json())
            .then(data => {
                console.log("Réponse du serveur :", data);
                alert("Mise à jour réussie !");
                modifiedRows.clear(); // Réinitialise la liste des modifications
            })
            .catch(error => {
                console.error("Erreur :", error);
                alert("Échec de la mise à jour !");
            });
        } else {
            alert("Aucune modification à enregistrer");
        }
    });
});