<?php
// Include config file
include ("config.php");
 
// Define variables and initialize with empty values
$fname = $lname = $email = $date = $address = $note = "";
$fname_err = $lname_err = $email_err = $address_err = $date_err = $photo_err = $note_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate first name
    $input_fname = trim($_POST["fname"]);
    if(empty($input_fname)){
        $fname_err = "Please enter first name.";
    } elseif(!filter_var($input_fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fname_err = "Please enter a valid name.";
    } else{
        $fname = $input_fname;
    }
    
    // Validate last name
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $lname_err = "Please enter last name.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lname_err = "Please enter a valid name.";
    } else{
        $lname = $input_lname;
    }
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate email
    $input_email = $_POST["email"];
    if(empty($input_email)){
        $email_err = "Please enter an email.";     
    } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter a valid email.";
    }else{
        $email = $input_email;
    }

    // Validate Birth Date
    $input_date = $_POST["bdate"];
    if(empty($input_date)){
        $date_err = "Please enter birth date.";     
    } else{
        $date = $input_date;
    }

    // Validate notes
    $input_note = trim($_POST["note"]);
    if(empty($input_note)){
        $note_err = "Please leave a note.";     
    } else{
        $note = $input_note;
    }   

    // Validate photo
    $input_photo = $_FILES['image'];
    if(empty($input_photo)){
        $photo_err = "Please upload a photo.";     
    } else{
        $photoName = $_FILES['image']['name'];
        $uploadFileDir = "images/";
        $dest_path = $uploadFileDir . $photoName;
        move_uploaded_file($_FILES['image']['tmp_name'], $dest_path);
    }

    // Check input errors before inserting in database
    if(empty($fname_err) && empty($lname_err) && empty($address_err) &&
        empty($email_err) && empty($date_err) && empty($photo_err) && empty($note_err)){
        // Prepare an update statement
        $sql = "UPDATE employees SET First_Name=?, Last_Name=?, Address=?, Email=?, Birth_Date=?, Photo=?, Notes=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssi", $param_fname, $param_lname, $param_address, $param_email, $param_date, $param_photo, $param_notes, $param_id);
        
            // Set parameters
            $param_fname = $fname;
            $param_lname = $lname;
            $param_address = $address;
            $param_email = $email;
            $param_date = $date;
            $param_photo = $photoName;
            $param_notes = $note;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
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
                        <h2>Update Employee Details</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>"> 
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>">
                            <span class="help-block"><?php echo $fname_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>"> 
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>">
                            <span class="help-block"><?php echo $lname_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>"> 
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>"> 
                            <label>Birth Date</label>
                            <input type="date" name="bdate" class="form-control" value="<?php echo $date; ?>">
                            <span class="help-block"><?php echo $date_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($photo_err)) ? 'has-error' : ''; ?>"> 
                            <label>Photo</label>
                            <input type="file" name="image" class="form-control" value="<?php echo $photo; ?>">
                            <span class="help-block"><?php echo $photo_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($note_err)) ? 'has-error' : ''; ?>">
                            <label>Notes</label>
                            <textarea name="note" class="form-control"><?php echo $note; ?></textarea>
                            <span class="help-block"><?php echo $note_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-danger" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>