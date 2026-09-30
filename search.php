<?php
require_once 'db.php';

$query = trim($_GET['query'] ?? '');
$tag = $_GET['tag'] ?? 'song';
$results = [];

if ($query !== '') {
    if ($tag === 'song') {
        // Search by song title, but also check if they typed an artist name by accident
        $stmt = $pdo->prepare("SELECT s.title, s.duration, s.genre, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
                               FROM songs s LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE s.title LIKE ? OR a.name LIKE ?");
        $stmt->execute(["%$query%", "%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($tag === 'artist') {
        $stmt = $pdo->prepare("SELECT s.title, s.duration, s.genre, s.play_count, a.name AS artist_name 
                               FROM songs s JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE a.name LIKE ?");
        $stmt->execute(["%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($tag === 'album') {
        $stmt = $pdo->prepare("SELECT s.title, s.duration, s.genre, s.play_count, a.name AS artist_name 
                               FROM songs s 
                               JOIN albums al ON s.artist_id = al.artist_id 
                               LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE al.title LIKE ?");
        $stmt->execute(["%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($tag === 'tag') {
        $stmt = $pdo->prepare("SELECT s.title, s.duration, s.genre, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
                               FROM songs s LEFT JOIN artists a ON s.artist_id = a.artist_id 
                               WHERE s.genre LIKE ?");
        $stmt->execute(["%$query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <!-- Updated CSS Link -->
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="library.php">Library</a>
            <a href="index.php">Home</a>
            <a href="add_song.php">Add Song / Artist</a>
        </nav>
    </header>

    <div class="container">
        <h2>Search Results for "<?= htmlspecialchars($query) ?>" in [<?= htmlspecialchars(ucfirst($tag)) ?>]</h2>
        
        <?php if (empty($results)): ?>
            <p style="margin-top: 20px; color: var(--text-secondary);">No matches found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Song Title</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Plays</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['artist_name']) ?></td>
                        <td><?= htmlspecialchars($row['genre']) ?></td>
                        <td><?= htmlspecialchars($row['duration']) ?></td>
                        <td><?= number_format($row['play_count']) ?></td>
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