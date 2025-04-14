<?php
session_start();
session_unset(); // Libérer toutes les variables de session
session_destroy(); // Détruire la session

header("Location: index.php"); // Rediriger vers la page d'accueil ou la page de connexion
exit();
?>
