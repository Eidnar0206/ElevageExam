CREATE TABLE tea_table (
    idThe INT PRIMARY KEY AUTO_INCREMENT,
    varietesDeThe VARCHAR(255) NOT NULL,
    occupation FLOAT NOT NULL,
    rendementParPied FLOAT NOT NULL
);

CREATE TABLE tea_parcelle (
    idParcelle INT PRIMARY KEY AUTO_INCREMENT,
    surface FLOAT NOT NULL,
    idThe INT NOT NULL,
    FOREIGN KEY (idThe) REFERENCES the_table(idThe)
);

CREATE TABLE tea_cueilleurs (
    idCueilleur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL enum('homme', 'femme'),
    dateDeNaissance DATE NOT NULL
);

CREATE TABLE tea_categorieDepenses (
    idCategorieDepenses INT PRIMARY KEY AUTO_INCREMENT,
    categorieDepense VARCHAR(255) NOT NULL
);

CREATE TABLE tea_depenses (
    idDepenses INT PRIMARY KEY AUTO_INCREMENT,
    montant FLOAT NOT NULL,
    dateDepense date NOT NULL,
    idCategorieDepenses INT NOT NULL,
    FOREIGN KEY (idCategorieDepenses) REFERENCES tea_categorieDepenses(idCategorieDepenses)
);

CREATE TABLE tea_cueillettes (
    idCueillettes INT PRIMARY KEY AUTO_INCREMENT,
    dateCueillettes DATE NOT NULL,
    poidsCueilli FLOAT NOT NULL,
    idParcelle INT NOT NULL,
    idCueilleur INT NOT NULL,
    FOREIGN KEY (idParcelle) REFERENCES tea_parcelle(idParcelle),
    FOREIGN KEY (idCueilleur) REFERENCES tea_cueilleurs(idCueilleur)
);

CREATE TABLE tea_historiquePrixThe (
    idHistoriquePrixThe INT PRIMARY KEY AUTO_INCREMENT,
    prix FLOAT NOT NULL,
    datePrix DATE NOT NULL,
    idThe INT NOT NULL,
    FOREIGN KEY (idThe) REFERENCES tea_table(idThe)
);

CREATE TABLE tea_historiqueSalaireCueilleur (
    idHistoriqueSalaireCueilleur INT PRIMARY KEY AUTO_INCREMENT,
    salaire FLOAT NOT NULL,
    dateSalaire DATE NOT NULL,
    idCueilleur INT NOT NULL,
    FOREIGN KEY (idCueilleur) REFERENCES tea_cueilleurs(idCueilleur)
);

CREATE TABLE tea_configurationMbm (
    poidsMinimal FLOAT NOT NULL,
    bonus FLOAT NOT NULL,
    mallus FLOAT NOT NULL
);

CREATE TABLE tea_paiements (
    idPaiement INT NOT NULL AUTO_INCREMENT,
    datePaiement date,
    idCueilleur INT NOT NULL,
    poids FLOAT NOT NULL,
    bonus FLOAT,
    mallus FLOAT,
    montant FLOAT NOT NULL,
    FOREIGN KEY (idCueilleur) REFERENCES tea_cueilleurs(idCueilleur)
);





