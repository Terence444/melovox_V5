<?php require "../20_includes/header.php"; ?>

<main>
    <div id="search_area">
        <span class="material-symbols-outlined">search</span>

        <form action="50_config/search_results.php" method="GET">
            <input type="text" name="query" placeholder="Tapez votre recherche...">
            <button type="submit">Rechercher</button>
       
    </div>

            <div id="filters">
                <div>
                    <input type="checkbox" name="Artiste" id="Artiste">
                    <label class="text_filters" for="Artiste"> Artiste</label>
                </div>

                <div>
                    <input type="checkbox" name="Titre" id="Titre">
                    <label class="text_filters" for="Titre">Titre</label>
                </div>

                <div>
                    <input type="checkbox" name="Albums" id="Albums">
                    <label class="text_filters" for="Albums">Albums</label>
                </div>

                <div>
                    <input type="checkbox" name="Playlist" id="Playlist">
                    <label class="text_filters" for="Playlist">Playlist</label>
                </div>
            </div>
        </form>
    

    <div id="zone_result">
        <h3>Résultats de votre recherche</h3>
        <div id="result_search"></div>
    </div>
</main>


<?php require "../20_includes/footer.php"; ?>