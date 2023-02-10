<?php
$servername = "localhost";
$username = "root";
$password = "root";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: ".$conn->connect_error);
}
//Create database
$sql = "CREATE DATABASE testdb";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: .$sql".$conn->error;
}
printf("Server version: %s\n", mysqli_get_server_info($conn));
echo "<br>The current date: ".date('Y-m-d');
$conn->close();
?>