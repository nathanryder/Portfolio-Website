<!--
TODO

Highlights of portfolio section (on front page aswell)
Put download to code on private projects
Github -[Real name] All personal projects
Resume

Make #about, #contact smoother scroll?
Footer
Make headings on main page better

ESC listener

-->


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Admin</title>
    <link rel="stylesheet" href="../files/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../files/css/admin.css">
    <script src="https://unpkg.com/sweetalert2@7.16.0/dist/sweetalert2.all.js"></script>
  </head>
  <body onkeydown="escListener(event);" style="background-color: #333">
    <?php
    include '../files/include/navbar.php';
    include '../files/include/SQLConnector.php';

    if (!isset($_SESSION['username'])) {
      header("Location: ../index.php");
      die();
    }
    $admin = $_SESSION['admin'];
    ?>

    <center>
      <div id="fade" class="black-overlay"></div>
      <div class="admin-panel">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active show" data-toggle="tab" href="#home">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#projects">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#accounts">Accounts</a>
          </li>
        </ul>

        <div id="admin-options" class="tab-content">
          <div class="tab-pane fade active show" id="home">
            <br>

            <?php
            if ($_POST !== NULL) {
              if ($admin == 0) {
                echo '<div style="width: 60%" class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Read Only Mode: You are not an administrator</strong>
                      </div>';
              } else {
                if (isset($_POST['addCategory'])) {
                  $name = $_POST['name'];
                  $desc = $_POST['desc'];
                  if (strlen($name) == 0 || strlen($desc) == 0) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to add new category. Are all the fields filled out?</strong>
                          </div>';
                  } else {
                    if (createCategory($con, $name, $desc)) {
                      echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Added new category ' . $name . '</strong>
                            </div>';
                    } else {
                      echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Failed to add new category called ' . $name . '</strong>
                            </div>';
                    }
                  }
                } else if (isset($_POST['deleteCategory'])) {
                  $id = $_POST['ID'];
                  if (deleteCategory($con, $id)) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Successfully deleted user!</strong>
                          </div>';
                  } else {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to delete user!</strong>
                          </div>';
                  }
                } else if (isset($_POST['addUser'])) {
                  $user = $_POST['username'];
                  $pass = $_POST['pass'];
                  $confirm = $_POST['confirm'];
                  $admin = $_POST['admin'];

                  if (strlen($user) == 0 || strlen($pass) == 0 || strlen($confirm) == 0) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to create new user. Are all the fields filled out?</strong>
                          </div>';
                  } else {
                    if ($pass !== $confirm) {
                      echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Failed to create new user. Passwords do not match!</strong>
                            </div>';
                    } else {
                      if (addUser($con, $user, $pass, $admin)) {
                        echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Added new user ' . $user . '</strong>
                              </div>';
                      } else {
                        echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Failed to create new user!</strong>
                              </div>';
                      }
                    }
                  }
                } else if (isset($_POST['deleteUser'])) {
                  $id = $_POST['ID'];
                  if (deleteUser($con, $id)) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Successfully deleted user!</strong>
                          </div>';
                  } else {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to delete user!</strong>
                          </div>';
                  }
                } else if (isset($_POST['changePassword'])) {
                  $pass = $_POST['pass'];
                  $confirm = $_POST['confirm'];
                  $id = $_SESSION['id'];

                  if ($pass !== $confirm) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to change password. Passwords do not match!</strong>
                          </div>';
                  } else {
                    if (changePassword($con, $id, $pass)) {
                      echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Successfully changed password!</strong>
                            </div>';
                    } else {
                      echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Failed to change password</strong>
                            </div>';
                    }
                  }
                }
              }
            }

            ?>
            <!--
              CATEGORY
            -->
            <div id="category-popup" class="category-popup">
              <div class="category-heading">
                Add A Category
                <a href="javascript:void(0)" onclick="closePopup('category')"><img width="16px" src="../files/images/close.svg"></a>
              </div>
              <br><br>

              <form action="admin.php" method="POST">
                <div class="form-group">
                  <input style="width:60%;" type="text" name="name" class="form-control" placeholder="Category Name">
                  <br>
                  <input style="width:60%;" type="text" name="desc" class="form-control" placeholder="Description">
                  <br><br>

                  <input type="submit" name="addCategory" value="Submit">
                </div>
              </form>
            </div>

            <br>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>
                    <button onclick="showPopup('category')" style="float:right;" type="button" class="btn btn-default">
                      <img height="16px" src="../files/images/add.png">
                      Add
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $data = mysqli_query($con, "SELECT * FROM categories");
                  while ($row = mysqli_fetch_assoc($data)) {
                    $id = $row['ID'];

                    echo "<tr>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td class='delete'>
                            <a href='javascript:void(0)' onclick='deleteCategory(" . $id . ")'>
                              <img width='18px' src='../files/images/delete.png'>
                            </a>
                          </td>";
                    echo "</tr>";
                  }

                ?>
              </tbody>
            </table>
          </div>

          <!--
            PROJECTS

            Name
            Year
            .zip download
            Repo link
            category
            Thumbnail image
            Header image
            Short description
            Description
          -->
          <div class="tab-pane fade" id="projects">
            <br><br>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th>Year</th>
                  <th>
                    <button onclick="showPopup('addProject')" style="float:right;" type="button" class="btn btn-default">
                      <img height="16px" src="../files/images/add.png">
                      Add
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $data = mysqli_query($con, "SELECT * FROM users");
                  while ($row = mysqli_fetch_assoc($data)) {
                    $id = $row['ID'];
                    $admin = $row['Admin'] === "1" ? "Yes" : "No";

                    echo "<tr>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>" . $row['Year'] . "</td>";
                    echo "<td class='delete'>
                            <a href='javascript:void(0)' onclick='deleteProject(" . $id . ")'>
                              <img width='18px' src='../files/images/delete.png'>
                            </a>
                          </td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>

            <div id="addProject-popup" class="addProject-popup">
              <div class="addProject-heading">
                Add Project
                <a href="javascript:void(0)" onclick="closePopup('addProject')"><img width="16px" src="../files/images/close.svg"></a>
              </div>
              <br><br>

              <form action="admin.php" method="POST">
                <div class="form-group">
                  <input style="width:60%;" type="text" name="name" class="form-control" placeholder="Project Name">
                  <br>
                  <input style="width:60%;" type="text" name="desc" class="form-control" placeholder="Short description">
                  <br>
                  <input style="width:60%;" type="number" name="year" class="form-control" value="<?php echo date('Y'); ?>">
                  <br>
                  <input style="width:60%;" type="text" name="category" class="form-control" placeholder="Category">
                  <br>
                  <input style="width:60%;" type="text" name="repo" class="form-control" placeholder="Link to repository">
                  <br>
                  Source: <input style="width:60%;" type="file" name="file" class="form-control">
                  <br>
                  Thumbnail: <input style="width:60%;" type="file" name="thumbnail" class="form-control">
                  <br>
                  Header: <input style="width:60%;" type="file" name="header" class="form-control">
                  <br>
                  <textarea style="width:60%;" class="form-control" name="content" rows="8" cols="80" placeholder="test"></textarea>

                  <br>
                  <input type="submit" name="addUser" value="Submit">
                </div>
              </form>
            </div>
          </div>

          <div class="tab-pane fade" id="accounts">
            <!--
              ACCOUNTS
            -->
            <br>
            <form action="admin.php" method="POST">
              <input style="width:60%;" type="password" name="pass" class="form-control" placeholder="New password">
              <br>
              <input style="width:60%;" type="password" name="confirm" class="form-control" placeholder="Confirm password">
              <br>

              <input type="submit" name="changePassword" value="Change password">
            </form>
            <br><br>

            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Admin</th>
                  <th>
                    <button onclick="showPopup('addUser')" style="float:right;" type="button" class="btn btn-default">
                      <img height="16px" src="../files/images/add.png">
                      Add
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $data = mysqli_query($con, "SELECT * FROM users");
                  while ($row = mysqli_fetch_assoc($data)) {
                    $id = $row['ID'];
                    $admin = $row['Admin'] === "1" ? "Yes" : "No";

                    echo "<tr>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $admin . "</td>";
                    echo "<td class='delete'>
                            <a href='javascript:void(0)' onclick='deleteUser(" . $id . ")'>
                              <img width='18px' src='../files/images/delete.png'>
                            </a>
                          </td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>

            <div id="addUser-popup" class="addUser-popup">
              <div class="addUser-heading">
                Add user
                <a href="javascript:void(0)" onclick="closePopup('addUser')"><img width="16px" src="../files/images/close.svg"></a>
              </div>
              <br><br>

              <form action="admin.php" method="POST">
                <div class="form-group">
                  <input style="width:60%;" type="text" name="username" class="form-control" placeholder="Username">
                  <br>
                  <input style="width:60%;" type="password" name="pass" class="form-control" placeholder="Password">
                  <br>
                  <input style="width:60%;" type="password" name="confirm" class="form-control" placeholder="Confirm password">
                  <br>
                  Admin: <input type="checkbox" name="admin" class="form-control">
                  <br>

                  <input type="submit" name="addUser" value="Submit">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </center>

    <script src="../files/include/javascript.js"></script>
    <script src="../files/bootstrap/jquery.min.js"></script>
    <script src="../files/bootstrap/popper.min.js"></script>
    <script src="../files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>