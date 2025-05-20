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
            LEFT JOIN artistes a ON u.id = a.id  -- ou LEFT JOIN artistes a ON u.id = a.Id_Artiste
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
                <label for="titre">Nom du titre</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div>
                <label for="titre">Durée</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div>
                <label for="album">Type de discographie</label>
                <input type="radio" id="album" name="album" value="Album" required> Album
                <input type="radio" id="EP" name="EP" value="EP" required> EP
                <input type="radio" id="single" name="single" value="Single" required> Single
                <input type="text" id="intiule" name="intiule" required> Intitulé de la discographie   
            </div>
    
            <div>
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre">
            </div>
            <div>
                <label for="date_sortie">Date de sortie</label>
                <input type="date" id="date_sortie" name="date_sortie" required>
            <div>
                <label for="fichier_musique">Votre fichier</label>
                <input type="file" id="fichier_musique" name="fichier_musique" accept="audio/*" required>
            </div>
            <div>
                <input id="import_music_button" type="submit" value="Importer">
            </div>
        </form>
    </section>

<<<<<<< HEAD
    <section id="liste_musiques">
        <h2>Mes titres en ligne</h2>

        <div id="les_musiques">
            <?php
            // Récupérer la liste des titres de l'artiste
            $sql = "SELECT Id_titre, Nom, Duree, Genre, Date_de_sortie 
        FROM Titre 
        WHERE Artiste = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $utilisateur_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Vérifier s'il y a des titres
            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($titre = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($titre['Nom']) . "</strong> ";

                    // Récupérer l'album associé à ce titre (si disponible)
                    $album_info = "";
                    $sql_album = "SELECT a.Nom FROM Album a
                    INNER JOIN Titre t ON t.Album = a.Id_Album
                    WHERE t.Id_titre = ?";
                    $stmt_album = $conn->prepare($sql_album);
                    $stmt_album->bind_param("i", $titre['Id_titre']);
                    $stmt_album->execute();
                    $result_album = $stmt_album->get_result();
                    if ($result_album->num_rows > 0) {
                        $album = $result_album->fetch_assoc();
                        $album_info = $album['Nom'];
                    }
                    $stmt_album->close();

                    echo " <br>Album : " . htmlspecialchars($album_info);
                    echo " <br>Genre : " . htmlspecialchars($titre['Genre']);
                    echo " <br>Date de sortie : " . htmlspecialchars($titre['Date_de_sortie']);

                    // Vous n'avez pas de champ pour stocker le chemin du fichier audio dans la table Titre
                    // Si vous souhaitez ajouter cette fonctionnalité, il faudra modifier le schéma de la base de données

                    // Formulaire pour supprimer le titre
                    echo "<br>
        <form action='../50_config/supp_titre.php' method='post'>
            <input type='hidden' name='titre_id' value='" . htmlspecialchars($titre['Id_titre']) . "'>
            <input type='submit' value='Supprimer' style='background-color: #ff4d4d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;'>
        </form>";

                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Vous n'avez pas encore de titres enregistrés.</p>";
            }
            $stmt->close();
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
// Après l'ouverture de la session et avant d'afficher le contenu
=======
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
>>>>>>> 6c74a48d9479d6d4d249178c96503e99d8367c7b
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