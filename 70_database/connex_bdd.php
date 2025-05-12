<?php
    // Déclaration des variables de connexion
    $servername = "localhost"; // Nom d'hôte du serveur de base de données
    $username = "root"; // Nom d'utilisateur pour la connexion
    $password = ""; // Mot de passe pour la connexion (ici vide)
    $dbname = "Melovox2"; // Nom de la base de données

    // Crée une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifie si la connexion a échoué
    if ($conn->connect_error) {
        // Affiche un message d'erreur et arrête l'exécution du script
        die("Connection failed: " . $conn->connect_error);
    }
    // Affiche un message de succès si la connexion est établie
    echo "";
?>


<!-- // Informations de connexion à la base de données
//$host = "localhost";  // Généralement 'localhost' pour le développement local
$username = "votre_utilisateur";  // Nom d'utilisateur MySQL
$password = "votre_mot_de_passe";  // Mot de passe MySQL
$database = "musique_db";  // Nom de votre base de données

// Créer la connexion
$conn = new mysqli($host, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Définir le jeu de caractères à utf8
$conn->set_charset("utf8mb4");
 -->