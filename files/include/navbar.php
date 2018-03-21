<?php
session_start();
include 'connect.php';
?>

<style media="screen">
  .nav-link {
    font-size: 15px;
  }
  .navbar-brand {
    font-size: 18px;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Nathan Ryder</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Projects <span class="sr-only">(current)</span></a>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
          <?php
          $query = mysqli_query($con, "SELECT * FROM categories");
          while ($row = mysqli_fetch_assoc($query)) {
            $name = $row['Name'];
            echo '<a class="dropdown-item" href="category.php?category=' . $name . '">' . $name . '</a>';
          }
          ?>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php#about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php#contact">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin/">Admin</a>
      </li>

      <?php
        if ($_SESSION['admin']) {
          echo '  <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>';
        }
      ?>

    </ul>
  </div>
</nav>
