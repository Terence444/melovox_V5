<?php require "20_includes\header.php"; ?>

<!-- /* --------- Section 1-------- */ -->
<div id="category_button">
    <h2>Catégorie</h2>
    <div id="buttons">
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Pop</button></a>
        <a href="10_site\04_category.php"><button onclick="selectCategory('Rock')"class="Categorie" type="button">Rock</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Hip-hop</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Jazz</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Classique</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Blues</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Reggae</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Country</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Electro</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">R&B</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Funk</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Soul</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Metal</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Punk</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Folk</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Disco</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Ska</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">House</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Lo-fi</button></a>
        <a href="10_site\04_category.php"><button class="Categorie" type="button">Ambient</button></a>
    </div>
</div>
<!-- /* --------- Section 2-------- */ -->
<div id="all_artist">
    <h2>Artistes</h2>
    <div id="artist_area">
        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\alexia.png" alt=""><a href="artist_profile.php"> Alexia </a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\DJ_alfonso.png" alt=""><a href="10_site\12_artist_profile.php">DJ Alfonso</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Catalia.png" alt=""><a href="10_site\12_artist_profile.php">Catalia</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\charles.png" alt=""><a href="10_site\12_artist_profile.php">Charles</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\drew.png" alt=""><a href="10_site\12_artist_profile.php">Drew</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Eleana.png" alt=""><a href="10_site\12_artist_profile.php">Eleana</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\gabriel.png" alt=""><a href="10_site\12_artist_profile.php">Gabriel</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Kévin.png" alt=""><a href="10_site\12_artist_profile.php">Kévin</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\lil_jordan.png" alt=""><a href="10_site\12_artist_profile.php">LiL Jordan</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\lisa.png" alt=""><a href="10_site\12_artist_profile.php">Lisa</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Lorde.png" alt=""><a href="10_site\12_artist_profile.php">Lorde</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\lucie.png" alt=""><a href="10_site\12_artist_profile.php">Lucie</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Marc.png" alt=""><a href="10_site\12_artist_profile.php">Marc</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Orisa.png" alt=""><a href="10_site\12_artist_profile.php">Orisa</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\Sade.png" alt=""><a href="10_site\12_artist_profile.php">Sade</a>
        </div>

        <div id="artist_icon">
            <img src="60_visuels\icon\users icons\sandy.png" alt=""><a href="10_site\12_artist_profile.php">Sandy</a>
        </div>
    </div>
</div>
<script>
    function selectCategory(category) {
      // Stocker le nom de la catégorie dans sessionStorage
      sessionStorage.setItem('selectedCategory', category);
      
      // Rediriger vers la page suivante
      window.location.href = '10_site/04_category.php';
    }
  </script>

<?php require "20_includes/footer.php"; ?>