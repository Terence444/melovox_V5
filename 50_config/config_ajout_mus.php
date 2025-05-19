<?php
include "../70_database/connex_bdd.php";
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $artiste = $_POST['artiste'];
        $album = $_POST['album'];
        $genre = $_POST['genre'];

        // Gérer l'upload du fichier de musique
        if (isset($_FILES['fichier_musique']) && $_FILES['fichier_musique']['error'] === UPLOAD_ERR_OK) {
            // Créer un nom de fichier unique pour éviter les conflits
            $chemin_fichier = __DIR__ . '/../80_imports/musiques/' . uniqid() . '_' . basename($_FILES['fichier_musique']['name']);

            // Vérifier que le dossier existe, sinon le créer
            if (!is_dir(__DIR__ . '/../80_imports/musiques')) {
                mkdir(__DIR__ . '/../80_imports/musiques', 0777, true);
            }

            // Déplacer le fichier téléchargé vers le dossier de destination
            if (move_uploaded_file($_FILES['fichier_musique']['tmp_name'], $chemin_fichier)) {
                // Préparer et exécuter la requête d'insertion
                $sql = "INSERT INTO titre (utilisateur_id, titre, artiste, album, genre, chemin_fichier)
                VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isssss", $utilisateur_id, $titre, $artiste, $album, $genre, $chemin_fichier);

                if ($stmt->execute()) {
                    $_SESSION['import_success'] = "Musique importée avec succès!";
                    header("Location: ../10_site/11_espace_perso_user.php");
                    exit();
                } else {
                    echo "Erreur lors de l'import : " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Erreur lors du déplacement du fichier.";
            }
        } else {
            echo "Erreur lors du téléchargement du fichier. Code d'erreur : " . $_FILES['fichier_musique']['error'];
            echo "<pre>";
            print_r($_FILES['fichier_musique']);
            echo "</pre>";
        }
    }
} else {
    header("Location: ../10_site/08_connexion.php");
    exit();
}

$conn->close();
?>
