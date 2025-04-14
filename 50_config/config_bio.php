<?php
include "70_database\connex_bdd.php";

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer la biographie du formulaire
        $biographie = $_POST['biographie'];

        // Vérifier si une entrée pour cet artiste existe déjà dans la table artistes
        $sql = "SELECT id FROM artistes WHERE utilisateur_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $utilisateur_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Mettre à jour la biographie existante
            $stmt->close();
            $sql = "UPDATE artistes SET biographie = ? WHERE utilisateur_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $biographie, $utilisateur_id);
        } else {
            // Insérer une nouvelle entrée dans la table artistes
            $stmt->close();
            $sql = "INSERT INTO artistes (utilisateur_id, biographie) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $utilisateur_id, $biographie);
        }

        // Exécuter la requête
        if ($stmt->execute()) {
            $_SESSION['bio_success'] = "Votre biographie a été mise à jour avec succès.";
        } else {
            $_SESSION['bio_error'] = "Une erreur est survenue lors de la mise à jour de votre biographie.";
        }
        $stmt->close();
    }
    header("Location: ../espace_perso_artiste.php");
    exit();
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: ../connexion.php");
    exit();
}

$conn->close();
?>
