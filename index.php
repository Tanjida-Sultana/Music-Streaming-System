<?php
require_once 'db.php';

// Fetch the 4 most popular songs based on play_count
$popularQuery = $pdo->query("
    SELECT s.title as song_title, s.play_count, COALESCE(a.name, 'Unknown Artist') AS artist_name 
    FROM songs s 
    LEFT JOIN artists a ON s.artist_id = a.artist_id 
    ORDER BY s.play_count DESC 
    LIMIT 4
");
$popularSongs = $popularQuery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Library - Home</title>
    <!-- Update your CSS link here -->
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="history.php">History</a>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php">Playlists</a>
            <a href="add_song.php">Add Song / Artist</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: var(--accent-color); margin-left: 15px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="logout.php" style="color: #ff4d4d;">Logout</a>
            <?php else: ?>
                <a href="login.php" class="active">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <!-- Slideshow of the 4 most popular songs -->
        <?php if (!empty($popularSongs)): ?>
        <div class="slideshow-container" id="slideshow">
            <h3 style="margin-bottom: 15px; color: var(--text-secondary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">🔥 Trending Now (Top 4 Songs)</h3>
            <?php foreach ($popularSongs as $index => $song): ?>
                <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                    <div class="song-icon">🎧</div>
                    <h3><?= htmlspecialchars($song['song_title']) ?></h3>
                    <!-- Fixed number_format PHP tag -->
                    <p>Artist: <?= htmlspecialchars($song['artist_name']) ?> &bull; Plays: <?= number_format($song['play_count']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Search Bar with 4 Specific Tags -->
        <div class="search-box">
            <h2>Search Music Library</h2>
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Type search keyword..." required>
                <select name="tag">
                    <option value="song">Song</option>
                    <option value="artist">Artist</option>
                    <option value="album">Album</option>
                    <option value="tag">Song tag (Genre)</option>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <script>
        let slideIndex = 0;
        function showSlides() {
            let slides = document.getElementsByClassName("slide");
            if (slides.length === 0) return;
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1; }
            slides[slideIndex - 1].classList.add("active");
            setTimeout(showSlides, 4000);
        }
        if (document.getElementsByClassName("slide").length > 1) {
            setTimeout(showSlides, 4000);
        }
    </script>
</body>
</html>