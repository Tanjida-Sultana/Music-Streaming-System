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
