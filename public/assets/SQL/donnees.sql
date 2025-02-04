-- Insérer le capital initial
INSERT INTO elevage_capital (montant, dateDebut) VALUES (10000.00, '2025-02-03');

-- Insérer des espèces d'animaux
INSERT INTO elevage_espece (nomEspece, poidsMin, poidsMax, prixVenteKg, joursSansManger, pertePoidsJour, quantiteNourritureJour, image)
VALUES 
('Poulet', 1.00, 3.00, 5.00, 3, 0.05, 0.20, 'poulet.jpg'),
('Bœuf', 200.00, 600.00, 4.00, 5, 1.00, 5.00, 'boeuf.jpg');

-- Insérer des animaux achetés
INSERT INTO elevage_animaux (idEspece, prixAchat, poidsInitial, dateAchat)
VALUES 
(1, 10, 1.5, '2025-02-01'),
(2, 500, 250.0, '2025-02-02');

-- Insérer des types d’alimentation
INSERT INTO elevage_alimentation (nomAlimentation, idEspece, gainPoids)
VALUES 
('Grains de maïs', 1, 0.10),
('Foin', 2, 0.05);

-- Insérer un achat d’alimentation
INSERT INTO elevage_achatAlimentation (idAlimentation, quantite, prixTotal, dateAchat)
VALUES 
(1, 50, 100.00, '2025-02-02'),
(2, 100, 300.00, '2025-02-02');

-- Insérer une alimentation donnée aux animaux
INSERT INTO elevage_alimentationAnimaux (idAnimal, idAlimentation, dateNourriture)
VALUES 
(1, 1, '2025-02-03'),
(2, 2, '2025-02-03');

-- Insérer une transaction financière (entrée d'argent)
INSERT INTO elevage_capitalTransactions (montant, typeTransaction, description, dateTransaction)
VALUES (500.00, 'entree', 'Vente d’aliments', '2025-02-03');

-- Insérer une vente d’animal
INSERT INTO elevage_Ventes (idAnimal, poidsVente, prixTotal, dateVente)
VALUES 
(1, 2.5, 12.50, '2025-02-04');

-- Insérer un enregistrement de perte de poids
INSERT INTO elevage_pertePoids (idAnimal, poidsPerte, datePerte)
VALUES 
(2, 2.0, '2025-02-03');

-- Insérer un enregistrement de gain de poids
INSERT INTO elevage_gainPoids (idAnimal, poidsGagne, dateGain)
VALUES 
(1, 0.3, '2025-02-03');

-- Insérer des images d’animaux
INSERT INTO elevage_imagesAnimaux (idAnimal, nomImage)
VALUES 
(1, 'poulet_01.jpg'),
(2, 'boeuf_01.jpg');

SELECT a.*, e.quantiteNourritureJour, e.joursSansManger
            FROM elevage_animaux a
            JOIN elevage_espece e ON a.idEspece = e.idEspece
            WHERE a.dateAchat = '2025-02-06';