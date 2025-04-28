<?php require "../20_includes/header.php"; ?>


<style>
        .message {
            font-size: 1em;
            margin: 10px 0;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
</style>    

<h3>♫ Laissez un nous message ! ♫</h3>

<section>

    <div id="image_area">
        <img id="image" src="../60_visuels/illustrations/Crowd_concert.jpg" alt="">
    </div>
    <span class="vertical_line"></span>

    <div id="contact_form">


        <div id="instructions">
            <h3>Contactez-nous!</h3>
            <p>Veuillez renseigner les champs suivants pour nous adresser votre message.</p>
        </div>


        
        <?php
            if (isset($_SESSION['contact_success'])) {
                echo '<p class="message success">' . $_SESSION['contact_success'] . '</p>';
                unset($_SESSION['contact_success']);
            }

            if (isset($_SESSION['contact_error'])) {
                echo '<p class="message error">' . $_SESSION['contact_error'] . '</p>';
                unset($_SESSION['contact_error']);
            }
        ?>

        <form onsubmit="return validateForm()" method="post" action="../50_config/config_contact.php">
                <div id="name_area">
                    <input type="text" id="name" name="name" placeholder="Votre nom" required>
                </div>

                <div id="first_name_area">
                    <input type="text" id="first_name" name="first_name" placeholder="Votre prénom" required>
                </div>

                <div id="email_area">
                    <input type="email" id="email" name="email" placeholder="Votre email" required>
                </div>

                <div id="user_type_area">
                    <legend id="question2">Êtes-vous artiste?</legend>
                    <div id="answers2">
                        <div>
                            <input type="radio" name="artist" id="artist_yes" value="oui" required>
                            <label for="artist_yes">Oui</label>
                        </div>
                        <div>
                            <input type="radio" name="artist" id="artist_no" value="non">
                            <label for="artist_no">Non</label>
                        </div>
                    </div>
                </div>

                    <textarea id="message" name="message" placeholder="Votre message" rows="25" required></textarea>

                <div id="submit_area">
                    <button type="submit">Envoyer</button>
                </div>
        </form>


        <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var message = document.getElementById('message').value;

            if (name === "" || email === "" || message === "") {
                alert("Tous les champs doivent être remplis!");
                return false;
            }

            return true;
        }
        </script>
    </div>
</section>

<?php require "../20_includes/footer.php"; ?>