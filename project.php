<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Project</title>
    <link rel="stylesheet" href="files/css/master.css">
    <link rel="stylesheet" href="files/bootstrap/bootstrap.min.css" >
  </head>
  <body style="background-color: #333">
    <?php include 'files/include/navbar.php'; ?>

    <div class="container white-bg-panel">

      <?php
      if ($_GET['project'] === "test") {
      ?>
      <div class="row">
        <div class="col-lg-3">
          <h4>NAME OF PROJECT</h4>
          <br><br><br>

          <h5>Year</h5>
          <h3>2018</h3>
          <br><br><br>

          <h5>Downloads</h5>
          <h3><a class="download-links" href="#">Download</a></h3>
          <h3><a class="download-links" href="#">Github</a></h3>
          <br><br><br>

          <h5>Category</h5>
          <h3>Personal</h3>
        </div>

        <div class="col-lg-8">
          <img style="width:100%;" src="https://i.imgur.com/xhHqH3z.png">
        </div>
      </div>
      <br><br>

      <div class="row">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-9 projectContent">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>
    <?php
      } else {

        $query = mysqli_query($con, "SELECT * FROM projects WHERE ID=" . $_GET['project']);
        $data = mysqli_fetch_assoc($query);

        if ($data == NULL) {
          header("Location: index.php");
          die();
        }

        $catQuery = mysqli_query($con, "SELECT Name FROM categories WHERE ID=" . $data['Category']);
        $cat = mysqli_fetch_assoc($catQuery)["Name"];

        $header = "uploads/" . $data["Folder"] . "/" . $data["Header"];
        $content = file_get_contents("uploads/" . $data["Folder"] . "/content.html");
    ?>
    <div class="row">
      <div class="col-lg-3">
        <h4><?php echo strToUpper($data["Name"]) ?></h4>
        <br><br><br>

        <h5>Year</h5>
        <h3><?php echo $data["Year"] ?></h3>
        <br><br><br>

        <h5>Downloads</h5>
        <?php
        if ($data["File"] !== "") {
          echo '<h3><a class="download-links" target="_blank" href="#">Download</a></h3>';
        }
        if ($data["Repository"] !== "") {
          echo '<h3><a class="download-links" target="_blank" href="' . $data["Repository"] . '">Github</a></h3>';
        }
        ?>
        <br><br><br>

        <h5>Category</h5>
        <h3><?php echo $cat ?></h3>
      </div>

      <div class="col-lg-8">
        <img style="width:100%;" src="<?php echo $header ?>">
      </div>
    </div>
    <br><br>

    <div class="row">
      <div class="col-lg-3">
      </div>
      <div class="col-lg-9 projectContent">
        <?php echo $content; ?>
      </div>
    </div>
    <?php
      }
    ?>

    </div>

    <?php include("files/include/footer.php"); ?>

    <script src="files/bootstrap/jquery.min.js"></script>
    <script src="files/bootstrap/popper.min.js"></script>
    <script src="files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>
