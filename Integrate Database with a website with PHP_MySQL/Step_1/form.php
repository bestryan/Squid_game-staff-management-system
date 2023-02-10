<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
  </style>
</head>
<body>
<div class="container">
  <h2>Employee Registration Form</h2><br>
  <form action="process_guest_registration.php" method="post">
    <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" required>
      </div>    
    <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
    </div>   
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="example@email.com" name="email" required>
    </div>
    <div class="form-group">
      <label for="date">Birth Date:</label>
      <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="form-group">
      <label for="photoUpload">Photo:</label>
      <input type="file" class="form-control" id="photoUpload" name="photoUpload">
    </div>
    <div class="form-group">
      <label for="notes">Notes:</label>
      <input type="text" class="form-control" id="notes" placeholder="Something about you..." name="notes" required>
    </div>
    <br><button type="submit" class="btn btn-default">Submit</button>
    <button type="reset" class="btn btn-default">Cancel</button>
  </form>
</div>
</body>
</html>

