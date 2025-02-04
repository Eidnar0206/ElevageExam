CREATE DATABASE IF NOT EXISTS elevage;
USE elevage;

CREATE TABLE IF NOT EXISTS elevage_capital (
    idElevage INT PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    dateDebut DATE NOT NULL DEFAULT '2025-02-03'
);

CREATE TABLE IF NOT EXISTS elevage_capitalTransactions (
    idTransaction INT PRIMARY KEY AUTO_INCREMENT,
    montant DECIMAL(10,2) NOT NULL,
    typeTransaction ENUM('entree', 'sortie') NOT NULL, 
    description VARCHAR(255),
    dateTransaction DATE NOT NULL DEFAULT '2025-02-03'
);

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

CREATE TABLE IF NOT EXISTS elevage_animaux (
    idAnimal INT PRIMARY KEY AUTO_INCREMENT,
    idEspece INT NOT NULL,
    prixAchat INT NOT NULL,
    poidsInitial DECIMAL(5,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idEspece) REFERENCES elevage_espece(idEspece) 
);

CREATE TABLE IF NOT EXISTS elevage_alimentation (
    idAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    nomAlimentation VARCHAR(50) NOT NULL,
    idEspece INT NOT NULL,
    gainPoids DECIMAL(4,2) NOT NULL, -- Pourcentage de gain de poids
    FOREIGN KEY (idEspece) REFERENCES elevage_espece(idEspece) 
);

CREATE TABLE IF NOT EXISTS elevage_achatAlimentation (
    idAchatAlimentation INT PRIMARY KEY AUTO_INCREMENT,
    idAlimentation INT NOT NULL,
    quantite DECIMAL(4,2) NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateAchat DATE NOT NULL,
    FOREIGN KEY (idAlimentation) REFERENCES elevage_alimentation(idAlimentation) 
);

CREATE TABLE IF NOT EXISTS elevage_Ventes (
    idVente INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    poidsVente DECIMAL(5,2) NOT NULL,
    prixTotal DECIMAL(10,2) NOT NULL,
    dateVente DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

CREATE TABLE IF NOT EXISTS elevage_morts (
    idMort INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    dateMort DATE NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);

CREATE TABLE IF NOT EXISTS elevage_imagesAnimaux (
    idImage INT PRIMARY KEY AUTO_INCREMENT,
    idAnimal INT NOT NULL,
    nomImage VARCHAR(50) NOT NULL,
    FOREIGN KEY (idAnimal) REFERENCES elevage_animaux(idAnimal) 
);


