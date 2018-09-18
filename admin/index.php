<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Admin</title>
    <link rel="stylesheet" href="../files/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" href="../files/css/admin.css">
    <link rel="stylesheet" href="../files/css/master.css">
  </head>
  <body style="background-color: #333">
    <?php
    include '../files/include/navbar.php';

    if (isset($_SESSION['username'])) {
      header("Location: admin.php");
      die();
    }

    $failed = false;
    if (isset($_POST['submit'])) {
      $user = $_POST['user'];
      $pass = $_POST['password'];

      $data = mysqli_query($con, "SELECT * FROM users");
      while ($row = mysqli_fetch_assoc($data)) {
        if (strtolower($row['Username']) !== strtolower($user)) {
          continue;
        }

        if (!password_verify($pass, $row['Password'])) {
          continue;
        }

        $_SESSION['username'] = $user;
        $_SESSION['id'] = $row['ID'];
        $_SESSION['admin'] = ($row['Admin'] === "1");
        header("Location: admin.php");
        die();
      }
      $failed = true;
    }

    ?>

    <center>
      <div class="login-panel">
          <h4 style="text-align: center;">Admin Login</h4>
          <br>
          <?php
            if ($failed) {
            echo '<div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Invalid username or password!</strong>
              </div>';
            }
          ?>

          <br>
          <form action="index.php" method="POST">
            <div class="form-group">
              <input style="width:60%;" type="text" name="user" class="form-control" placeholder="Username">
              <br>
              <input style="width:60%;" type="password" name="password" class="form-control" placeholder="Password">
              <br><br>

              <input type="submit" name="submit" value="Submit">
            </div>
          </form>
      </div>
    </center>

    <?php include("../files/include/footer.php"); ?>

    <script src="../files/bootstrap/jquery.min.js"></script>
    <script src="../files/bootstrap/popper.min.js"></script>
    <script src="../files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>
