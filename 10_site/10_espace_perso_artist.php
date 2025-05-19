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
            -- LEFT JOIN artistes a ON u.id = a.id
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
            <!-- <textarea name="biographie" rows="10" cols="50" required><?php echo htmlspecialchars($biographie); ?></textarea> -->
             <textarea name="biographie" rows="10" cols="50" required><?php echo !empty($biographie) ? htmlspecialchars($biographie) : ""; ?></textarea>
            <br>
            <br>
            <div id="bio_button_area">
                <input id="save_bio_button" type="submit" value="Enregistrer">
                <button type="button" id="annuler_btn">Annuler</button>
            </div>
        </form>
    </section>

   <section id="import_musique">
        <h2>Déposer de nouveaux titres</h2>
        <form action="../50_config/config_ajout_mus.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div>
                <label for="artiste">Artiste</label>
                <input type="text" id="artiste" name="artiste" required>
            </div>
            <div>
                <label for="album">Album</label>
                <input type="text" id="album" name="album">
            </div>
            <div>
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre">
            </div>
            <div>
                <label for="fichier_musique">Fichier Musique</label>
                <input type="file" id="fichier_musique" name="fichier_musique" accept="audio/*" required>
            </div>
            <div>
                <input id="import_music_button" type="submit" value="Importer">
            </div>
        </form>
    </section>

<section id="liste_musiques">
    <h2>Mes titres en ligne</h2>

    <div id="les_musiques">
    <?php
  
    // Requête pour récupérer les titres de l'artiste connecté
    $sql_titres = "SELECT t.Id_titre, t.Nom, t.Genre, t.Date_de_sortie, t.chemin_fichier, a.Nom as nom_album 
                  FROM Titre t 
                  LEFT JOIN Album a ON t.Album = a.Id_Album 
                  WHERE t.Artiste = ?
                  ORDER BY t.Date_de_sortie DESC";
    
    $stmt_titres = $conn->prepare($sql_titres);
    $stmt_titres->bind_param("i", $utilisateur_id);
    $stmt_titres->execute();
    $result_titres = $stmt_titres->get_result();
    
    if ($result_titres->num_rows > 0) {
        echo '<table class="table_titres">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Album</th>
                        <th>Genre</th>
                        <th>Date de sortie</th>
                        <th>Écouter</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
        
        while ($titre = $result_titres->fetch_assoc()) {
            echo '<tr>
                    <td>' . htmlspecialchars($titre['Nom']) . '</td>
                    <td>' . (isset($titre['nom_album']) ? htmlspecialchars($titre['nom_album']) : 'Single') . '</td>
                    <td>' . htmlspecialchars($titre['Genre']) . '</td>
                    <td>' . htmlspecialchars($titre['Date_de_sortie']) . '</td>
                    <td>
                        <audio controls>
                            <source src="' . htmlspecialchars($titre['chemin_fichier']) . '" type="audio/mpeg">
                            Votre navigateur ne supporte pas la lecture audio.
                        </audio>
                    </td>
                    <td>
                        <form action="../50_config/supp_mus.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce titre ?\');">
                            <input type="hidden" name="titre_id" value="' . $titre['Id_titre'] . '">
                            <button type="submit" class="btn-supprimer">Supprimer</button>
                        </form>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<p>Vous n\'avez pas encore importé de titres.</p>';
    }
    
    $stmt_titres->close();
    ?>
    </div>
</section>



    <?php
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté ou pas artiste
            header("Location: ../10_site/08_connexion.php");
            exit();
        }

        require "../20_includes/footer.php";
    ?>

<?php
// Afficher les messages concernant l'import/suppression de musique
if (isset($_SESSION['import_success'])) {
    echo "<p class='success-message'>" . $_SESSION['import_success'] . "</p>";
    unset($_SESSION['import_success']);
}
if (isset($_SESSION['import_error'])) {
    echo "<p class='error-message'>" . $_SESSION['import_error'] . "</p>";
    unset($_SESSION['import_error']);
}
if (isset($_SESSION['delete_success'])) {
    echo "<p class='success-message'>" . $_SESSION['delete_success'] . "</p>";
    unset($_SESSION['delete_success']);
}
if (isset($_SESSION['delete_error'])) {
    echo "<p class='error-message'>" . $_SESSION['delete_error'] . "</p>";
    unset($_SESSION['delete_error']);
}
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