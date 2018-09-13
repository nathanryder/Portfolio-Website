<?php

function getProjectNameByID($con, $id) {
  $query = mysqli_query($con, "SELECT Name FROM projects WHERE ID=" . $id);

  if ($query === NULL) {
    return NULL;
  }

  return mysqli_fetch_assoc($query)['Name'];
}

function createCategory($con, $name, $desc) {
  $query = mysqli_query($con, "INSERT INTO categories (Name, Description) VALUES ('$name', '$desc')");

  if ($query === NULL)
    return false;

    return true;
}

function deleteCategory($con, $id) {
  $query = mysqli_query($con, "DELETE FROM categories WHERE ID=" . $id);

  if ($query === NULL)
    return false;

  return true;
}

function deleteProject($con, $id) {
  $query = mysqli_query($con, "DELETE FROM projects WHERE ID=" . $id);

  if ($query === NULL)
    return false;

  return true;
}

function createNewProject($con, $name, $desc, $year, $cat, $repo, $content, $file, $thumb, $head, $uid) {
  $query = mysqli_query($con, "INSERT INTO projects (Name,Description,Year,Category,Repository,Folder,File,Thumbnail,Header)
            VALUES ('$name', '$desc', $year, '$cat', '$repo', '$uid', '$file', '$thumb', '$head')");

  if ($query === NULL)
    return false;

  return true;
}


function deleteUser($con, $id) {
  $query = mysqli_query($con, "DELETE FROM users WHERE ID=" . $id);

  if ($query === NULL)
    return false;

  return true;
}

function addUser($con, $user, $password, $admin) {
  $admin = $admin == "on" ? 1 : 0;
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $query = mysqli_query($con, "INSERT INTO users (Username, Password, Admin) VALUES ('$user', '$hash', $admin)");

  if ($query === NULL)
    return false;

  return true;
}

function changePassword($con, $id, $pass) {
  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $query = mysqli_query($con, "UPDATE users SET Password='$hash' WHERE ID=" . $id);

  if ($query === NULL)
    return false;

  return true;
}

function getNextChar($c) {
  if ($c === 'C')
    return 'A';

  return ++$c;
}

?>
