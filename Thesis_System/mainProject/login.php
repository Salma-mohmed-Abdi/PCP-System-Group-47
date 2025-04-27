<?php
session_start();
include 'db.php';

$error = "";
$successScript = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $users = $stmt->get_result()->fetch_assoc();

    if ($users && password_verify($password, $users['password'])) {
        $_SESSION['user'] = $users['username'];

        // Alert and redirect after OK
        $successScript = "<script>
            window.onload = function() {
                alert('Login successful!');
                window.location.href = 'dashboard.php';
            }
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
            <a href="index.php">Home</a>
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

    <!-- Success alert and redirect -->
    <?= $successScript ?>
</body>
</html>
