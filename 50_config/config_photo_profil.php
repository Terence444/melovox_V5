<?php
include "../70_database/connex_bdd.php";
session_start();

if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Gérer l'upload de la nouvelle photo de profil
        if (isset($_FILES['nouvelle_photo']) && $_FILES['nouvelle_photo']['error'] === UPLOAD_ERR_OK) {
            // Vérifier le type de fichier
            $types_permis = ['image/jpeg', 'image/png', 'image/gif'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['nouvelle_photo']['tmp_name']);

            if (in_array($mime, $types_permis)) {
                // Créer un nom de fichier unique
                $extension = pathinfo($_FILES['nouvelle_photo']['name'], PATHINFO_EXTENSION);
                $nouveau_nom_fichier = __DIR__ . '/../uploads/photos_profil/' . uniqid() . '.' . $extension;

                // Vérifier que le dossier existe ou le créer
                if (!is_dir(__DIR__ . '/../80_imports/user_profile/')) {
                    mkdir(__DIR__ . '/../80_imports/user_profile/', 0777, true);
                }

                // Déplacer le fichier uploadé
                if (move_uploaded_file($_FILES['nouvelle_photo']['tmp_name'], $nouveau_nom_fichier)) {
                    // Mettre à jour la base de données
                    $chemin_fichier = str_replace(__DIR__, '', $nouveau_nom_fichier);
                    $sql = "UPDATE artistes SET photo_profil = ? WHERE utilisateur_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $chemin_fichier, $utilisateur_id);

                    if ($stmt->execute()) {
                        $_SESSION['photo_success'] = "Votre photo de profil a été mise à jour avec succès.";
                    } else {
                        $_SESSION['photo_error'] = "Erreur lors de la mise à jour de la photo de profil.";
                    }
                    $stmt->close();
                } else {
                    $_SESSION['photo_error'] = "Erreur lors du téléchargement du fichier.";
                }
            } else {
                $_SESSION['photo_error'] = "Type de fichier non autorisé. Veuillez choisir une image JPG, PNG ou GIF.";
            }
        } else {
            $_SESSION['photo_error'] = "Veuillez sélectionner un fichier.";
        }
    }
    header("Location: ../30_styles/10_espace_perso_artist.css");
    exit();
} else {
    header("Location: ../10_site/08_connexion.php");
    exit();
}
$conn->close();
?>
