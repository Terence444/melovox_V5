<?php
// Inclure le fichier de connexion à la base de données
include "../70_database/connex_bdd.php";

// Démarrer une session pour afficher les messages de confirmation ou d'erreur
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['name'];
    $prenom = $_POST['first_name'];
    $email = $_POST['email'];
    $est_artiste = $_POST['artist'];
    $message = $_POST['message'];

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO contact (nom, prenom, email, est_artiste, message)
        VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $nom, $prenom, $email, $est_artiste, $message);

    if ($stmt->execute()) {
        $_SESSION['contact_success'] = "Votre message a été envoyé avec succès !";
    } else {
        $_SESSION['contact_error'] = "Une erreur s'est produite lors de l'envoi de votre message. Veuillez réessayer plus tard.";
    }

    $stmt->close();
    header("Location: ../10_site/09_contactform.php");
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>
