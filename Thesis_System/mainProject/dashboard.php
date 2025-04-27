<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$prediction = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image_path = $_FILES['image']['tmp_name'];
    $url = 'http://localhost:5000/predict'; // Make sure your Python API is running

    $cfile = new CURLFile($image_path);
    $post = array('image' => $cfile);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $prediction = $result['prediction'] ?? 'Error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pancreatic Cancer Prediction</title>
  <link rel="stylesheet" href="predict.css">
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <div class="navbar">
    <div class="logo">Pancreatic<span style="color:#000;">Cancer</span></div>
    <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
    <div class="nav-links" id="navLinks">
      <a href="index.php">Home</a>
      <a href="login.php">Login</a>
      <a href="dashboard.php">Dashboard</a>
    </div>
  </div>

  <div class="container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
    <h2>Pancreatic Cancer Prediction</h2>

    <?php if ($prediction): ?>
      <h3>Prediction Result:</h3>
      <p><strong><?= htmlspecialchars($prediction) ?></strong></p>
      <p><a href="predict.php">Try Another</a></p>
    <?php else: ?>
      <form action="predict.php" method="post" enctype="multipart/form-data">
        <label for="image">Upload a CT Scan Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Predict</button>
      </form>
    <?php endif; ?>
  </div>

  <footer>
    <p>&copy; 2025 Pancreatic Cancer Prediction System</p>
  </footer>
</body>
</html>
