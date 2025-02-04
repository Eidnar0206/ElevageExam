CREATE DATABASE IF NOT EXISTS elevage;
USE elevage;

-- Table pour stocker le capital initial
CREATE TABLE IF NOT EXISTS elevage_capital (
    idElevage INT PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    dateDebut DATE NOT NULL DEFAULT '2025-02-03'
);

-- Table pour gérer le capital (entrées et sorties d'argent)
CREATE TABLE IF NOT EXISTS elevage_capitalTransactions (
    idTransaction INT PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    typeTransaction ENUM('entree', 'sortie') NOT NULL, -- 'entrée' pour l'ajout d'argent, 'sortie' pour le retrait d'argent
    description VARCHAR(255),
    dateTransaction DATE NOT NULL DEFAULT '2025-02-03'
);

-- Table des animaux
CREATE TABLE IF NOT EXISTS elevage_espece (
    idEspece INT PRIMARY KEY AUTO_INCREMENT,
    nomEspece VARCHAR(50) NOT NULL,
    poidsMin DECIMAL(5,2) NOT NULL,
    poidsMax DECIMAL(5,2) NOT NULL,
    prixVenteKg DECIMAL(5,2) NOT NULL,
    joursSansManger INT NOT NULL,
    pertePoidsJour DECIMAL(4,2) NOT NULL,
    quantiteNourritureJour DECIMAL(4,2) NOT NULL,
    image VARCHAR(250)
);

-- Table pour stocker les animaux achetés
CREATE TABLE IF NOT EXISTS elevage_animaux (
    idAnimal INT PRIMARY KEY AUTO_INCREMENT,
    idEspece INT NOT NULL,
    prixAchat INT NOT NULL,
    poidsInitial DECIMAL(5,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idEspece) REFERENCES elevage_espece(idEspece) 
);

-- Table des types d’alimentation
CREATE TABLE IF NOT EXISTS elevage_alimentation (
    idAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    nomAlimentation VARCHAR(50) NOT NULL,
    idEspece INT NOT NULL,
    gainPoids DECIMAL(4,2) NOT NULL, -- Pourcentage de gain de poids
    FOREIGN KEY (idEspece) REFERENCES elevage_espece(idEspece) 
);

-- Table pour enregistrer les achats d’alimentation
CREATE TABLE IF NOT EXISTS elevage_achatAlimentation (
    idAchatAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    idAlimentation INT NOT NULL,
    quantite DECIMAL(4,2) NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idAlimentation) REFERENCES elevage_alimentation(idAlimentation) 
);

-- Table pour enregistrer l'alimentation donnée aux animaux
/*CREATE TABLE IF NOT EXISTS elevage_alimentationAnimaux (
    idAlimentationAnimal INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    idAlimentation INT NOT NULL,
    dateNourriture DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal),
    FOREIGN KEY (idAlimentation) REFERENCES elevage_alimentation (idAlimentation) 
);*/

-- Table des ventes d'animaux
CREATE TABLE IF NOT EXISTS elevage_Ventes (
    idVente INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsVente DECIMAL(5,2) NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateVente DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

-- Table pour stocker les morts d’animaux
CREATE TABLE IF NOT EXISTS elevage_morts (
    idMort INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    dateMort DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

--Table pour stocker les perte de poids
CREATE TABLE IF NOT EXISTS elevage_pertePoids (
    idPertePoids INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsPerte DECIMAL(5,2) NOT NULL,
    datePerte DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

--table pour stocker les gains de poids
CREATE TABLE IF NOT EXISTS elevage_gainPoids (
    idGainPoids INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsGagne DECIMAL(5,2) NOT NULL,
    dateGain DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

--table pour stocker les images des animaux
CREATE TABLE IF NOT EXISTS elevage_imagesAnimaux (
    idImage INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    nomImage VARCHAR(50) NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);
