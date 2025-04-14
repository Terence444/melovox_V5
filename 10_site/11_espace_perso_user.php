<?php
require "20_includes\header.php";
include "70_database\connex_bdd.php";

// Vérifier si une session est déjà active avant d'appeler session_start()
if (session_status() === PHP_SESSION_NONE) {
session_start();
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
     $utilisateur_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$sql = "SELECT u.nom, u.prenom, u.email, a.biographie, a.photo_profil
        FROM utilisateurs u
        LEFT JOIN artistes a ON u.id = a.utilisateur_id
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$stmt->bind_result($nom, $prenom, $email, $biographie, $photo_profil);
$stmt->fetch();
$stmt->close();
    
?>

    <?php
    // Après avoir récupéré $photo_profil depuis la base de données
    // var_dump($photo_profil); // Pour débogage

    // Chemin du fichier sur le serveur
    $chemin_fichier = __DIR__ . 'uploads/photos_profil/' . $photo_profil;

    // Chemin URL pour le navigateur (en supposant que le chemin depuis la racine du serveur soit /uploads/photos_profil/)
    $chemin_image = '/uploads/photos_profil/' . $photo_profil;
    ?>


    <h1>Bienvenue sur votre espace</h1><br>

    <!-- Affichage de la photo de profil -->
    <div id="profil">
        <?php if (!empty($photo_profil) && file_exists($chemin_fichier)) : ?>
            <img src="<?php echo htmlspecialchars($chemin_image); ?>" alt="Photo de profil" style="max-width: 200px; border-radius: 50%;">
        <?php else : ?>
            <img src="uploads/photos_profil/default_profile.png" alt="Photo de profil par défaut" style="max-width: 200px; border-radius: 50%; text-align: center;">
        <?php endif; ?>
        
    
        <h3><?php echo htmlspecialchars($prenom . ' ' . $nom); ?></h3>
        <div id="user_stats">
            <h3>Nombre <br>d’abonnements</h3>
            <h3>Nombre <br>de playlists</h3>
        </div>
    </div>

    


    <!-- Modif photo de profil -->
    <form id="photo_switch" action="50_config\config_photo_profil.php" method="post" enctype="multipart/form-data">
        <label for="nouvelle_photo">Changer ma photo de profil :</label>
        <input id="select_file" type="file" name="nouvelle_photo" id="nouvelle_photo" accept="image/*" required>
        <input id="img_update" type="submit" value="Mettre à jour">
    </form>

    <?php
// Messages pour la photo de profil
if (isset($_SESSION['photo_success'])) {
    echo "<p class='success-message'>" . $_SESSION['photo_success'] . "</p>";
    unset($_SESSION['photo_success']);
}
if (isset($_SESSION['photo_error'])) {
    echo "<p class='error-message'>" . $_SESSION['photo_error'] . "</p>";
    unset($_SESSION['photo_error']);
}
?>



<section id="collection">
    <h4>Vos playlist</h4>
    <div id="playlist_area">
        <div class="playlist">
            <a href="10_site\06_playlist.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>

            <a href="10_site\06_playlist.php">Playlist N°1</a>
        </div>

        <div class="playlist">
            <a href="10_site\06_playlist.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>
            <a href="10_site\06_playlist.php">Playlist N°2</a>
        </div>

        <div class="playlist">
            <a href="10_site\06_playlist.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>
            <a href="10_site\06_playlist.php">Playlist N°3</a>
        </div>
    </div>

    <h4>Vos albums/EP/Single</h4>
    <div id="album_area">
        <div class="album">
            <a href="10_site\05_albums_ep_single.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>
            <a href="10_site\05_albums_ep_single.php">Album</a>
        </div>

        <div class="album">
            <a href="10_site\05_albums_ep_single.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>
            <a href="10_site\05_albums_ep_single.php">EP</a>
        </div>

        <div class="album">
            <a href="10_site\05_albums_ep_single.php"><img class="playlist_icon" src="60_visuels\icon\icone_playlist.png" alt=""></a>
            <a href="10_site\05_albums_ep_single.php">Single</a>
        </div>
    </div>

</section>
    


<?php 
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: ../connexion.php");
            exit();
        }
        
        require "20_includes/footer.php";
    ?>
