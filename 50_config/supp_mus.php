<?php
include "../70_database/connex_bdd.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../10_site/08_connexion.php");
    exit();
}

$utilisateur_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titre_id'])) {
    $titre_id = $_POST['titre_id'];
    
    // Vérifier que le titre appartient bien à l'artiste connecté
    $sql_check = "SELECT chemin_fichier FROM Titre WHERE Id_titre = ? AND Artiste = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $titre_id, $utilisateur_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    
    if ($result->num_rows > 0) {
        $titre = $result->fetch_assoc();
        $chemin_fichier = $titre['chemin_fichier'];
        
        // Supprimer le fichier physique s'il existe
        if (!empty($chemin_fichier)) {
            $chemin_serveur = $_SERVER['DOCUMENT_ROOT'] . str_replace('..', '', $chemin_fichier);
            if (file_exists($chemin_serveur)) {
                unlink($chemin_serveur);
            }
        }
        
        // Récupérer l'Album associé au titre (s'il y en a un)
        $sql_album = "SELECT Album FROM Titre WHERE Id_titre = ?";
        $stmt_album = $conn->prepare($sql_album);
        $stmt_album->bind_param("i", $titre_id);
        $stmt_album->execute();
        $result_album = $stmt_album->get_result();
        $album_id = null;
        
        if ($result_album->num_rows > 0) {
            $row = $result_album->fetch_assoc();
            if (!empty($row['Album'])) {
                $album_id = $row['Album'];
            }
        }
        $stmt_album->close();
        
        // Supprimer le titre de la base de données
        $sql_delete = "DELETE FROM Titre WHERE Id_titre = ? AND Artiste = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $titre_id, $utilisateur_id);
        
        if ($stmt_delete->execute()) {
            // Si le titre était associé à un album, mettre à jour le nombre de titres
            if ($album_id) {
                $sql_update_album = "UPDATE Album SET Nombre_de_titre = Nombre_de_titre - 1 WHERE Id_Album = ?";
                $stmt_update = $conn->prepare($sql_update_album);
                $stmt_update->bind_param("i", $album_id);
                $stmt_update->execute();
                $stmt_update->close();
                
                // Vérifier si l'album est vide et le supprimer si nécessaire
                $sql_check_empty = "SELECT COUNT(*) as count FROM Titre WHERE Album = ?";
                $stmt_check_empty = $conn->prepare($sql_check_empty);
                $stmt_check_empty->bind_param("i", $album_id);
                $stmt_check_empty->execute();
                $result_empty = $stmt_check_empty->get_result();
                $row_empty = $result_empty->fetch_assoc();
                
                if ($row_empty['count'] == 0) {
                    $sql_delete_album = "DELETE FROM Album WHERE Id_Album = ?";
                    $stmt_delete_album = $conn->prepare($sql_delete_album);
                    $stmt_delete_album->bind_param("i", $album_id);
                    $stmt_delete_album->execute();
                    $stmt_delete_album->close();
                }
                $stmt_check_empty->close();
            }
            
            $_SESSION['delete_success'] = "Le titre a été supprimé avec succès.";
        } else {
            $_SESSION['delete_error'] = "Erreur lors de la suppression du titre : " . $stmt_delete->error;
        }
        
        $stmt_delete->close();
    } else {
        $_SESSION['delete_error'] = "Vous n'êtes pas autorisé à supprimer ce titre ou il n'existe pas.";
    }
    
    $stmt_check->close();
    
    header("Location: ../10_site/10_espace_perso_artist.php");
    exit();
} else {
    header("Location: ../10_site/10_espace_perso_artist.php");
    exit();
}

$conn->close();
?>