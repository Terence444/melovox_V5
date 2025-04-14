<?php require ("20_includes\header.php"); ?>

<section id="presentation">
    <h2><span class="symbols">♫</span> Bienvenue sur MÉLOVOX <span class="symbols">♫</span></h2>

    <div id="gallery" class="zone_pres">
        <div class="icone_lien">
            <img src="60_visuels\icon\gallery_icon.png" alt="">
            <a href="10_site\03_gallery.php">Accéder à la Galerie</a>
        </div>
        <div class="texte_pres">
            <h3>Explorez la galerie</h3>
            <p>Plongez dans un univers musical riche et varié centré sur le partage et la découverte de morceau qui
                résonne avec passion et créativité. <br>Notre plateforme est dédiée à la diffusion de contenus musicaux
                qui célèbrent la diversité des genres et d’artistes indépendant du monde entier.</p> <br>
            <p>Rejoignez notre communauté de mélomanes et partagez vos découvertes et vos coups de cœur avec d'autres
                passionnés. Que vous soyez à la recherche de nouveaux sons ou que vous souhaitiez redécouvrir des
                classiques, notre galerie musicale est l'endroit idéal pour nourrir votre amour de la musique.</p>
        </div>
    </div>

    <div id="liste_aleatoire" class="zone_pres">
        <div class="icone_lien">
            <img src="60_visuels\icon\icone_playlist_aléatoire.png" alt="">
            <a href="">Laisser vous surprendre par le titre aléatoire du jour !</a>
        </div>
        <div class="texte_pres">
            <h3>Des Découvertes Inattendues.</h3>
            <p>Découvrez des playlists soigneusement sélectionnées, ainsi que de nombreux artistes émergents qui vous
                guideront dans votre exploration musicale. </p>
            <br>
            <p>Notre mission est de vous faire découvrir et mettre en avant des artistes et des sons qui ne manqueront
                pas de vous surprendre par leur créativité. Que vous soyez un passionné de rock, un amateur de pop, ou
                un explorateur de musiques du monde, nous avons ce qu'il vous faut!</p>
        </div>
    </div>
</section>

<section class="texte_pres" id="artiste_moment">
    <h2>🎤 Les artistes du moment 🎧</h2>
  

<!--------------------- SLIDER SANS ANIMATIONS --------------------->
    
    <!-- <div id="slide_artiste">
       <img class="arrow" src="visuel\icons\buttons_icons\Arrow_left_circle.png" alt="">
        <div class="photo_artiste">
            <a href="artist_profile.php"><img src="visuel\icons\users icons\alexia.png" alt=""></a>
            <a href="artist_profile.php">Alexia</a>
        </div>
        <div class="photo_artiste">
            <a href="artist_profile.php"><img src="visuel\icons\users icons\charles.png" alt=""></a>
            <a href="artist_profile.php">Charles</a>
        </div>
        <div class="photo_artiste">
            <a href="artist_profile.php"><img src="visuel\icons\users icons\Eleana.png" alt=""></a>
            <a href="artist_profile.php">Eleana</a>

        </div>

        <div class="photo_artiste">
            <a href="artist_profile.php"><img src="visuel\icons\users icons\Kévin.png" alt=""></a>
            <a href="artist_profile.php">Kévin</a>
        </div>
        <div class="photo_artiste">
            <a href="artist_profile.php"><img src="visuel\icons\users icons\Orisa.png" alt=""></a>
            <a href="artist_profile.php">Orisa</a>
        </div>
        <img class="arrow" src="visuel\icons\buttons_icons\Arrow_right_circle.png" alt="">
     </div>  -->

<!--------------------- Carrousel codepen --------------------->
    

<div class="container">
  <div class="carousel">
    <div class="a">
      <div class="item"><img src="60_visuels\icon\users icons\lil_jordan.png" alt=""></div>
    </div>
    <div class="b">
      <div class="item"><img src="60_visuels\icon\users icons\alexia.png" alt=""></div>
    </div>
    <div class="c">
      <div class="item"><img src="60_visuels\icon\users icons\Catalia.png" alt=""></div>
    </div>
    <div class="d">
      <div class="item"><img src="60_visuels\icon\users icons\charles.png" alt=""></div>
    </div>
    <div class="e">
      <div class="item"><img src="60_visuels\icon\users icons\DJ_alfonso.png" alt=""></div>
    </div>
    <div class="f">
      <div class="item"><img src="60_visuels\icon\users icons\Lorde.png" alt=""></div>
    </div>

  </div>
</div>
<div class="next">Next</div>
<div class="prev">Prev</div>


</section>

<section id="bg_a_propos">
    <div id="a_propos">
        <div>
            <h3>Rejoignez Notre Communauté</h3>
            <p>Ne faites pas que consommer de la musique, partagez-la ! Rejoignez notre communauté de mélomanes,
                échangez vos coups de cœur, et créez des playlists collaboratives avec vos amis.</p>
        </div>

        <div>
            <h3>Artistes : Partagez Votre Talent</h3>
            <p>Chez MÉLOVOX, nous offrons aux artistes une opportunité unique de faire entendre leur voix. Publiez vos
                morceaux, albums et playlists pour toucher un public large et diversifié. </p>
        </div>
        <div>
            <h3>Auditeurs : Plongez dans un Océan Musical</h3>
            <p>Nous vous proposons une bibliothèque musicale vaste et variée, couvrant tous les genres et styles.
                Explorez nos playlists thématiques, découvrez de nouveaux artistes et laissez-vous surprendre par des
                recommandations personnalisées. <br>Créez et partagez vos propres playlists pour immerger vos amis dans
                vos coups de cœur musicaux.</p>
        </div>
    </div>
</section>


  <!-- Inclusion du fichier JavaScript pour le slider splide -->
  <script src="40_scripts\carrousel.js"></script>

<?php require "20_includes/footer.php"; ?>