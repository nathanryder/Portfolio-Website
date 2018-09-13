<?php
include("../connect.php");

$row = $_POST['row'];
$col = $_POST['column'];
$id = $_POST['id'];

$query = mysqli_query($con, "UPDATE highlights SET " . $col . "='" . $id . "' WHERE Row='" . $row . "'");

if ($query === FALSE)
  error_log("Failed to update highlights!");
?>
