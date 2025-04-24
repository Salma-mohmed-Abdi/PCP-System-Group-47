<?php
// You can add PHP logic here later if needed.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pancreatic Cancer Classification</title>
  <link rel="stylesheet" href="index.css">
 
</head>
<body>
  <div class="navbar">
  <div class="logo">Pancreatic<span style="color:#000;">Cancer</span></div>
    <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
    <div class="nav-links" id="navLinks">
      <a class="" href="index.php">Home</a>
      <a href="login.php">Login</a>
    </div>
  </div>

  <div class="carousel">
    <div class="slides" id="slides">
      <div class="slide" style="background-image: url('images/micro.jpg');"></div>
      <div class="slide" style="background-image: url('images/ct.jpg');"></div>
      <div class="slide" style="background-image: url('images/cts.jpg');"></div>
    </div>
    <div class="carousel-overlay"></div>
    <div class="carousel-text">
      <h1>Pancreatic Cancer Classification System</h1>
    </div>
    <div class="carousel-controls">
      <span onclick="prevSlide()">&#10094;</span>
      <span onclick="nextSlide()">&#10095;</span>
    </div>
    <div class="dots" id="dots"></div>
  </div>

  <footer class="footer">
    <div class="footer-links">
      <a href="index.php">Home</a>
      <a href="login.php">Login</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </div>
    <div class="social-icons">
      <a href="#">&#x1F426;</a>
      <a href="#">&#x1F4F7;</a>
      <a href="#">&#x1F4AC;</a>
    </div>
    <div class="copyright">
      &copy; <?php echo date('Y'); ?> Pancreatic Cancer Classification. All rights Group 47.
    </div>
  </footer>

  <script>
    let index = 0;
    const slides = document.getElementById("slides");
    const totalSlides = slides.children.length;
    const dotsContainer = document.getElementById("dots");

    function showSlide(i) {
      index = (i + totalSlides) % totalSlides;
      slides.style.transform = `translateX(-${index * 100}%)`;
      updateDots();
    }

    function nextSlide() {
      showSlide(index + 1);
    }

    function prevSlide() {
      showSlide(index - 1);
    }

    function toggleMenu() {
      document.getElementById("navLinks").classList.toggle("show");
    }

    function updateDots() {
      const dots = document.querySelectorAll(".dot");
      dots.forEach((dot, i) => {
        dot.classList.toggle("active", i === index);
      });
    }

    function createDots() {
      for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        dot.addEventListener("click", () => showSlide(i));
        dotsContainer.appendChild(dot);
      }
      updateDots();
    }

    createDots();
    setInterval(nextSlide, 4000);
  </script>
</body>
</html>
