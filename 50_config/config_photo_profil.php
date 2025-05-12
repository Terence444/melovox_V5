<?php
session_start();
include "../70_database/connex_bdd.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../10_site/08_connexion.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];

// Vérifier si un fichier a été téléchargé
if (isset($_FILES['nouvelle_photo']) && $_FILES['nouvelle_photo']['error'] === UPLOAD_ERR_OK) {
    
    // Utiliser le bon chemin pour le dossier de destination
    $dossier_destination = __DIR__ . '/../80_imports/user_profile/';
    
    // Créer le dossier s'il n'existe pas (par précaution)
    if (!file_exists($dossier_destination)) {
        mkdir($dossier_destination, 0777, true);
    }
    
    // Générer un nom de fichier unique
    $extension = pathinfo($_FILES['nouvelle_photo']['name'], PATHINFO_EXTENSION);
    $nouveau_nom = uniqid() . '.' . $extension;
    $chemin_destination = $dossier_destination . $nouveau_nom;
    
    // Déplacer le fichier téléchargé
    if (move_uploaded_file($_FILES['nouvelle_photo']['tmp_name'], $chemin_destination)) {
        // Mise à jour de la base de données
        $sql = "UPDATE utilisateurs SET photo_profil = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nouveau_nom, $utilisateur_id);
        
        if ($stmt->execute()) {
            $_SESSION['photo_success'] = "Votre photo de profil a été mise à jour avec succès.";
        } else {
            $_SESSION['photo_error'] = "Erreur lors de la mise à jour de la base de données : " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['photo_error'] = "Erreur lors du téléchargement du fichier.";
    }
} else {
    $_SESSION['photo_error'] = "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
}

// Rediriger l'utilisateur vers sa page d'espace personnel
// Déterminer si l'utilisateur est un artiste ou non
$sql = "SELECT est_artiste FROM utilisateurs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$stmt->bind_result($est_artiste);
$stmt->fetch();
$stmt->close();

if ($est_artiste == 'oui') {
    header("Location: ../10_site/10_espace_perso_artist.php");
} else {
    header("Location: ../10_site/11_espace_perso_user.php");
}
exit();
?>