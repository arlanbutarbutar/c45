<?php 
$conn=mysqli_connect("localhost","root","","data_mining_c45");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
