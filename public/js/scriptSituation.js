document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("animalForm");
    const dateInput = document.querySelector("input[name='dateSituation']");
    const resultatDiv = document.getElementById("resultat");
    
    form.addEventListener("submit", async function(e) {
        e.preventDefault();
        const date = dateInput.value;
        
        if (!date) {
            resultatDiv.innerHTML = "<p class='error-message'>Veuillez entrer une date.</p>";
            return;
        }

        resultatDiv.innerHTML = "<p>Chargement en cours...</p>";
        
        try {
            const response = await fetch("animaux-valides?dateSituation=" + encodeURIComponent(date));
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
             
            if (data.length === 0) {
                resultatDiv.innerHTML = "<p>Aucun animal valide à cette date.</p>";
                return;
            }

            // Création des éléments sans les ajouter au DOM
            const container = document.createElement('div');
            container.innerHTML = `
                <ul style="list-style-type: none; padding: 0;">
                    ${data.map(animal => `
                        <li>
                            <img 
                                src="../${animal.image}"
                                alt="Image de ${animal.espece}"
                                class="animal-img lazy-load"
                                style="max-width: 100%; height: auto;"
                            >
                            <div>
                                <strong>${animal.espece}</strong>
                                <br>
                                ID: ${animal.idAnimal}
                            </div>
                        </li>
                    `).join('')}
                </ul>
            `;
            
            resultatDiv.innerHTML = '';
            resultatDiv.appendChild(container);

            // Configuration de IntersectionObserver
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src;
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px',
                threshold: 0.1
            });

            // Observation de toutes les images avec la classe lazy-load
            document.querySelectorAll('.lazy-load').forEach(img => {
                observer.observe(img);
            });

        } catch (error) {
            console.error("Erreur détaillée:", error);
            resultatDiv.innerHTML = `
                <p class='error-message'>
                    Erreur lors du chargement des animaux: ${error.message}
                </p>`;
        }
    });
});