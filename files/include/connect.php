<?php

define("host", "127.0.0.1");
define("user", "root");
define("password", "user");
define("database", "WebsiteData");

$con = mysqli_connect(host, user, password, database) or die("Error code: 1");

$tableExists = mysqli_query($con, "SHOW TABLES LIKE 'users'");
if (mysqli_num_rows($tableExists) < 1) {
  $create = "CREATE TABLE users (
    ID INTEGER(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(128) NOT NULL,
    Password VARCHAR(128) NOT NULL,
    Admin INT(2) NOT NULL
  )";

  if (mysqli_query($con, $create) === FALSE) {
    echo "Error code: 2";
    return;
  }

  $hash = password_hash("admin", PASSWORD_DEFAULT);
  $query = mysqli_query($con, "INSERT INTO users (Username,Password,Admin) VALUES ('admin', '$hash', 1)");
  if ($query === FALSE) {
    echo "Error code: 3";
    return;
  }
}

$tableExists = mysqli_query($con, "SHOW TABLES LIKE 'categories'");
if (mysqli_num_rows($tableExists) < 1) {
  $create = "CREATE TABLE categories (
    ID INTEGER(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(128) NOT NULL,
    Description VARCHAR(128) NOT NULL
  )";

  if (mysqli_query($con, $create) === FALSE) {
    echo "Error code: 4";
    return;
  }
}

$tableExists = mysqli_query($con, "SHOW TABLES LIKE 'projects'");
if (mysqli_num_rows($tableExists) < 1) {
  $create = "CREATE TABLE projects (
    ID INTEGER(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(128) NOT NULL,
    Description VARCHAR(128) NOT NULL,
    Year INT(10) NOT NULL,
    Category VARCHAR(128) NOT NULL,
    Repository VARCHAR(128),
    File VARCHAR(128) NOT NULL,
    Thumbnail VARCHAR(128) NOT NULL,
    Header VARCHAR(128) NOT NULL
  )";

  if (mysqli_query($con, $create) === FALSE) {
    echo "Error code: 5";
    return;
  }
}
?>
