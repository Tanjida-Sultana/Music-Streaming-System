<?php
require_once 'db.php';

$playlist_id = intval($_GET['id'] ?? 0);

// If no playlist ID is provided in the URL, redirect back to the playlists page
if ($playlist_id <= 0) {
    header("Location: playlists.php");
    exit();
}

// Fetch playlist details
$plStmt = $pdo->prepare("SELECT * FROM playlists WHERE playlist_id = ?");
$plStmt->execute([$playlist_id]);
$playlist = $plStmt->fetch(PDO::FETCH_ASSOC);

if (!$playlist) {
    die("Playlist not found.");
}

// Handle adding a song to this playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_song_id'])) {
    $song_id = intval($_POST['add_song_id']);
    try {
        $ins =$pdo->prepare("INSERT IGNORE INTO PLAYLISTS_SONGS (playlist_id, song_id) VALUES (?, ?)");
        $ins->execute([$playlist_id,$song_id]);
    } catch (Exception $e) {
        // Handle duplicate gracefully
    }
    header("Location: view_playlist.php?id=$playlist_id");
    exit();
}

// Fetch songs in this playlist along with Album, Artist, and Song name
$songsStmt =$pdo->prepare("
    SELECT s.song_id, s.title AS song_title, s.duration, 
           COALESCE(a.name, 'Unknown Artist') AS artist_name,
           COALESCE(al.title, 'Unknown Album') AS album_title
    FROM PLAYLISTS_SONGS ps
    JOIN songs s ON ps.song_id = s.song_id
    LEFT JOIN artists a ON s.artist_id = a.artist_id
    LEFT JOIN albums al ON a.artist_id = al.artist_id
    WHERE ps.playlist_id = ?
");
$songsStmt->execute([$playlist_id]);
$playlistSongs =$songsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all available songs for the "Add to playlist" dropdown
$allSongs =$pdo->query("SELECT song_id, title FROM songs ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($playlist['title']) ?> - Playlist</title>
    <link rel="stylesheet" href="assets/asset_style.css">
    <style>
        .player-bar {
            background: #181818;
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }
        .player-controls button {
            background: #333;
            color: white;
            margin: 0 5px;
            padding: 8px 14px;
        }
        .player-controls button.active-mode {
            background: var(--accent-color);
        }
    </style>
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php" class="active">Playlists</a>
            <a href="add_song.php">Add Song / Artist</a>
        </nav>
    </header>

    <div class="container">
        <h2>📁 Playlist: <?= htmlspecialchars($playlist['title']) ?></h2>
        <br>

        <!-- Interactive Music Player Widget -->
        <div class="player-bar">
            <h4 id="now-playing" style="margin-bottom: 8px; color: var(--accent-color);">Select a song to start player</h4>
            <p id="player-details" style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 15px;">Album: - | Artist: -</p>
            
            <div class="player-controls">
                <button onclick="togglePlay()">⏯ Play / Pause</button>
                <button onclick="prevSong()">⏮ Prev</button>
                <button onclick="nextSong()">⏭ Next</button>
                <button id="shuffle-btn" onclick="toggleShuffle()">🔀 Shuffle</button>
                <button id="loop-btn" onclick="toggleLoop()">🔁 Loop Playlist</button>
            </div>
        </div>

        <!-- Add Song to Playlist Form -->
        <div class="form-card" style="margin-bottom: 30px;">
            <h3>Add Song to this Playlist</h3>
            <form action="view_playlist.php?id=<?= $playlist_id ?>" method="POST" style="display: flex; gap: 15px; margin-top: 15px; flex-wrap: wrap;">
                <select name="add_song_id" style="flex: 1; padding: 12px; background: #2a2a2a; color: white; border: 1px solid var(--border-color); border-radius: 6px;" required>
                    <option value="">Select a song from library...</option>
                    <?php foreach ($allSongs as$s): ?>
                        <option value="<?= $s['song_id'] ?>"><?= htmlspecialchars($s['title']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Add to Playlist</button>
            </form>
        </div>

        <!-- Songs in Playlist Table -->
        <h3>Songs in Playlist</h3>
        <?php if (empty($playlistSongs)): ?>
            <p style="margin-top: 15px; color: var(--text-secondary);">This playlist is empty.</p>
        <?php else: ?>
            <table id="playlist-table">
                <thead>
                    <tr>
                        <th>Song Title</th>
                        <th>Album</th>
                        <th>Artist</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($playlistSongs as $index =>$song): ?>
                    <tr data-index="<?= $index ?>" data-title="<?= htmlspecialchars($song['song_title']) ?>" data-album="<?= htmlspecialchars($song['album_title']) ?>" data-artist="<?= htmlspecialchars($song['artist_name']) ?>">
                        <td><?= htmlspecialchars($song['song_title']) ?></td>
                        <td><?= htmlspecialchars($song['album_title']) ?></td>
                        <td><?= htmlspecialchars($song['artist_name']) ?></td>
                        <td><?= htmlspecialchars($song['duration']) ?></td>
                        <td>
                            <button onclick="playSong(<?= $index ?>)" style="padding: 6px 14px; font-size: 0.85rem; background: var(--accent-color);">▶ Play</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <a href="playlists.php" style="color: var(--accent-color); text-decoration: none;">&larr; Back to Playlists</a>
    </div>

    <script>
        const songs = [
            <?php foreach ($playlistSongs as$song): ?>
            {
                title: "<?= addslashes($song['song_title']) ?>",
                album: "<?= addslashes($song['album_title']) ?>",
                artist: "<?= addslashes($song['artist_name']) ?>"
            },
            <?php endforeach; ?>
        ];

        let currentIndex = 0;
        let isPlaying = false;
        let isShuffle = false;
        let loopMode = 0; // 0: No loop, 1: Loop playlist, 2: Loop current song

        function playSong(index) {
            if (songs.length === 0) return;
            currentIndex = index;
            isPlaying = true;
            updatePlayerUI();
        }

        function togglePlay() {
            if (songs.length === 0) return;
            isPlaying = !isPlaying;
            updatePlayerUI();
        }

        function nextSong() {
            if (songs.length === 0) return;
            if (isShuffle) {
                currentIndex = Math.floor(Math.random() * songs.length);
            } else {
                currentIndex++;
                if (currentIndex >= songs.length) {
                    if (loopMode === 1) {
                        currentIndex = 0; // Loop playlist
                    } else {
                        currentIndex = songs.length - 1;
                        isPlaying = false;
                    }
                }
            }
            updatePlayerUI();
        }

        function prevSong() {
            if (songs.length === 0) return;
            currentIndex--;
            if (currentIndex < 0) currentIndex = 0;
            updatePlayerUI();
        }

        function toggleShuffle() {
            isShuffle = !isShuffle;
            document.getElementById('shuffle-btn').classList.toggle('active-mode', isShuffle);
        }

        function toggleLoop() {
            loopMode = (loopMode + 1) % 3;
            const btn = document.getElementById('loop-btn');
            if (loopMode === 0) {
                btn.innerText = "🔁 Loop Off";
                btn.classList.remove('active-mode');
            } else if (loopMode === 1) {
                btn.innerText = "🔁 Loop Playlist";
                btn.classList.add('active-mode');
            } else {
                btn.innerText = "🔂 Loop Song";
                btn.classList.add('active-mode');
            }
        }

        function updatePlayerUI() {
            if (songs.length === 0) return;
            const current = songs[currentIndex];
            document.getElementById('now-playing').innerText = (isPlaying ? "Playing: " : "Paused: ") + current.title;
            document.getElementById('player-details').innerText = `Album: ${current.album} | Artist: ${current.artist}`;
        }
    </script>
</body>
</html>