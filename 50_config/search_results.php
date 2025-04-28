<?php
require "../20_includes/header.php";
require "../70_database/connex_bdd.php"; // Fichier de connexion à votre BDD

// Récupération des paramètres
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';
$filtre_artiste = isset($_GET['Artiste']) ? true : false;
$filtre_titre = isset($_GET['Titre']) ? true : false;
$filtre_albums = isset($_GET['Albums']) ? true : false;
$filtre_playlist = isset($_GET['Playlist']) ? true : false;

// Si aucun filtre n'est sélectionné, on active tous les filtres
if (!$filtre_artiste && !$filtre_titre && !$filtre_albums && !$filtre_playlist) {
    $filtre_artiste = $filtre_titre = $filtre_albums = $filtre_playlist = true;
}

// Construction de la requête SQL
$sql_parts = [];
$params = [];

if ($query) {
    // Recherche d'artistes
    if ($filtre_artiste) {
        $sql_parts[] = "SELECT 'artiste' as type, id, nom as titre, photo as image FROM artistes WHERE nom LIKE ?";
        $params[] = "%$query%";
    }
    
    // Recherche de titres
    if ($filtre_titre) {
        $sql_parts[] = "SELECT 'titre' as type, id, titre, image FROM morceaux WHERE titre LIKE ?";
        $params[] = "%$query%";
    }
    
    // Recherche d'albums
    if ($filtre_albums) {
        $sql_parts[] = "SELECT 'album' as type, id, titre, image_pochette as image FROM albums WHERE titre LIKE ?";
        $params[] = "%$query%";
    }
    
    // Recherche de playlists
    if ($filtre_playlist) {
        $sql_parts[] = "SELECT 'playlist' as type, id, nom as titre, image FROM playlists WHERE nom LIKE ?";
        $params[] = "%$query%";
    }
    
    // Fusion des requêtes avec UNION
    $sql = implode(" UNION ", $sql_parts) . " ORDER BY titre";
    
    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($sql);
    $i = 1;
    foreach ($params as $param) {
        $stmt->bindValue($i++, $param);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main>
    <div id="search_area">
        <span class="material-symbols-outlined">search</span>
        <form action="search_results.php" method="GET">
            <input type="text" name="query" placeholder="Tapez votre recherche..." value="<?= $query ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <div id="filters">
        <div>
            <input type="checkbox" name="Artiste" id="Artiste" <?= $filtre_artiste ? 'checked' : '' ?>>
            <label class="text_filters" for="Artiste"> Artiste</label>
        </div>
        <!-- Répétez pour les autres filtres... -->
    </div>

    <div id="zone_result">
        <h3>Résultats pour "<?= $query ?>"</h3>
        <div id="result_search">
            <?php if (isset($results) && !empty($results)): ?>
                <?php foreach ($results as $result): ?>
                    <div class="result_item">
                        <img src="<?= $result['image'] ?>" alt="<?= $result['titre'] ?>">
                        <div class="result_info">
                            <h4><?= $result['titre'] ?></h4>
                            <p class="result_type"><?= ucfirst($result['type']) ?></p>
                            <a href="<?= $result['type'] ?>_detail.php?id=<?= $result['id'] ?>">Voir détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php elseif (isset($query) && !empty($query)): ?>
                <p>Aucun résultat trouvé pour "<?= $query ?>"</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require "../20_includes/footer.php"; ?>