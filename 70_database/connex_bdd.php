<?php
    // Déclaration des variables de connexion
    $servername = "localhost"; // Nom d'hôte du serveur de base de données
    $username = "root"; // Nom d'utilisateur pour la connexion
    $password = ""; // Mot de passe pour la connexion (ici vide)
    $dbname = "Melovox"; // Nom de la base de données

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
