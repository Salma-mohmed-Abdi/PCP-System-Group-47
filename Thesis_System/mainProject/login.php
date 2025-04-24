<?php
session_start();
include 'db.php';

$error = "";
$successScript = ""; // Will hold the JS if login is successful

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $users = $stmt->get_result()->fetch_assoc();

    if ($users && password_verify($password, $users['password'])) {
        $_SESSION['user'] = $users['username']; // Save username to session

        // Instead of header(), show a JS alert and redirect
        $successScript = "<script>
            alert('Login successful! Redirecting to dashboard...');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Pancreatic Cancer</title>
    <link rel="stylesheet" href="login.css">
</head>
<body class="login-body">
    <div class="navbar">
        <div class="logo">Pancreatic<span style="color:#000;">Cancer</span></div>
        <div class="nav-links">
            <a class="" href="index.php">Home</a>
            <a href="login.php">Login</a>
        </div>
    </div>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <button type="submit">Login</button>
            <p><a href="forgot.php">Forgot Password?</a></p>
        </form>
    </div>

    <!-- Inject success JS if login was correct -->
    <?= $successScript ?>
</body>
</html>
