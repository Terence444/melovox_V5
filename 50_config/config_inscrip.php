<?php
    include "../70_database/connex_bdd.php";

    // Démarrer la session pour stocker les messages d'erreur
    session_start();

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $sexe = $_POST['sexe'];
    $est_artiste = $_POST['est_artiste'];
    $partage_creations = $_POST['partage_creations'];
    $pays = $_POST['pays'];
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    // Vérifier si l'adresse email existe déjà
    $sql = "SELECT id FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['email_error'] = "Cette adresse email est déjà utilisée.";
    }
    $stmt->close();

    // Vérifier si le nom d'utilisateur existe déjà
    $sql = "SELECT id FROM utilisateurs WHERE pseudo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['pseudo_error'] = "Ce nom d'utilisateur est déjà utilisé.";
    }
    $stmt->close();

    // Rediriger en cas d'erreur
    if (isset($_SESSION['email_error']) || isset($_SESSION['pseudo_error'])) {
        $_SESSION['form_data'] = $_POST;
        header("Location: ../10_site/07_inscription.php");
        exit();
    }

    // Gérer l'upload de la photo de profil
    $photo_profil = null;
    if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
        $photo_profil = '../80_imports/user_profile/' . uniqid() . '_' . basename($_FILES['profilePhoto']['name']);
        move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $photo_profil);
    }

    try {
        // Démarrer la transaction
        $conn->begin_transaction();

        // Insérer l'utilisateur
        $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, sexe, est_artiste, partage_creations, pays, pseudo, mot_de_passe, photo_profil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiissss", $nom, $prenom, $date_naissance, $email, $sexe, $est_artiste, $partage_creations, $pays, $pseudo, $mot_de_passe, $photo_profil);
        $stmt->execute();

        // Récupérer l'ID de l'utilisateur
        $last_user_id = $conn->insert_id;

        // Si l'utilisateur est un artiste, dupliquer ses informations dans la table artistes
        if ($est_artiste == 1) {
            $sql = "INSERT INTO artistes (Id_Artiste, Nom, Prenom, Email, Mot_de_passe, Nationalite) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssss", $last_user_id, $nom, $prenom, $email, $mot_de_passe, $pays);
            $stmt->execute();
        }

        // Valider la transaction
        $conn->commit();

        // Nettoyer les données de session et rediriger
        unset($_SESSION['form_data']);
        $redirect_page = ($est_artiste == 1 && $partage_creations == 1) ? "10_espace_perso_artist.php" : "11_espace_perso_user.php";
        header("Location: ../10_site/$redirect_page");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "Erreur lors de l'inscription : " . $e->getMessage();
        header("Location: ../10_site/07_inscription.php");
        exit();
    }

    $stmt->close();
    $conn->close();
?>
