<?php
$servername = "localhost"; $username = "root";
$password = "root"; $dbname = "testdb";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$firstname = ""; $lastname = ""; $email = "";
$birthdate = ""; $photo = ""; $notes = "";

$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$email = $_POST['email'];
$birthdate = $_POST['date'];
$photo = $_POST['photoUpload'];
$notes = $_POST['notes'];
// Insert values to database
$sql = "INSERT INTO Employees (FirstName, LastName, Email, BirthDate, Photo, Notes)
    VALUES ('$firstname', '$lastname', '$email','$birthdate','$photo','$notes')";
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: ".$sql."<br>".$conn->error;
}
$conn->close();
?>