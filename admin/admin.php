<!--
TODO

Highlights of portfolio section
ESC listener
Footer
Resume

-->


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nathan Ryder | Admin</title>
    <link rel="stylesheet" href="../files/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../files/css/admin.css">
    <link rel="stylesheet" href="../files/css/master.css">
    <script src="https://unpkg.com/sweetalert2@7.16.0/dist/sweetalert2.all.js"></script>
    <script src="../files/bootstrap/jquery.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
      if(window.location.hash != "") {
          $('a[href="' + window.location.hash + '"]').click()
      }
      });
    </script>

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
            <a class="nav-link" data-toggle="tab" href="#highlights">Highlights</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#accounts">Accounts</a>
          </li>
        </ul>

        <div id="admin-options" class="tab-content">
          <div role="tabpanel" class="tab-pane fade active show" id="home">
            <br>

            <?php
            function uploadFile($file, $uid) {
              //Create file
              if (!file_exists("../uploads/" . $uid . "/")) {
                  mkdir("../uploads/" . $uid . "/", 0755, true);
              }

              $target = "../uploads/" . $uid . "/" . basename($_FILES[$file]["name"]);
              $type = strtolower(pathinfo($target, PATHINFO_EXTENSION));

              if ($file === "thumbnail" || $file === "header") {
                if($type != "jpg" && $type != "png" && $type != "jpeg"
                    && $type != "gif")
                  return false;

                  if (!move_uploaded_file($_FILES[$file]["tmp_name"], $target))
                    return false;
              } else {
                if($type != "zip" && $type != "jar")
                  return false;

                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $target))
                  return false;
              }

              return $_FILES[$file]["name"];
            }

            function generateRandomString($length = 6) {
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $randomString = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              return $randomString;
            }

            function rrmdir($dir) {
              if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                  if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                      rrmdir($dir."/".$object);
                   else
                    unlink($dir."/".$object);
                  }
                }
                rmdir($dir);
              }
            }


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
                            <strong>Successfully deleted category!</strong>
                          </div>';
                  } else {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to delete category!</strong>
                          </div>';
                  }
                } else if (isset($_POST['deleteProject'])) {
                  $id = $_POST['ID'];
                  $folder = $_POST['Folder'];

                  if (deleteProject($con, $id)) {
                    rrmdir("../uploads/" . $folder);

                    echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Successfully deleted project!</strong>
                          </div>';
                  } else {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to delete project!</strong>
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
                } else if (isset($_POST['addProject'])) {
                  $name = $_POST['name'];
                  $desc = $_POST['desc'];
                  $year = $_POST['year'];
                  $cat = $_POST['category'];
                  $repo = $_POST['repo']; //optional
                  $file = $_FILES['file']['name']; //optional
                  $thumbnail = $_FILES['thumbnail']['name'];
                  $banner = $_FILES['header']['name'];
                  $content = $_POST['content'];
                  $error = false;

                  if (strlen($name) < 1)
                    $error = true;
                  else if (strlen($desc) < 1)
                    $error = true;
                  else if (strlen($year) < 1)
                    $error = true;
                  else if (strlen($cat) < 1)
                    $error = true;
                  else if ((strlen($repo) < 1) && (strlen($file) < 1))
                    $error = true;
                  else if (strlen($thumbnail) < 1)
                    $error = true;
                  else if (strlen($banner) < 1)
                    $error = true;
                  else if (strlen($content) < 1)
                    $error = true;

                  if ($error) {
                    echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Failed to create new project. Are all required fields filled out?</strong>
                          </div>';
                  } else {
                    $uid = generateRandomString();
                    if (!file_exists("../uploads/" . $uid . "/")) {
                        mkdir("../uploads/" . $uid . "/", 0755, true);
                    }

                    $thumbError = uploadFile("thumbnail", $uid);
                    $headError = uploadFile("header", $uid);

                    if (strlen($file) > 0) {
                      $fileError = uploadFile("file", $uid);

                      if (strlen($fileError) < 1 || strlen($thumbError) < 1 || strlen($headError) < 1) {
                        echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Failed to add project. Failed to upload files.</strong>
                              </div>';
                              rrmdir("../uploads/" . $uid);
                      } else {
                        $f = fopen("../uploads/" . $uid . "/content.html", "w");
                        fwrite($f, $content);
                        fclose($f);

                        if (createNewProject($con, $name, $desc, $year, $cat, $repo, $content, $fileError, $thumbError, $headError, $uid)) {
                          echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <strong>Successfully created new project called ' . $name . '</strong>
                                </div>';
                        } else {
                          echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <strong>Failed to create new project. Please report this to an adminstrator</strong>
                                </div>';
                        }
                      }
                    } else {
                      if (strlen($thumbError) < 1 || strlen($headError) < 1) {
                        echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Failed to add project. Failed to upload files.</strong>
                              </div>';
                              rrmdir("../uploads/" . $uid);
                      } else {
                        $f = fopen("../uploads/" . $uid . "/content.html", "w");
                        fwrite($f, $content);
                        fclose($f);

                        if (createNewProject($con, $name, $desc, $year, $cat, $repo, $content, NULL, $thumbError, $headError, $uid)) {
                          echo '<div style="width: 60%" class="alert alert-dismissible alert-success">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <strong>Successfully created new project called ' . $name . '</strong>
                                </div>';
                        } else {
                          echo '<div style="width: 60%" class="alert alert-dismissible alert-danger">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <strong>Failed to create new project. Please report this to an adminstrator</strong>
                                </div>';
                        }
                      }
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
          -->
          <div role="tabpanel" class="tab-pane fade" id="projects">
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
                  $data = mysqli_query($con, "SELECT * FROM projects");
                  while ($row = mysqli_fetch_assoc($data)) {
                    $id = $row['ID'];
                    $uid = $row['Folder'];
                    $admin = $_SESSION['admin'] === "1" ? "Yes" : "No";

                    $cat = $row['Category'];
                    $query = mysqli_query($con, "SELECT Name FROM categories WHERE ID=" . $cat);
                    $catName = mysqli_fetch_assoc($query)["Name"];

                    echo "<tr>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Description'] . "</td>";
                    echo "<td>" . $catName . "</td>";
                    echo "<td>" . $row['Year'] . "</td>";
                    echo "<td>
                            <span class='delete'>
                              <a href='javascript:void(0)' onclick='showPopup(\"editProject\", " . $id . ")'>
                                <img width='18px' src='../files/images/edit.png'>
                              </a>
                              <a href='javascript:void(0)' onclick='deleteProject(" . $id . ", \"" . $uid . "\")'>
                                <img width='18px' src='../files/images/delete.png'>
                              </a>
                            </span>
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

              <form action="admin.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input style="width:60%;" type="text" name="name" class="form-control" placeholder="Project Name">
                  <br>
                  <input style="width:60%;" type="text" name="desc" class="form-control" placeholder="Short description">
                  <br>
                  <input style="width:60%;" type="number" name="year" class="form-control" value="<?php echo date('Y'); ?>">
                  <br>
                  <select style="width:60%;" name="category" class="form-control">
                    <?php
                      $query = mysqli_query($con, "SELECT ID,Name FROM categories");
                      while ($row = mysqli_fetch_assoc($query)) {
                        echo '<option value="' . $row["ID"] . '">' . $row['Name'] . '</option>';
                      }
                    ?>
                  </select>
                  <br>
                  <input style="width:60%;" type="text" name="repo" class="form-control" placeholder="Link to repository">
                  <br>
                  Source: <input style="width:60%;" type="file" name="file" class="form-control">
                  <br>
                  Thumbnail: <input style="width:60%;" type="file" name="thumbnail" class="form-control">
                  <br>
                  Header: <input style="width:60%;" type="file" name="header" class="form-control">
                  <br>
                  <textarea style="width:60%;" class="form-control" name="content" rows="8" cols="80" placeholder="Project description"></textarea>

                  <br>
                  <input type="submit" name="addProject" value="Submit">
                </div>
              </form>
            </div>
          </div>

          <!-- EDIT PROJECT -->
          <div id="editProject-popup" class="editProject-popup">
            <div class="editProject-heading">
              Edit Project (Not finished)
              <a href="javascript:void(0)" onclick="closePopup('editProject')"><img width="16px" src="../files/images/close.svg"></a>
            </div>
            <br><br>

            <form action="admin.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input style="width:60%;" type="text" name="name" class="form-control" placeholder="Project Name">
                <br>
                <input style="width:60%;" type="text" name="desc" class="form-control" placeholder="Short description">
                <br>
                <input style="width:60%;" type="number" name="year" class="form-control" value="<?php echo date('Y'); ?>">
                <br>
                <select style="width:60%;" name="category" class="form-control">
                  <?php
                    $query = mysqli_query($con, "SELECT ID,Name FROM categories");
                    while ($row = mysqli_fetch_assoc($query)) {
                      echo '<option value="' . $row["ID"] . '">' . $row['Name'] . '</option>';
                    }
                  ?>
                </select>
                <br>
                <input style="width:60%;" type="text" name="repo" class="form-control" placeholder="Link to repository">
                <br>
                Source: <input style="width:60%;" type="file" name="file" class="form-control">
                <br>
                Thumbnail: <input style="width:60%;" type="file" name="thumbnail" class="form-control">
                <br>
                Header: <input style="width:60%;" type="file" name="header" class="form-control">
                <br>
                <textarea style="width:60%;" class="form-control" name="content" rows="8" cols="80" placeholder="Project description"></textarea>

                <br>
                <input type="submit" name="editProject" value="Submit">
              </div>
            </form>
          </div>

          <!-- HIGHLIGHTS -->
          <div role="tabpanel" class="tab-pane fade" id="highlights">
            <!-- <table class="table table-striped table-hover"> -->

            <table border="1" style="width: 100%">
              <thead>

                <tr style="text-align: center;">
                  <?php
                    $columns = mysqli_query($con, "SHOW COLUMNS FROM highlights");
                    while ($name = mysqli_fetch_array($columns)) {
                      echo "<br><th>" . $name['Field'] . "</th>";
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                <button onclick="addHighlightsRow()" style="float:right;" type="button" class="btn btn-default">
                  <img height="16px" src="../files/images/add.png">
                  Add Row
                </button>
                <br>

                <?php
                  $curRow = 0;
                  $col = 'C';

                  $mainQuery = mysqli_query($con, "SELECT * FROM highlights");
                  $totalRows = mysqli_num_rows($mainQuery);
                  while ($row = mysqli_fetch_assoc($mainQuery)) {

                    $rowID = $row['Row'];
                    echo "<tr style='line-height: 100px; text-align: center;'>";
                      echo "<td>" . $rowID . "</td>";
                      for ($count = 0; $count < 3; $count++) {
                        $col = getNextChar($col);
                        $id = $row[$col];
                        $no = ($curRow+$count)+($curRow);

                        if ($curRow > 0)
                          $no++;

                        if ($id === NULL || $id === "" || $id === "NULL") {
                          $id = "None";
                        } else {
                          $id = getProjectNameByID($con, $id);
                        }

                      ?>

                      <td>
                        <a href="javascript:void(0)">
                          <div id="controls-<?php echo $no; ?>">
                            <?php
                            if ($curRow == ($totalRows-1)) {
                              echo '<div id="addHighlight" class="addHighlight tooltip">';
                            } else {
                              echo '<div onmouseout="hideControlsLower(' . $no . ', \'visible\');" onmouseover="hideControlsLower(' . $no . ', \'hidden\');" id="addHighlight" class="addHighlight tooltip">';
                            }
                            ?>
                              <div class="tooltiptext">
                                Select a category
                                <select>
                                  <?php

                                  $i = 0;
                                  $query = mysqli_query($con, "SELECT * FROM categories");
                                  while ($cat = mysqli_fetch_assoc($query)) {
                                    $name = $cat['Name'];
                                    echo '<option onclick="updateProjectDropdown(\'projectDropdown-' . ($no) . '\', this)" value="' . $name . '">' . $name .'</option>';
                                    $i++;
                                  }

                                  ?>
                                </select>
                                <br><br>
                                Select a project
                                <select id="projectDropdown-<?php echo $no; ?>">
                                </select>
                                <br><br>

                                <button data-row="<?php echo $curRow; ?>" data-column="<?php echo $col; ?>" onclick="updateHighlightSlot(<?php echo $count; ?>, this)" class="btn-success" style="border: 0">Confirm</button>
                              </div>
                            </div>

                            <div id="removeHighlight" class="removeHighlight tooltip">
                              <div class="tooltiptext">
                                Are you sure?<br><br>
                                <button data-row="<?php echo $curRow; ?>" data-column="<?php echo $col; ?>" onclick="removeHighlight(<?php echo $count; ?>, this)" class="btn-success" style="border: 0">Yes</button>
                              </div>
                            </div>
                          </div>
                        </a>

                        <span id="projectName-<?php echo $count; ?>"><?php echo $id; ?></span>
                      </td>

                      <?php

                      }

                      echo "</tr>";
                      $curRow++;
                      $count++;
                  }

                ?>




              </tbody>
            </table>
          </div>

          <div role="tabpanel" class="tab-pane fade" id="accounts">
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

    <?php include("../files/include/footer.php"); ?>

    <script src="../files/include/javascript.js"></script>
    <script src="../files/bootstrap/jquery.min.js"></script>
    <script src="../files/bootstrap/popper.min.js"></script>
    <script src="../files/bootstrap/bootstrap.min.js"></script>
  </body>
</html>
