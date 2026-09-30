<?php
require_once 'db.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO USERS (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            $success = "Account created successfully! You can now log in.";
        } catch (Exception $e) {
            $error = "Registration failed. Email might already be registered.";
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
    <title>Register - Melodica Library</title>
    <link rel="stylesheet" href="assets/asset_style.css">
</head>
<body>
    <header>
        <h1>🎵 Melodica Library</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="library.php">Library</a>
            <a href="playlists.php">Playlists</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <div class="container" style="max-width: 500px;">
        <div class="form-card">
            <h2>Create an Account</h2>
            <?php if (!empty($error)): ?>
                <div class="alert" style="background: rgba(255, 0, 0, 0.1); border-color: #ff4d4d; color: #ff4d4d; margin-top: 15px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert" style="margin-top: 15px;"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST" style="margin-top: 20px;">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Your email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Choose a password" required>
                </div>
                <button type="submit" style="width: 100%;">Register</button>
            </form>
            <p style="margin-top: 20px; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">
                Already have an account? <a href="login.php" style="color: var(--accent-color);">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>