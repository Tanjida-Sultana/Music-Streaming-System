<?php
require_once 'db.php';

// Handle Play Button Click (Increments play_count and logs streaming history)
if (isset($_POST['play_song_id'])) {
    $song_id = intval($_POST['play_song_id']);
    // Use logged-in user ID, defaulting to 1 if not logged in
    $user_id = $_SESSION['user_id'] ?? 1;

    // 1. Increment play count
    $updateStmt = $pdo->prepare("UPDATE songs SET play_count = play_count + 1 WHERE song_id = ?");
    $updateStmt->execute([$song_id]);
    
    // 2. Insert into streaming_history table
    $histStmt = $pdo->prepare("INSERT INTO streaming_history (user_id, song_id, played_at) VALUES (?, ?, NOW())");
    $histStmt->execute([$user_id, $song_id]);

    header("Location: library.php");
    exit();
}

// SQL Query to list all available songs
$stmt = $pdo->query("
    SELECT s.song_id, s.title AS song_title, s.duration, s.genre, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
    FROM songs s 
    LEFT JOIN artists a ON s.artist_id = a.artist_id 
    ORDER BY s.title ASC
");
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- Keep the rest of your library.php HTML layout as it was -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Library - All Songs</title>
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="history.php">History</a>
            <a href="index.php">Home</a>
            <a href="library.php" class="active">Library</a>
            <a href="add_song.php">Add Song / Artist</a>
        </nav>
    </header>

    <div class="container">
        <h2>All Available Songs</h2>
        
        <?php if (empty($songs)): ?>
            <p style="margin-top: 20px; color: var(--text-secondary);">No songs found in the library.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Song Title</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Plays</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($songs as $song): ?>
                    <tr>
                        <td><?= htmlspecialchars($song['song_title']) ?></td>
                        <td><?= htmlspecialchars($song['artist_name']) ?></td>
                        <td><?= htmlspecialchars($song['genre']) ?></td>
                        <td><?= htmlspecialchars($song['duration']) ?></td>
                        <td><?= number_format($song['play_count']) ?></td>
                        <td>
                            <form action="library.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="play_song_id" value="<?= $song['song_id'] ?>">
                                <button type="submit" style="padding: 6px 14px; font-size: 0.85rem; background: var(--accent-color);">▶ Play</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <a href="index.php" style="color: var(--accent-color); text-decoration: none;">&larr; Back to Home</a>
    </div>
</body>
</html>