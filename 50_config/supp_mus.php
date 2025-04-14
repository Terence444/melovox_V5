<?php
include "70_database\connex_bdd.php";
session_start();

if (isset($_POST['musique_id']) && isset($_SESSION['user_id'])) {
    $chemin_fichier = $_POST['musique_id'];
    $utilisateur_id = $_SESSION['user_id'];

    // Supprimer le fichier du serveur
    if (file_exists($chemin_fichier)) {
        unlink($chemin_fichier);
    }

    // Supprimer l'entrée de la base de données en utilisant le chemin du fichier
    $sql = "DELETE FROM musique WHERE chemin_fichier = ? AND utilisateur_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $chemin_fichier, $utilisateur_id);

    if ($stmt->execute()) {
        $_SESSION['suppression_success'] = "Musique supprimée avec succès!";
    } else {
        $_SESSION['suppression_error'] = "Erreur lors de la suppression de la musique.";
    }

    $stmt->close();
}

header("Location: ../espace_perso_artiste.php");
exit();
?>
