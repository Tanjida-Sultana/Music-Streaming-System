<?php
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM USERS WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check credentials against the database table
        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Melodica Library</title>
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php">Playlists</a>
            <a href="login.php" class="active">Login</a>
        </nav>
    </header>

    <div class="container" style="max-width: 500px;">
        <div class="form-card">
            <h2>User Login</h2>
            <?php if (!empty($error)): ?>
                <div class="alert" style="background: rgba(255, 0, 0, 0.1); border-color: #ff4d4d; color: #ff4d4d; margin-top: 15px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST" style="margin-top: 20px;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="e.g. faisalhossain@acd.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" style="width: 100%;">Login</button>
            </form>
            <p style="margin-top: 20px; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">
                Don't have an account? <a href="register.php" style="color: var(--accent-color);">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>