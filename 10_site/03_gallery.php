<?php require "../20_includes/header.php"; ?>

<!-- /* --------- Section 1-------- */ -->
<div id="category_button">
    <h2>Catégorie</h2>
    <div id="buttons">
        <button onclick="selectCategory('Pop')" class="Categorie" type="button">Pop</button>
        <button onclick="selectCategory('Rock')" class="Categorie" type="button">Rock</button>
        <button onclick="selectCategory('Hip-hop')" class="Categorie" type="button">Hip-hop</button>
        <button onclick="selectCategory('Jazz')" class="Categorie" type="button">Jazz</button>
        <button onclick="selectCategory('Classique')" class="Categorie" type="button">Classique</button>
        <button onclick="selectCategory('Blues')" class="Categorie" type="button">Blues</button>
        <button onclick="selectCategory('Reggae')" class="Categorie" type="button">Reggae</button>
        <button onclick="selectCategory('Country')" class="Categorie" type="button">Country</button>
        <button onclick="selectCategory('Electro')" class="Categorie" type="button">Electro</button>
        <button onclick="selectCategory('R&B')" class="Categorie" type="button">R&B</button>
        <button onclick="selectCategory('Funk')" class="Categorie" type="button">Funk</button>
        <button onclick="selectCategory('Soul')" class="Categorie" type="button">Soul</button>
        <button onclick="selectCategory('Metal')" class="Categorie" type="button">Metal</button>
        <button onclick="selectCategory('Punk')" class="Categorie" type="button">Punk</button>
        <button onclick="selectCategory('Folk')" class="Categorie" type="button">Folk</button>
        <button onclick="selectCategory('Disco')" class="Categorie" type="button">Disco</button>
        <button onclick="selectCategory('Ska')" class="Categorie" type="button">Ska</button>
        <button onclick="selectCategory('House')" class="Categorie" type="button">House</button>
        <button onclick="selectCategory('Lo-fi')" class="Categorie" type="button">Lo-fi</button>
        <button onclick="selectCategory('Ambient')" class="Categorie" type="button">Ambient</button>
    </div>
</div>
<!-- /* --------- Section 2-------- */ -->
<div id="all_artist">
    <h2>Artistes</h2>
    <div id="artist_area">
        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/alexia.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php"> Alexia </a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/DJ_alfonso.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">DJ Alfonso</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Catalia.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Catalia</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/charles.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Charles</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/drew.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Drew</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Eleana.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Eleana</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/gabriel.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Gabriel</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Kévin.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Kévin</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/lil_jordan.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">LiL Jordan</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/lisa.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Lisa</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Lorde.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Lorde</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/lucie.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Lucie</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Marc.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Marc</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Orisa.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Orisa</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/Sade.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Sade</a>
        </div>

        <div id="artist_icon">
            <img src="../60_visuels/icon/users icons/sandy.png" alt="Photo d'artiste"><a href="../10_site/12_artist_profile.php">Sandy</a>
        </div>
    </div>
</div>
<script>
    function selectCategory(category) {
      // Stocker le nom de la catégorie dans sessionStorage
      sessionStorage.setItem('selectedCategory', category);
      
      // Rediriger vers la page suivante
      window.location.href = '../10_site/04_category.php';
    }
</script>

<?php require "../20_includes/footer.php"; ?>