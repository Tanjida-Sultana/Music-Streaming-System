<?php
require_once 'db.php';

// Ensure user is logged in before accessing playlists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$user_id = $_SESSION['user_id'];

// Handle Playlist Creation linked to current user session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_playlist'])) {
    $title = trim($_POST['playlist_title']);

    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO playlists (title, user_id) VALUES (?, ?)");
        $stmt->execute([$title, $user_id]);
        $message = "Playlist created successfully!";
    } else {
        $message = "Playlist title cannot be empty.";
    }
}

// Fetch all playlists
$playlists = $pdo->query("
    SELECT p.playlist_id, p.title, u.username, COUNT(ps.song_id) AS song_count 
    FROM playlists p 
    LEFT JOIN users u ON p.user_id = u.user_id 
    LEFT JOIN PLAYLISTS_SONGS ps ON p.playlist_id = ps.playlist_id 
    GROUP BY p.playlist_id, p.title, u.username
    ORDER BY p.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playlists</title>
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="history.php">History</a>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php" class="active">Playlists</a>
            <a href="add_song.php">Add Song / Artist</a>
            <span style="color: var(--accent-color); margin-left: 15px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h2>Your Playlists</h2>

        <?php if (!empty($message)): ?>
            <div class="alert" style="margin-top: 15px;"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Create Playlist Form -->
        <div class="form-card" style="margin-top: 20px; margin-bottom: 30px;">
            <h3>Create New Playlist</h3>
            <form action="playlists.php" method="POST" style="margin-top: 15px;">
                <div class="form-group">
                    <label>Playlist Name</label>
                    <input type="text" name="playlist_title" placeholder="e.g. Workout Beats" required>
                </div>
                <button type="submit" name="create_playlist">Create Playlist</button>
            </form>
        </div>

        <!-- Playlist List Table -->
        <h3>Existing Playlists</h3>
        <?php if (empty($playlists)): ?>
            <p style="margin-top: 15px; color: var(--text-secondary);">No playlists found.</p>
        <?php else: ?>
            <table style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>Playlist Title</th>
                        <th>Created By</th>
                        <th>Total Songs</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($playlists as $pl): ?>
                    <tr>
                        <td><?= htmlspecialchars($pl['title']) ?></td>
                        <td><?= htmlspecialchars($pl['username'] ?? 'Unknown') ?></td>
                        <td><?= $pl['song_count'] ?> songs</td>
                        <td>
                            <a href="view_playlist.php?id=<?= $pl['playlist_id'] ?>" style="color: var(--accent-color); text-decoration: none; font-weight: bold;">Open Playlist &rarr;</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>