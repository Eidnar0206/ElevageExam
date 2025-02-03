CREATE DATABASE IF NOT EXISTS elevage;
USE elevage;

-- Table pour stocker le capital initial
CREATE TABLE IF NOT EXISTS elevage_capital (
    idElevage INT PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    dateDebut DATE NOT NULL DEFAULT '2025-02-03'
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
    image VARCHAR(250) NOT NULL
);

-- Table pour stocker les animaux achetés
CREATE TABLE IF NOT EXISTS elevage_animaux (
    idAnimal INT PRIMARY KEY AUTO_INCREMENT,
    idEspece INT NOT NULL,
    poidsInitial DECIMAL(5,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idEspece) REFERENCES espece(idEspece) ON DELETE CASCADE
);

-- Table des types d’alimentation
CREATE TABLE IF NOT EXISTS elevage_alimentation (
    idAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    nomAlimentation VARCHAR(50) NOT NULL,
    gainPoids DECIMAL(4,2) NOT NULL -- Pourcentage de gain de poids
);

-- Table pour enregistrer les achats d’alimentation
CREATE TABLE IF NOT EXISTS elevage_achatAlimentation (
    idAchatAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    idAlimentation INT NOT NULL,
    quantite INT NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idAlimentation) REFERENCES elevage_alimentation(idAlimentation) ON DELETE CASCADE
);

-- Table pour enregistrer l'alimentation donnée aux animaux
CREATE TABLE IF NOT EXISTS elevage_alimentationAnimaux (
    idAlimentationAnimal INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    idAlimentation INT NOT NULL,
    dateNourriture DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE,
    FOREIGN KEY (idAlimentation) REFERENCES elevage_alimentation (idAlimentation) ON DELETE CASCADE
);

-- Table des ventes d'animaux
CREATE TABLE IF NOT EXISTS elevage_Ventes (
    idVente INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsVente DECIMAL(5,2) NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateVente DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE
);

-- Table pour stocker les morts d’animaux
CREATE TABLE IF NOT EXISTS elevage_morts (
    idMort INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    dateMort DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE
);

--Table pour stocker les perte de poids
CREATE TABLE IF NOT EXISTS elevage_pertePoids (
    idPertePoids INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsPerte DECIMAL(5,2) NOT NULL,
    datePerte DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE
);

--table pour stocker les gains de poids
CREATE TABLE IF NOT EXISTS elevage_gainPoids (
    idGainPoids INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsGagne DECIMAL(5,2) NOT NULL,
    dateGain DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE
);

--table pour stocker les images des animaux
CREATE TABLE IF NOT EXISTS elevage_imagesAnimaux (
    idImage INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    nomImage VARCHAR(50) NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) ON DELETE CASCADE
);
