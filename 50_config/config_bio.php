<?php
include "../70_database/connex_bdd.php";

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est un artiste
    $sql_check = "SELECT est_artiste FROM utilisateurs WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $utilisateur_id);
    $stmt_check->execute();
    $stmt_check->bind_result($est_artiste);
    $stmt_check->fetch();
    $stmt_check->close();

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $est_artiste == 'oui') {
        // Récupérer la biographie du formulaire
        $biographie = $_POST['biographie'];

        // Vérifier si une entrée pour cet artiste existe déjà dans la table artistes
        $sql_exists = "SELECT id FROM artistes WHERE id = ?";
        $stmt_exists = $conn->prepare($sql_exists);
        $stmt_exists->bind_param("i", $utilisateur_id);
        $stmt_exists->execute();
        $stmt_exists->store_result();
        $artiste_existe = $stmt_exists->num_rows > 0;
        $stmt_exists->close();

        if ($artiste_existe) {
            // Mettre à jour la biographie existante
            $sql = "UPDATE artistes SET biographie = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $biographie, $utilisateur_id);
        } else {
            // Insérer une nouvelle entrée dans la table artistes
            $sql = "INSERT INTO artistes (id, biographie) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $utilisateur_id, $biographie);
        }

        // Exécuter la requête
        if ($stmt->execute()) {
            $_SESSION['bio_success'] = "Votre biographie a été mise à jour avec succès.";
        } else {
            $_SESSION['bio_error'] = "Une erreur est survenue lors de la mise à jour de votre biographie: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Redirection vers la page artiste
    header("Location: ../10_site/10_espace_perso_artist.php");
    exit();
} else {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: ../10_site/08_connexion.php");
    exit();
}

$conn->close();
?>