<?php
include("../connect.php");

$catQuery = mysqli_query($con, "SELECT ID FROM categories WHERE Name='" . $_GET['category'] . "'");
$id = mysqli_fetch_assoc($catQuery)["ID"];
$query = mysqli_query($con, "SELECT ID, Name FROM projects WHERE Category=" . $id);

$data = "";
while ($row = mysqli_fetch_assoc($query)) {
  $data .= $row['ID'] . ":" . $row['Name'] . ",";
}

if (strlen($data) > 0)
  $data[strlen($data)-1] = " ";

echo $data;
?>
