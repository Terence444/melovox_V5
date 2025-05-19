<?php
include "../70_database/connex_bdd.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../10_site/08_connexion.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $artiste_nom = $_POST['artiste'];  // Ceci est juste le nom de l'artiste, pas l'ID
    $album_nom = isset($_POST['album']) ? $_POST['album'] : '';
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';

    // Vérifier si un fichier a été soumis
    if (!isset($_FILES['fichier_musique']) || $_FILES['fichier_musique']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['import_error'] = "Aucun fichier n'a été sélectionné.";
        header("Location: ../10_site/10_espace_perso_artist.php");
        exit();
    }

    // Vérifier les erreurs d'upload
    if ($_FILES['fichier_musique']['error'] !== UPLOAD_ERR_OK) {
        $error_message = "Erreur lors du téléchargement : ";
        switch ($_FILES['fichier_musique']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error_message .= "Le fichier dépasse la taille maximale autorisée par PHP.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error_message .= "Le fichier dépasse la taille maximale autorisée par le formulaire.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message .= "Le fichier n'a été que partiellement téléchargé.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error_message .= "Dossier temporaire manquant.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error_message .= "Échec de l'écriture du fichier sur le disque.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $error_message .= "Une extension PHP a arrêté le téléchargement.";
                break;
            default:
                $error_message .= "Erreur inconnue.";
        }
        $_SESSION['import_error'] = $error_message;
        header("Location: ../10_site/10_espace_perso_artist.php");
        exit();
    }

    // Vérifier le type de fichier (optionnel mais recommandé)
    $allowed_types = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'];
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $file_mime = finfo_file($file_info, $_FILES['fichier_musique']['tmp_name']);
    finfo_close($file_info);

    if (!in_array($file_mime, $allowed_types)) {
        $_SESSION['import_error'] = "Type de fichier non autorisé. Seuls les fichiers audio sont acceptés.";
        header("Location: ../10_site/10_espace_perso_artist.php");
        exit();
    }

    // Créer un nom de fichier unique
    $extension = pathinfo($_FILES['fichier_musique']['name'], PATHINFO_EXTENSION);
    $nouveau_nom = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $titre) . '.' . $extension;
    $upload_dir = __DIR__ . '/../80_imports/musiques/';
    $chemin_fichier = $upload_dir . $nouveau_nom;
    $chemin_relatif = '../80_imports/musiques/' . $nouveau_nom; // Pour stockage en BDD

    // Vérifier que le dossier existe, sinon le créer
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            $_SESSION['import_error'] = "Impossible de créer le répertoire de destination.";
            header("Location: ../10_site/10_espace_perso_artist.php");
            exit();
        }
    }

    // Déplacer le fichier téléchargé
    if (move_uploaded_file($_FILES['fichier_musique']['tmp_name'], $chemin_fichier)) {
        // L'utilisateur_id est déjà l'ID de l'artiste car on est dans l'espace artiste
        
        // On prépare la date actuelle pour la date de sortie
        $date_sortie = date('Y-m-d');
        
        // Préparer et exécuter la requête d'insertion dans la table Titre
        $sql = "INSERT INTO Titre (Nom, Genre, Date_de_sortie, Artiste, chemin_fichier) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $titre, $genre, $date_sortie, $utilisateur_id, $chemin_relatif);

        if ($stmt->execute()) {
            $titre_id = $conn->insert_id;
            
            // Si un album a été spécifié, vérifier s'il existe déjà ou le créer
            if (!empty($album_nom)) {
                // Vérifier si l'album existe déjà pour cet artiste
                $sql_check_album = "SELECT Id_Album FROM Album WHERE Nom = ? AND Artiste = ?";
                $stmt_check = $conn->prepare($sql_check_album);
                $stmt_check->bind_param("si", $album_nom, $utilisateur_id);
                $stmt_check->execute();
                $result_album = $stmt_check->get_result();
                
                if ($result_album->num_rows > 0) {
                    // L'album existe, récupérer son ID
                    $album = $result_album->fetch_assoc();
                    $album_id = $album['Id_Album'];
                    
                    // Mettre à jour le nombre de titres de l'album
                    $sql_update_album = "UPDATE Album SET Nombre_de_titre = Nombre_de_titre + 1 WHERE Id_Album = ?";
                    $stmt_update = $conn->prepare($sql_update_album);
                    $stmt_update->bind_param("i", $album_id);
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    // L'album n'existe pas, le créer
                    $sql_create_album = "INSERT INTO Album (Nom, Nombre_de_titre, Genre, Date_de_sortie, Artiste) 
                                        VALUES (?, 1, ?, ?, ?)";
                    $stmt_create = $conn->prepare($sql_create_album);
                    $stmt_create->bind_param("sssi", $album_nom, $genre, $date_sortie, $utilisateur_id);
                    $stmt_create->execute();
                    $album_id = $conn->insert_id;
                    $stmt_create->close();
                }
                
                $stmt_check->close();
                
                // Associer le titre à l'album
                $sql_link = "UPDATE Titre SET Album = ? WHERE Id_titre = ?";
                $stmt_link = $conn->prepare($sql_link);
                $stmt_link->bind_param("ii", $album_id, $titre_id);
                $stmt_link->execute();
                $stmt_link->close();
            }
            
            $_SESSION['import_success'] = "Titre importé avec succès!";
        } else {
            $_SESSION['import_error'] = "Erreur lors de l'enregistrement en base de données : " . $stmt->error;
            // Supprimer le fichier qui vient d'être uploadé en cas d'erreur
            unlink($chemin_fichier);
        }
        
        $stmt->close();
    } else {
        $_SESSION['import_error'] = "Erreur lors du déplacement du fichier.";
    }
    
    header("Location: ../10_site/10_espace_perso_artist.php");
    exit();
}

$conn->close();
?>