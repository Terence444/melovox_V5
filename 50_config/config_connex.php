<?php
// Inclure le fichier de connexion à la base de données
include "../70_database/connex_bdd.php";

// Démarrer une session
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer la requête pour récupérer l'utilisateur avec l'email fourni
    $sql = "SELECT id, pseudo, email, mot_de_passe, est_artiste FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    // Exécuter la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si un utilisateur a été trouvé
    if ($result->num_rows === 1) {
        // Récupérer les données de l'utilisateur
        $user = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($password, $user['mot_de_passe'])) {
            // Mot de passe correct, enregistrer les informations en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['est_artiste'] = $user['est_artiste'];

            // Vérifier si l'utilisateur a coché "Rester connecté"
            if (isset($_POST['connect'])) {
                // Créer des cookies pour maintenir la session
                setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 30 jours
                setcookie('pseudo', $user['pseudo'], time() + (86400 * 30), "/");
                setcookie('email', $user['email'], time() + (86400 * 30), "/");
                setcookie('est_artiste', $user['est_artiste'], time() + (86400 * 30), "/");
            }

            // Rediriger en fonction du statut d'artiste
            if ($user['est_artiste'] == 'oui') {
                header("Location: ../10_site/10_espace_perso_artist.php");
                exit();
            } else {
                header("Location: ../10_site/11_espace_perso_user.php");
                exit();
            }
        } else {
            // Mot de passe incorrect
            $_SESSION['login_error'] = "Adresse email ou mot de passe incorrect.";
            header("Location: ../10_site/08_connexion.php");
            exit();
        }
    } else {
        // Aucun utilisateur trouvé avec cet email
        $_SESSION['login_error'] = "Adresse email ou mot de passe incorrect.";
        header("Location: ../10_site/08_connexion.php");
        exit();
    }

    // Fermer la requête
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>