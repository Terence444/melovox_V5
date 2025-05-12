<?php 
require "../20_includes/header.php";

// Connexion à la base de données
require_once "../30_config/db_connect.php";

// Récupérer l'ID de l'album/EP/single depuis l'URL
$album_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Récupérer les informations de l'album/EP/single
$album_query = "SELECT a.*, art.name as artist_name, art.profile_picture, 
                COUNT(t.id) as track_count, 
                SUM(t.duration) as total_duration 
                FROM albums a 
                JOIN artists art ON a.artist_id = art.id 
                LEFT JOIN tracks t ON t.album_id = a.id 
                WHERE a.id = ?
                GROUP BY a.id";
                
$stmt = $conn->prepare($album_query);
$stmt->bind_param("i", $album_id);
$stmt->execute();
$album_result = $stmt->get_result();
$album = $album_result->fetch_assoc();

// Récupérer la liste des pistes de l'album
$tracks_query = "SELECT * FROM tracks WHERE album_id = ? ORDER BY track_number";
$stmt = $conn->prepare($tracks_query);
$stmt->bind_param("i", $album_id);
$stmt->execute();
$tracks_result = $stmt->get_result();

// Formater la durée totale en minutes et secondes
$total_minutes = floor($album['total_duration'] / 60);
$total_seconds = $album['total_duration'] % 60;
$formatted_duration = $total_minutes . "min " . $total_seconds . "s";
?>

<section id="album_ep_single_info">
    <h1><?php echo htmlspecialchars($album['title']); ?></h1>
    <div id="album_info">
        <img id="cover" src="<?php echo !empty($album['cover_image']) ? htmlspecialchars($album['cover_image']) : '../60_visuels/icon/icone_playlist.png'; ?>" 
             alt="Couverture de <?php echo htmlspecialchars($album['title']); ?>">
        <div id="artist_name">
            <a href="../10_site/12_artist_profile.php?id=<?php echo $album['artist_id']; ?>">
                <img id="artist_icon" src="<?php echo !empty($album['profile_picture']) ? htmlspecialchars($album['profile_picture']) : '../60_visuels/icon/users icons/alexia.png'; ?>" 
                     alt="Photo de <?php echo htmlspecialchars($album['artist_name']); ?>">
            </a>
            <h6><?php echo htmlspecialchars($album['artist_name']); ?></h6>
        </div>
        <p><?php echo htmlspecialchars($album['release_year']); ?></p>
        <p><?php echo $album['track_count']; ?> titres</p>
        <p><?php echo $formatted_duration; ?></p>
    </div>

    <div id="button_icons">
        <button id="shuffle" class="big_buttons" onclick="shufflePlaylist()">
            <i class="fa fa-random"></i>
        </button>

        <button id="previous" class="small_buttons" onclick="playPrevious()">
            <i class="fa fa-step-backward"></i>
        </button>

        <button id="play" class="big_buttons" onclick="togglePlay()">
            <i class="fa fa-play" id="playPauseIcon"></i>
        </button>
        
        <button id="skip" class="small_buttons" onclick="playNext()">
            <i class="fa fa-step-forward"></i>
        </button>
        
        <button id="plus" class="small_buttons" onclick="showOptions()">
            <i class="fa fa-ellipsis-h"></i>
        </button>
    </div>

</section>

<section id="tracklist">
    <div class="tracklist">
        <ol>
            <?php 
            // Variables pour stocker les données des pistes pour JavaScript
            $tracks_data = [];
            
            while ($track = $tracks_result->fetch_assoc()) {
                // Formater la durée de la piste
                $track_minutes = floor($track['duration'] / 60);
                $track_seconds = $track['duration'] % 60;
                $track_formatted_duration = sprintf("%d:%02d", $track_minutes, $track_seconds);
                
                // Ajouter les données de la piste au tableau JavaScript
                $tracks_data[] = [
                    'id' => $track['id'],
                    'title' => $track['title'],
                    'audioPath' => $track['audio_path'],
                    'duration' => $track['duration']
                ];
            ?>
                <li data-track-id="<?php echo $track['id']; ?>" onclick="playTrack(<?php echo $track['id']; ?>)">
                    <span class="not-playing fa fa-play" id="play-icon-<?php echo $track['id']; ?>"></span>
                    <span class="track-number"><?php echo $track['track_number']; ?></span>
                    <span class="track-name"><?php echo htmlspecialchars($track['title']); ?></span>
                    <span class="track-duration"><?php echo $track_formatted_duration; ?></span>
                </li>
            <?php 
            } 
            ?>
        </ol>
    </div>
</section>

<!-- Ajouter un lecteur audio caché -->
<audio id="audioPlayer"></audio>

<script>
// Stockage des informations des pistes
const tracks = <?php echo json_encode($tracks_data); ?>;
let currentTrackIndex = -1;
let isPlaying = false;
const audioPlayer = document.getElementById('audioPlayer');

// Fonction pour jouer une piste spécifique
function playTrack(trackId) {
    // Trouver l'index de la piste
    const index = tracks.findIndex(track => track.id === trackId);
    if (index !== -1) {
        // Réinitialiser les icônes
        document.querySelectorAll('.playing').forEach(icon => {
            icon.classList.remove('playing');
            icon.classList.add('not-playing');
        });
        
        // Mettre à jour l'index actuel
        currentTrackIndex = index;
        
        // Mettre à jour l'icône de la piste actuelle
        const playIcon = document.getElementById(`play-icon-${trackId}`);
        playIcon.classList.remove('not-playing');
        playIcon.classList.add('playing');
        
        // Charger et jouer l'audio
        audioPlayer.src = tracks[currentTrackIndex].audioPath;
        audioPlayer.play();
        isPlaying = true;
        
        // Mettre à jour l'icône du bouton play/pause principal
        document.getElementById('playPauseIcon').classList.remove('fa-play');
        document.getElementById('playPauseIcon').classList.add('fa-pause');
    }
}

// Fonction pour basculer entre lecture et pause
function togglePlay() {
    if (currentTrackIndex === -1 && tracks.length > 0) {
        // Si aucune piste n'est active, jouer la première
        playTrack(tracks[0].id);
    } else if (isPlaying) {
        // Mettre en pause
        audioPlayer.pause();
        isPlaying = false;
        document.getElementById('playPauseIcon').classList.remove('fa-pause');
        document.getElementById('playPauseIcon').classList.add('fa-play');
    } else {
        // Reprendre la lecture
        audioPlayer.play();
        isPlaying = true;
        document.getElementById('playPauseIcon').classList.remove('fa-play');
        document.getElementById('playPauseIcon').classList.add('fa-pause');
    }
}

// Fonction pour passer à la piste suivante
function playNext() {
    if (tracks.length > 0) {
        const nextIndex = (currentTrackIndex + 1) % tracks.length;
        playTrack(tracks[nextIndex].id);
    }
}

// Fonction pour passer à la piste précédente
function playPrevious() {
    if (tracks.length > 0) {
        const prevIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
        playTrack(tracks[prevIndex].id);
    }
}

// Fonction pour mélanger la playlist
function shufflePlaylist() {
    if (tracks.length > 0) {
        // Choisir une piste aléatoire
        const randomIndex = Math.floor(Math.random() * tracks.length);
        playTrack(tracks[randomIndex].id);
    }
}

// Fonction pour afficher les options supplémentaires
function showOptions() {
    // Cette fonction pourrait ouvrir un menu avec des options comme 
    // "Ajouter à une playlist", "Télécharger", etc.
    alert("Options supplémentaires (à implémenter)");
}

// Gérer la fin d'une piste (passer à la suivante)
audioPlayer.addEventListener('ended', playNext);
</script>

<?php require "../20_includes/footer.php"; ?>