<?php require "20_includes\header.php"; ?>

<?php
// Vérifier si une session est déjà active avant d'appeler session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Récupérer les messages d'erreur
$email_error = isset($_SESSION['email_error']) ? $_SESSION['email_error'] : '';
$pseudo_error = isset($_SESSION['pseudo_error']) ? $_SESSION['pseudo_error'] : '';
// Récupérer les données du formulaire précédemment saisies
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();
// Nettoyer les variables de session
unset($_SESSION['email_error'], $_SESSION['pseudo_error'], $_SESSION['form_data']);
?>


<h3>À votre tour de faire entendre votre voix ! 🎤</h3>
<section>

    <div id="image_area">
        <img id="image" src="60_visuels\illustrations\your_turn.jpg" alt="">
    </div>
    <span class="vertical_line"></span>

    <div id="contact_form">

        <div id="instructions">
            <h3>Créer votre compte</h3>
            <p>Veuillez renseigner les champs pour procéder à la création de votre espace personnel</p>
        </div>

        <form action="50_config\traitement_inscription.php" method="post" enctype="multipart/form-data" id="inscriptionForm">
            <div id="name_area">
                <label for="name">Nom</label>
                <input type="text" id="name" name="nom" required>
            </div>

            <div id="first_name_area">
                <label for="first_name">Prénom</label>
                <input type="text" id="first_name" name="prenom" required>
            </div>

            <div id="birthday_area">
                <label for="birthday">Date de naissance</label>
                <input type="date" name="date_naissance" id="birthday" required>
            </div>

            <div id="email_area">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <?php if ($email_error): ?>
                    <p class="error"><?php echo $email_error; ?></p>
                <?php endif; ?>
            </div>

            <div id="gender_area">
                <legend class="question">Sexe</legend>
                <div class="answers">
                    <div>
                        <input type="radio" name="sexe" id="male" value="homme" required>
                        <label for="male">Homme</label>
                    </div>
                    <div>
                        <input type="radio" name="sexe" id="female" value="femme">
                        <label for="female">Femme</label>
                    </div>
                    <div>
                        <input type="radio" name="sexe" id="no_answer" value="ne_pas_repondre">
                        <label for="no_answer">Je préfère ne pas répondre</label>
                    </div>
                </div>
            </div>

            <div id="user_type_area">
                <legend class="question">Êtes-vous artiste ?</legend>
                <div class="answers">
                    <div>
                        <input type="radio" name="est_artiste" id="yes_artist" value="1" required>
                        <label for="yes_artist">Oui</label>
                    </div>
                    <div>
                        <input type="radio" name="est_artiste" id="no_artist" value="0">
                        <label for="no_artist">Non</label>
                    </div>
                </div>
            </div>

            <div id="share_area">
                <legend class="question">Souhaitez-vous partager vos créations ?</legend>
                <div class="answers">
                    <div>
                        <input type="radio" name="partage_creations" id="yes_share" value="1" required>
                        <label for="yes_share">Oui</label>
                    </div>
                    <div>
                        <input type="radio" name="partage_creations" id="no_share" value="0">
                        <label for="no_share">Non</label>
                    </div>
                </div>
            </div>

            <div id="country_area">
                <label for="country">Pays</label>
                <input type="text" name="pays" id="country" required>
            </div>

            <div id="nickname_area">
                <label for="nickname">Nom d'utilisateur</label>
                <input type="text" name="pseudo" id="nickname" required>
                <?php if ($pseudo_error): ?>
                     <p class="error"><?php echo $pseudo_error; ?></p>
                <?php endif; ?>
            </div>

            <div id="password_area">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="mot_de_passe" minlength="8" required>
            </div>

            <div id="password_confirm_area">
                <label for="password_confirm">Confirmation du mot de passe</label>
                <input type="password" id="password_confirm" name="confirmation_mot_de_passe" minlength="8" required>
            </div>

            <div id="add_profile_photo">
                <label for="fileInput">Photo de profil:</label>
                <input type="file" id="fileInput" name="profilePhoto" accept="image/*" required>
            </div>

            <input id="sign_in" type="submit" value="S'inscrire">
        </form>
    </div>
</section>

<?php require "20_includes/footer.php"; ?>