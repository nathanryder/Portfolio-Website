<?php

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

?>