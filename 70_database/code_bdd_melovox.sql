CREATE DATABASE Melovox2;

USE Melovox2;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE NOT NULL,
    email VARCHAR(255) NOT NULL,
    sexe ENUM('homme', 'femme', 'ne_pas_repondre') DEFAULT 'ne_pas_repondre',
    est_artiste ENUM ('oui', 'non') NOT NULL,
    partage_creations ENUM ('oui', 'non') NOT NULL,
    pays VARCHAR(100) NOT NULL,
    nombre_playlists INT DEFAULT 0,
    pseudo VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    nombre_abonnements INT DEFAULT 0,
    photo_profil VARCHAR(255) DEFAULT 'default.jpg',
    UNIQUE KEY `email` (`email`(191)),
    UNIQUE KEY `pseudo` (`pseudo`(50))
);

CREATE TABLE artistes (
     INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    Email VARCHAR(255),
    Nom_d_artiste VARCHAR(255),
    Mot_de_passe VARCHAR(255) NOT NULL,
    ID_Genre VARCHAR(255),
    Nationalite VARCHAR(255),
    biographie TEXT,
    Albums INT,
    EPs INT,
    Singles INT,
    Nombre_abonnes INT
);


CREATE TABLE Album (
    Id_Album INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Duree TIME,
    Nombre_de_titre INT,
    Genre VARCHAR(255),
    Date_de_sortie DATE,
    Artiste INT,
    FOREIGN KEY (Artiste) REFERENCES Artiste(id),
    Titre INT,
    FOREIGN KEY (Titre) REFERENCES Titre(Id_titre)
);

CREATE TABLE EP (
    Id_EP INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Duree TIME,
    Nombre_de_titre INT,
    Genre VARCHAR(255),
    Date_de_sortie DATE,
    Artiste INT,
    FOREIGN KEY (Artiste) REFERENCES Artiste(id),
    Titre INT,
    FOREIGN KEY (Titre) REFERENCES Titre(Id_titre)
);

CREATE TABLE Single (
    Id_Single INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Duree TIME,
    Nombre_de_titre INT,
    Genre VARCHAR(255),
    Date_de_sortie DATE,
    Artiste INT,
    FOREIGN KEY (Artiste) REFERENCES Artiste(id),
    Titre INT,
    FOREIGN KEY (Titre) REFERENCES Titre(Id_titre)
);

CREATE TABLE Titre (
    Id_titre INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Duree TIME,
    Album INT,
    EP INT,
    Single INT,
    Genre VARCHAR(255),
    Date_de_sortie DATE,
    Artiste INT,
    FOREIGN KEY (Album) REFERENCES Album(Id_Album),
    FOREIGN KEY (EP) REFERENCES EP(Id_EP),
    FOREIGN KEY (Single) REFERENCES Single(Id_Single),
    FOREIGN KEY (Artiste) REFERENCES Artiste(id)
);

CREATE TABLE Playlist (
    Id_Playlist INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Nom_Utilisateur VARCHAR(100),
    Duree TIME,
    Nombre_de_titre INT,
    Date_de_creation DATE,
    Id_titre INT,
    FOREIGN KEY (Id_titre) REFERENCES Titre(Id_titre),
    FOREIGN KEY (Nom_Utilisateur) REFERENCES Utilisateur(Id_Utilisateur)
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    est_artiste TINYINT(1) NOT NULL,
    message TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id INT NOT NULL,
    date_abonnement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id) REFERENCES Artiste(id)
);

CREATE TABLE Genre (
    Id_Genre INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255),
    Nombre_de_titre INT,
    Nombre_albums INT,
    Nombre_d_EP INT,
    Nombre_de_single INT
);

CREATE TABLE Favoris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_titre INT NOT NULL,
    Type_Favoris ENUM('Album', 'EP', 'Single', 'Playlist') NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id),
    FOREIGN KEY (id_titre) REFERENCES Titre(Id_titre)
);
