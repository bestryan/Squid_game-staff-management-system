<?php
$servername = "localhost"; $username = "root";
$password = "root"; $dbname = "testdb";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Insert
$sql = "INSERT INTO Employees (FirstName, LastName, Email, BirthDate, Photo, Notes)
VALUES  ('Ryan', 'Xiao', 'ryan@tafensw.com', '2022-02-02', 'ryan.jpg', 'Developer'),
        ('Nats', 'Katsuro', 'nats@japan.co', '2022-01-01', 'nats.jpg', 'HR Manager'),
        ('Bella', 'Ava', 'bella@tafe.net', '2000-06-01', 'bella.jpg', 'There is no information about this employee'),
        ('Rafi', 'Lee', 'rafi@ebay.com', '2005-03-23', 'rafi.jpg', 'Accountant'),
        ('Sean', 'teh', 'sean@klcc.com', '2004-12-12', 'sean.jpg', 'General Manager')";
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: ".$sql."<br>".$conn->error;
}
$conn->close();
?>