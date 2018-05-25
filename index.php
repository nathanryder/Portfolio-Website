<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Portfolio</title>
    <link rel="stylesheet" href="files/css/master.css">
    <link rel="stylesheet" href="files/bootstrap/bootstrap.min.css" >
  </head>

  <body>
    <?php include 'files/include/navbar.php'; ?>

    <img width="100%" src="files/images/keyboard.png">
    <div id="about" class="about">
      <img class="profile" width="256px" src="files/images/profile.png">

      <br><br><br><br>
      <h1 class="text">About Me</h1>
    </div>

    <div id="portfolio" class="portfolio">
      <br><br><br><br>
      <h1 class="text">Portfolio Highlights</h1>
      <br>
      <div class="container">

        <div class="row">
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
        </div>

      </div>
    </div>

    <div id="contact" class="contact">
      <br><br><br><br>
      <h1 class="text">Contact</h1>
    </div>

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
