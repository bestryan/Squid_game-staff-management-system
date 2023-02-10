<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $fname = $row["First_Name"];
                $lname = $row["Last_Name"];
                $address = $row["Address"];
                $email = $row["Email"];
                $date = $row["Birth_Date"];
                $photo = $row["Photo"];
                $note = $row["Notes"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Employee Details</h2>
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
                        <p class="form-control-static"> <?php echo "<img class='img-thumbnail' src='images/$photo'"?></p>
                    </div>

                    <div class="form-group">
                        <!-- <label>First Name</label> -->
                        <p class="form-control-static"><?php echo "<label>First Name: </label> ".$fname; ?></p>
                    </div>

                    <div class="form-group">
                        <!-- <label>Last Name</label> -->
                        <p class="form-control-static"><?php echo "<label>Last Name: </label> ".$lname; ?></p>
                    </div>

                    <div class="form-group">
                        <!-- <label>Email</label> -->
                        <p class="form-control-static"><?php echo "<label>Email: </label> ".$email; ?></p>
                    </div>

                    <div class="form-group">
                        <!-- <label>Address</label> -->
                        <p class="form-control-static"><?php echo "<label>Address: </label> ".$address; ?></p>
                    </div>


                    <div class="form-group">
                        <!-- <label>Birth Date</label> -->
                        <p class="form-control-static"><?php echo "<label>Birth Date: </label> ".$date; ?></p>
                    </div>

                    <div class="form-group">
                        <!-- <label>Notes</label> -->
                        <p class="form-control-static"><?php echo "<label>Notes: </label> ".$note; ?></p>
                    </div>

                    <p><a href="index.php" class="btn btn-danger">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>