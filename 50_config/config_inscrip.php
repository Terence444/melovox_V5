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

    // Initialiser les messages d'erreur
    $email_error = '';
    $pseudo_error = '';

    // Vérifier si l'adresse email existe déjà
    $sql = "SELECT id FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $email_error = "Cette adresse email est déjà utilisée.";
    }
    $stmt->close();

    // Vérifier si le nom d'utilisateur existe déjà
    $sql = "SELECT id FROM utilisateurs WHERE pseudo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $pseudo_error = "Ce nom d'utilisateur est déjà utilisé.";
    }
    $stmt->close();

    // Si des erreurs sont présentes, les stocker en session et rediriger vers le formulaire
    if (!empty($email_error) || !empty($pseudo_error)) {
        $_SESSION['email_error'] = $email_error;
        $_SESSION['pseudo_error'] = $pseudo_error;
        // Stocker les données saisies pour les réafficher
        $_SESSION['form_data'] = $_POST;
        header("Location: ../10_site/07_inscription.php");
        exit();
    }

    // Gérer l'upload de la photo de profil
    $photo_profil = null;
    if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
        // Créer un nom de fichier unique pour éviter les conflits
        $photo_profil = '80_imports/user_profile/' . uniqid() . '_' . basename($_FILES['profilePhoto']['name']);
        move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $photo_profil);
    }

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO utilisateurs (nom, prenom, date_naissance, email, sexe, est_artiste, partage_creations, pays, pseudo, mot_de_passe, photo_profil)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiissss", $nom, $prenom, $date_naissance, $email, $sexe, $est_artiste,
                      $partage_creations, $pays, $pseudo, $mot_de_passe, $photo_profil);

    if ($stmt->execute()) {
        // Nettoyer les données de session
        unset($_SESSION['form_data']);
        // Rediriger l'utilisateur en fonction de ses réponses
        if ($est_artiste == 1 && $partage_creations == 1) {
            header("Location: ../10_site/10_espace_perso_artist.php");
            exit();
        } else {
            header("Location: ../10_site/11_espace_perso_user.php");
            exit();
        }
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
?>
