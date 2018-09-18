<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Portfolio</title>
    <link rel="stylesheet" href="files/css/master.css">
    <link rel="stylesheet" href="files/bootstrap/bootstrap.min.css" >
  </head>

  <body>
    <?php
    include 'files/include/navbar.php';
    include 'files/include/SQLConnector.php';
    ?>

    <img width="100%" src="files/images/keyboard.png">
    <div id="about" class="about">

      <br>
      <h1 class="text">About Me</h1>
      <br>
      <div class="container">
        TEST
      </div>
    </div>

    <div id="portfolio" class="portfolio">
      <br><br><br><br>
      <h1 class="text">Portfolio Highlights</h1>
      <br>
      <div class="container">

        <?php

        $mainQuery = mysqli_query($con, "SELECT * FROM highlights");
        $char = 'A';
        while ($row = mysqli_fetch_assoc($mainQuery)) {
          echo '<div class="row">';
          for ($i = 0; $i < 3; $i++) {
            $id = $row[$char];

            if ($id === NULL || $id === "" || $id === "NULL") {
              $id = "#";
              ?>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div data-content="" class="portfolio-block">
                </div>
              </div>
              <?php
            } else {
              $name = getProjectNameByID($con, $id);
              ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <a href="project.php?project=<?php echo $id; ?>">
                    <div data-content="<?php echo $name; ?>" class="portfolio-block">
                        <img src="https://peros.co.nz//wp-content/uploads/2015/11/red.png" alt="" />
                    </div>
                  </a>
                </div>

              <?php
            }

            $char = getNextChar($char);
          }

          echo "</div>";
        }

        ?>

        <!-- <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div data-content="Portfolio Website" class="portfolio-block">
                <img src="https://peros.co.nz//wp-content/uploads/2015/11/red.png" alt="" />
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div data-content="Portfolio Website" class="portfolio-block">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Green_square.svg/1000px-Green_square.svg.png">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div data-content="Portfolio Website" class="portfolio-block">
              <img src="http://charise.photography/wp-content/uploads/2017/01/image-square-1.jpg">
            </div>
          </div>
        </div> -->

      </div>
    </div>

    <div id="contact" class="contact">
      <br><br><br><br>
      <h1 class="text">Contact</h1>

      <div style="text-align: center; padding-bottom: 50px;">
  			<form action="contact.php" method="POST">
    			<strong>Name</strong><br><input type="text" style="width: 30%;" placeholder="Your name" name="name"><br>
    			<br>
    			<strong>Email</strong><br><input type="text" style="width: 30%;" name="email" placeholder="Example@example.com"><br>
    			<br>
    			<strong>Message</strong></span> <br><textarea name="msg" cols="50" placeholder="Enter your message here.." rows="9"></textarea><br>
    			<br><br>
    			<input name="submit" style="width: 20%;" type="submit" value="Submit">
    		</form>
      </div>
    </div>

    <?php include("files/include/footer.php"); ?>

    <script type="text/javascript">
      function smoothScrollTo(id) {
        var e = document.getElementById(id);
        e.scrollIntoView({
          behavior: 'smooth'
        });
      }

    </script>

    <script src="files/bootstrap/jquery.min.js"></script>
    <script src="files/bootstrap/popper.min.js"></script>
    <script src="files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>
