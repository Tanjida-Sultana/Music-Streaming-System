<?php
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $songTitle = trim($_POST['song_title']);
    $duration = trim($_POST['duration']);
    $genre = trim($_POST['genre']);

    $artistName = trim($_POST['artist_name']);
    $artistAge = trim($_POST['artist_age']);
    $artistBio = trim($_POST['artist_bio']);

    try {
        $pdo->beginTransaction();

        $artist_id = null;

        // Check if user provided artist info
        if (!empty($artistName)) {
            // Check if artist already exists
            $stmt = $pdo->prepare("SELECT artist_id FROM artists WHERE name = ?");
            $stmt->execute([$artistName]);
            $artist = $stmt->fetch();

            if ($artist) {
                $artist_id = $artist['artist_id'];
            } else {
                // Insert new artist
                $stmt = $pdo->prepare("INSERT INTO artists (name, age, bio) VALUES (?, ?, ?)");
                $stmt->execute([$artistName, !empty($artistAge) ? $artistAge : 0, !empty($artistBio) ? $artistBio : 'No bio provided']);
                $artist_id = $pdo->lastInsertId();
            }
        } else {
            // Fallback to "Unknown Artist" category as specified
            $stmt = $pdo->prepare("SELECT artist_id FROM artists WHERE name = 'Unknown Artist'");
            $stmt->execute();
            $artist = $stmt->fetch();

            if ($artist) {
                $artist_id = $artist['artist_id'];
            } else {
                // Create 'Unknown Artist' if it doesn't exist yet in the DB
                $stmt = $pdo->prepare("INSERT INTO artists (name, age, bio) VALUES ('Unknown Artist', 0, 'Default category for unknown artists')");
                $stmt->execute();
                $artist_id = $pdo->lastInsertId();
            }
        }

        // Insert Song
        $stmt = $pdo->prepare("INSERT INTO songs (title, duration, genre, play_count, artist_id) VALUES (?, ?, ?, 0, ?)");
        $stmt->execute([$songTitle, $duration, $genre, $artist_id]);

        $pdo->commit();
        $message = "Song successfully added to the library!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Error adding song: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Song & Artist</title>
    <!-- Updated CSS Link -->
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="library.php">Library</a>
            <a href="index.php">Home</a>
            <a href="add_song.php" class="active">Add Song / Artist</a>
        </nav>
    </header>

    <div class="container" style="max-width: 600px;">
        <div class="form-card">
            <h2>Add New Song</h2>
            <?php if (!empty($message)): ?>
                <div class="alert"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="add_song.php" method="POST">
                <div class="section-title">1. Artist Information (Optional)</div>
                <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 15px;">Leave blank to automatically assign this song to the "Unknown Artist" category.</p>
                
                <div class="form-group">
                    <label>Artist Name</label>
                    <input type="text" name="artist_name" placeholder="e.g. Taylor Swift">
                </div>
                <div class="form-group">
                    <label>Artist Age</label>
                    <input type="number" name="artist_age" placeholder="e.g. 34">
                </div>
                <div class="form-group">
                    <label>Artist Bio</label>
                    <input type="text" name="artist_bio" placeholder="Short biography...">
                </div>

                <div class="section-title">2. Song Information</div>
                <div class="form-group">
                    <label>Song Title *</label>
                    <input type="text" name="song_title" placeholder="e.g. Anti-Hero" required>
                </div>
                <div class="form-group">
                    <label>Duration (HH:MM:SS) *</label>
                    <input type="text" name="duration" placeholder="00:03:20" required>
                </div>
                <div class="form-group">
                    <label>Genre / Song Tag *</label>
                    <input type="text" name="genre" placeholder="e.g. Pop, EDM" required>
                </div>

                <button type="submit" style="width: 100%; margin-top: 10px;">Save Song</button>
            </form>
        </div>
    </div>
</body>
</html>