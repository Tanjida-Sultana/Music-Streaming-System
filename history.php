<?php
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch streaming history for the logged-in user
$stmt = $pdo->prepare("
    SELECT s.title AS song_title, COALESCE(a.name, 'Unknown Artist') AS artist_name, sh.played_at 
    FROM streaming_history sh
    JOIN songs s ON sh.song_id = s.song_id
    LEFT JOIN artists a ON s.artist_id = a.artist_id
    WHERE sh.user_id = ?
    ORDER BY sh.played_at DESC
");
$stmt->execute([$user_id]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Streaming History</title>
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php">Playlists</a>
            <a href="history.php" class="active">History</a>
            <a href="add_song.php">Add Song / Artist</a>
            <span style="color: var(--accent-color); margin-left: 15px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Your Streaming History</h2>
        
        <?php if (empty($history)): ?>
            <p style="margin-top: 20px; color: var(--text-secondary);">No streaming history found yet. Play some songs from the library!</p>
        <?php else: ?>
            <table style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Song Title</th>
                        <th>Artist</th>
                        <th>Played At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['song_title']) ?></td>
                        <td><?= htmlspecialchars($item['artist_name']) ?></td>
                        <td><?= htmlspecialchars($item['played_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <a href="library.php" style="color: var(--accent-color); text-decoration: none;">&larr; Back to Library</a>
    </div>
</body>
</html>