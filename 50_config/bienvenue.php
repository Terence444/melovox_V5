<?php
session_start();

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

$pseudo = htmlspecialchars($_SESSION['pseudo']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
</head>

<body>
    <h1>Bienvenue, <?= $pseudo; ?> !</h1>
    <p>Votre inscription est réussie. Profitez de votre expérience sur Melovox.</p>
    <a href="50_config\deconnexion.php">Se déconnecter</a>
</body>

</html>