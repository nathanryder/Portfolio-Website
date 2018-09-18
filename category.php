<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Projects</title>
    <link rel="stylesheet" href="files/css/master.css">
    <link rel="stylesheet" href="files/bootstrap/bootstrap.min.css" >
  </head>
  <body style="background-color: #333">
    <?php
    include 'files/include/navbar.php';

    $cat = $_GET['category'];
    if (!isset($cat)) {
      header("Location: index.php");
      die();
    }

    if (strtolower($cat) === "dummy") {
      ?>
      <div class="container bg-panel">
        <div class="row">

          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                  <img src="https://peros.co.nz//wp-content/uploads/2015/11/red.png" alt="" />
              </div>
            </a>
          </div>

          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Green_square.svg/1000px-Green_square.svg.png">
              </div>
            </a>
          </div>

          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                <img src="http://charise.photography/wp-content/uploads/2017/01/image-square-1.jpg">
              </div>
            </a>
          </div>

        </div>

        <div class="row">
          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                  <img src="https://peros.co.nz//wp-content/uploads/2015/11/red.png" alt="" />
              </div>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Green_square.svg/1000px-Green_square.svg.png">
              </div>
            </a>
          </div>
          <div class="col-lg-4">
            <a href="project.php?project=test">
              <div data-content="Portfolio Website" class="portfolio-block">
                <img src="http://charise.photography/wp-content/uploads/2017/01/image-square-1.jpg">
              </div>
            </a>
          </div>
        </div>
      </div>
    <?php
  } else {
    ?>

    <div class="container bg-panel">
      <div class="row">
        <?php
          $catQuery = mysqli_query($con, "SELECT ID FROM categories WHERE Name='" . $_GET['category'] . "'");
          $id = mysqli_fetch_assoc($catQuery)["ID"];
          $query = mysqli_query($con, "SELECT ID, Name, Folder, Thumbnail FROM projects WHERE Category=" . $id);

          $i = 0;
          while ($row = mysqli_fetch_assoc($query)) {
            if ($i == 0) {
              echo '<div class="row">';
            }

            $path = "uploads/" . $row['Folder'] . "/" . $row['Thumbnail'];

            echo '
            <div class="col-lg-4">
              <a href="project.php?project=' . $row["ID"] . '">
                <div data-content="' . $row["Name"] . '" class="portfolio-block">
                    <img src="' . $path . '" />
                </div>
              </a>
            </div>';

            if ($i == 2) {
              echo '</div>';
              $i = 0;
            } else {
              $i++;
            }
          }
         ?>

      </div>
    </div>

    <?php
  }
    ?>

    <?php include("files/include/footer.php"); ?>

    <script src="files/bootstrap/jquery.min.js"></script>
    <script src="files/bootstrap/popper.min.js"></script>
    <script src="files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>
