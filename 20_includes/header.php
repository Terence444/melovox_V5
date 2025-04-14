<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>MÉLOVOX</title>

    <!-- Css du header et footer -->
    <link rel="stylesheet" href="./20_includes\header.css">
    <link rel="stylesheet" href="./20_includes\footer.css">

    <!-- Programme pour charger chaque feuille de style CSS en fonction du nom des pages -->
    <?php
    // Définir le chemin des fichiers CSS en utilisant une constante
    define('CSS_PATH', '/30_styles/');

    // Identifier la page actuelle (basée sur une variable de page)
    $page = basename($_SERVER['PHP_SELF']);

    // Vérifier si le nom de la page est "nom_du_fichier.php"
    if ($page === '10_site\05_albums_ep_single.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/05_albums_ep_single.css'>";
    } elseif ($page === '10_site\12_artist_profile.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/12_artist_profile.css'>";
    } elseif ($page === '10_site\04_category.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/04_category.css'>";
    } elseif ($page === '10_site\09_contactform.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/09_contactform.css'>";
    } elseif ($page === '10_site\08_connexion.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/08_connexion.css'>";
    } elseif ($page === '10_site\07_inscription.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/07_inscription.css'>";
    } elseif ($page === '10_site\03_gallery.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/03_gallery.css'>";
    } elseif ($page === '10_site\01_index.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/01_index.css'>";
    } elseif ($page === '10_site\06_playlist.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/06_playlist.css'>";
    // } elseif ($page === 'profile.php') {
    //     echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "profile_style.css'>";
    } elseif ($page === '10_site\02_search.php') {
        echo "<link rel='stylesheet' type='text/css' href='" . CSS_PATH . "30_styles/02_search.css'>";
    } elseif ($page === '10_site\10_espace_perso_artist.php') {
        echo"<link rel='stylesheet' type='text/css' href='" . CSS_PATH ."30_styles/10_espace_perso_artist.css'>";
    } elseif ($page === '10_site\11_espace_perso_user.php') {
        echo"<link rel='stylesheet' type='text/css' href='" . CSS_PATH ."30_styles/11_espace_perso_user.css'>";
    }
    ?>

    <!-- meta pour menu hamburger -->
    <link rel="stylesheet" href="20_includes\menu_déroulant.css">
    <script src="40_scripts\menu_déroulant.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="path/to/owl.carousel.min.css">
    <link rel="stylesheet" href="path/to/owl.theme.default.min.css">

    <script src="node_modules\jquery\dist\jquery.js"></script>
    

    <!--meta typos  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

   
</head>

<body>
    <?php
        // Vérifier si une session est déjà active avant d'appeler session_start()
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $is_connected = isset($_SESSION['user_id']); // Vérifier si l'utilisateur est connecté
    ?>

    <header>
        <div id="logo_title">
            <a href="10_site\01_index.php"><img id="logo" src="60_visuels\logo\logo.png" alt=""></a>
            <h1>Mélovox</h1>
        </div>
        <div id="search_connex">
            <div class="wrapMenu">
                <div class="menu menu--top-right" id="menu_top_right">
                    <a class="menu__btn" dd-nav-expand="menu_top_right"><img src="60_visuels\icon\menu_hamburger.png" alt=""></a>
                    <ul class="menu__list">
                        <li><a href="10_site\01_index.php">Accueil</a></li>
                        <li><a href="10_site\09_contactform.php">Contact</a></li>
                        <li><a href="10_site\03_gallery.php">Galerie</a></li>
                        <li><a href="10_site\11_espace_perso_user.php">Mon espace</a></li>
                    </ul>
                </div>
            </div>

            <a href="10_site\02_search.php"><span class="material-symbols-outlined">search</span></a>
            <?php if ($is_connected) : ?>
                <!-- Afficher le bouton de déconnexion si l'utilisateur est connecté -->
                <a href="50_config\deconnexion.php"><button>Déconnexion</button></a>
            <?php else : ?>
                <!-- Afficher les boutons de connexion et d'inscription si l'utilisateur n'est pas connecté -->
                <a href="10_site\08_connexion.php"><button>Connexion</button></a>
                <span id="vertical_line"></span>
                <a href="10_site\07_inscription.php"><button>Inscription</button></a>
            <?php endif; ?>
        </div>
    </header>
