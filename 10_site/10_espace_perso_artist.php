<?php
require "../20_includes/header.php";
include "../70_database/connex_bdd.php";

// Vérifier si une session est déjà active avant d'appeler session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté et est un artiste
if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    // Récupérer les informations de l'utilisateur et de l'artiste
    $sql = "SELECT u.nom, u.prenom, u.email, a.biographie, u.photo_profil
            FROM utilisateurs u
            LEFT JOIN artistes a ON u.id = a.id
            WHERE u.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $utilisateur_id);
    $stmt->execute();
    $stmt->bind_result($nom, $prenom, $email, $biographie, $photo_profil);
    $stmt->fetch();
    $stmt->close();
    
?>

    <?php
    // Chemin URL pour le navigateur
    $chemin_image = '../80_imports/user_profile/' . $photo_profil;
    
    // Chemin complet du serveur pour vérifier si le fichier existe
    $chemin_fichier = $_SERVER['DOCUMENT_ROOT'] . str_replace('..', '', $chemin_image);
    ?>


    <h1>Bienvenue sur votre espace artiste</h1><br>

    <!-- Affichage de la photo de profil -->
    <div id="profil">
        <?php if (!empty($photo_profil) && file_exists($chemin_fichier)) : ?>
            <img src="<?php echo htmlspecialchars($chemin_image); ?>" alt="Photo de profil" style="max-width: 200px; border-radius: 50%;">
        <?php else : ?>
            <img src="../80_imports/user_profile/default_profile.png" alt="Photo de profil par défaut" style="max-width: 200px; border-radius: 50%; text-align: center;">
        <?php endif; ?>

        <h3><?php echo htmlspecialchars($prenom . ' ' . $nom); ?></h3>
        <div id="user_stats">
            <h3>Nombre <br>d'abonnés</h3>
            <h3>Nombre <br>de titres</h3>
            <h3>Nombre <br>d'albums</h3>
            <h3>Nombre <br>d'EP, single</h3>
        </div>
    </div>

    <!-- Modif photo de profil -->
    <form id="photo_switch" action="../50_config/config_photo_profil.php" method="post" enctype="multipart/form-data">
        <label for="nouvelle_photo">Changer ma photo de profil :</label>
        <input id="select_file" type="file" name="nouvelle_photo" id="nouvelle_photo" accept="image/*" required>
        <input id="img_update" type="submit" value="Mettre à jour">
    </form>

    <?php
    // Messages pour la photo de profil et biographie
    if (isset($_SESSION['photo_success'])) {
        echo "<p class='success-message'>" . $_SESSION['photo_success'] . "</p>";
        unset($_SESSION['photo_success']);
    }
    if (isset($_SESSION['photo_error'])) {
        echo "<p class='error-message'>" . $_SESSION['photo_error'] . "</p>";
        unset($_SESSION['photo_error']);
    }
    if (isset($_SESSION['bio_success'])) {
        echo "<p class='success-message'>" . $_SESSION['bio_success'] . "</p>";
        unset($_SESSION['bio_success']);
    }
    if (isset($_SESSION['bio_error'])) {
        echo "<p class='error-message'>" . $_SESSION['bio_error'] . "</p>";
        unset($_SESSION['bio_error']);
    }
    ?>

    <section id="bio_artiste">
        <h2>Ma biographie</h2>  

        <div id="bio">
            <?php if ($biographie): ?>
                <p><?php echo nl2br(htmlspecialchars($biographie)); ?></p>
            <?php else: ?>
                <p>Votre biographie est vide. Cliquez sur le bouton ci-dessous pour ajouter votre biographie.</p>
            <?php endif; ?>
        </div>

        <button type="button" id="modifier_bio_btn">Modifier ma bio</button>

        <!-- Formulaire de modification de la biographie -->
        <form id="form_bio" action="../50_config/config_bio.php" method="post" style="display: none;">
            <textarea name="biographie" rows="10" cols="50" required><?php echo htmlspecialchars($biographie); ?></textarea>
            <br>
            <div id="bio_button_area">
                <input id="save_bio_button" type="submit" value="Enregistrer">
                <button type="button" id="annuler_btn">Annuler</button>
            </div>
        </form>
    </section>

    <section id="import_musique">
        <!-- Le reste du code reste inchangé -->
    </section>

    <?php
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté ou pas artiste
            header("Location: ../10_site/08_connexion.php");
            exit();
        }

        require "../20_includes/footer.php";
    ?>

<script>
    document.getElementById('modifier_bio_btn').addEventListener('click', function() {
        document.getElementById('form_bio').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('annuler_btn').addEventListener('click', function() {
        document.getElementById('form_bio').style.display = 'none';
        document.getElementById('modifier_bio_btn').style.display = 'inline';
    });
</script>