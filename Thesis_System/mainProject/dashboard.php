<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if (isset($_FILES['image'])) {
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

    echo "<h2>Prediction Result:</h2>";
    echo "<p><strong>" . htmlspecialchars($prediction) . "</strong></p>";
    echo '<p><a href="ad.php">Try Another</a></p>';
} else {
    // header("Location: login.php");
}

?>

<h1>Welcome, <?= $_SESSION['user'] ?>!</h1>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pancreatic Cancer Prediction</title>
  <link rel="stylesheet" href="predict.css">
</head>
<body>
  <div class="container">
    <h1>Pancreatic Cancer Prediction</h1>
    <form action="predict.php" method="post" enctype="multipart/form-data">
      <label for="image">Upload a CT Scan Image:</label>
      <input type="file" name="image" accept="image/*" required>
      <button type="submit">Predict</button>
    </form>
  </div>
  <footer>
    <p>&copy; 2025 Pancreatic Cancer Prediction System</p>
  </footer>
</body>
</html>




