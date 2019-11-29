<?php
//start session
session_start();

//initialise arrays

$errors = array();

$success = array();

//connect to database

$db = mysqli_connect ('joshbirchdesign.co.uk.mysql', 'joshbirchdesign_co_uk_carcat', 'CarCat!1234','joshbirchdesign_co_uk_carcat');

//register a user
if (isset($_POST['signup'])) {
    //receive all input values from form
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);

    //form validation: ensure the form is correctly filled
    if (empty($name)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required") ; }
    if (empty($password)) { array_push($errors, "Password is required") ; }
    //if password and confirm don't match add error to the errors array 
    if ($password != $cpassword) {
        array_push($errors, "Passwords do not match");
    }

    //check to see if user already exists
    $user_check_query = "SELECT * FROM users WHERE name='$name' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { //if a user is returned in the row and returned in this variable
        if ($user['name'] == $name) { //check to see if theres already a user matched with the input
            array_push($errors, "User already exists");
        }

        if ($user['email'] == $email) { //check to see if theres an email matched with the input
            array_push($errors, "Email already exists");
        }
    }
    
    
    //server-side validation - checking integrity, format and validity of inputs
    if (!preg_match("/^[a-zA-Z]+$/",$name)) { //check to see if the name has any numbers and special characters
        array_push($errors, "Name must only contain letters and spaces");
    }

    if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)) { //check to see if the password meets the required criteria for security
        array_push($errors, "Password must contain an uppercase, lowercase, number or special character and a minimum of 8 characters");
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { //check the validation of email
        array_push($errors, "Enter a valid email");
    }
    
    

    //Permitting no errors in the array, the user can be added to the database
    if (count($errors) == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT); //hash password for security

        $query = "INSERT INTO users (name, email, password, profile_img) 
                    VALUES ('$name', '$email', '$password', 'assets/profile/profile_img.jpg')";

        mysqli_query($db, $query);

        $_SESSION['id'] = $user['id'];
        header('location: catalogue.php'); //log the user in and send them to the catalogue page
    }


}

//log in user
if(isset($_POST['signin'])) {
    //take values from form & escape string to prevent sql injection
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //check to see if the variables are empty
    if(empty($email)) {
        //if so push a new item in error array
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    // if there are no errors in the array
    if(count($errors) == 0) {
        // build the query
        $query = "SELECT * FROM users WHERE email='$email'";
        //return the results via integer in the variable
        $results = mysqli_query($db, $query);
        // if the integer is exactly 1
        if (mysqli_num_rows($results) == 1) {
            //create an array of the result
            
            //create array identifier
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

            //localise password
            $password_hash = $row['password'];

            //if the users' password is the same as the hashed password in the db
            if (password_verify($password, $password_hash)) {
                // store database result into session variables just in case they are needed
                $_SESSION['id'] = $row['id'];
                $_SESSION['u_name'] = $row['name'];
                $_SESSION['u_password'] = $row['password'];
                $_SESSION['u_email'] = $row['email'];
                $_SESSION['u_address_line_1'] = $row['address_line_1'];
                $_SESSION['u_address_line_2'] = $row['address_line_2'];
                $_SESSION['u_address_line_3'] = $row['address_line_3'];
                $_SESSION['u_postcode'] = $row['postcode'];
                $_SESSION['u_dob'] = $row['dob'];
                $_SESSION['u_phone_no'] = $row['phone_no'];
                $_SESSION['u_profile_img'] = $row['profile_img'];
                $_SESSION['success'] = "You Are Logged In";
                //send the user to the catalogue
                header('location: catalogue.php');
            } else {
                //if the password does not match the hashed password in the db
                array_push($errors, "Wrong Email/Password");
            }
            
        } else {
            //if the integer is 0 then the user has entered the wrong email or password
            array_push($errors, "Wrong Email/Password");
        }
    }
}

//edit user details
if (isset($_POST['edit'])) {

    //gather inputs, escape any sql injection and store in variables
    $name = mysqli_escape_string($db, $_POST['name']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $address_line_1 = mysqli_escape_string($db, $_POST['address_line_1']);
    $address_line_2 = mysqli_escape_string($db, $_POST['address_line_2']);
    $address_line_3 = mysqli_escape_string($db, $_POST['address_line_3']);
    $postcode = mysqli_escape_string($db, $_POST['postcode']);
    $dob = mysqli_escape_string($db, $_POST['dob']);
    $phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);
    


    if (!preg_match("/^[a-zA-Z]+$/",$name)) { //check to see if the name has any numbers and special characters
        array_push($errors, "Name must only contain letters and spaces");
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { //check the validation of email
        array_push($errors, "Enter a valid email");
    }

    if (!preg_match("/^[a-zA-Z]{1,2}([0-9]{1,2}|[0-9][a-zA-Z])\s*[0-9][a-zA-Z]{2}$/",$postcode)) {//check the validation of postcode against a UK postcode pattern
        array_push($errors, "Invalid postcode format");
    }

    if (!preg_match("/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/",$phone_no)) {//check  the validation of phone number against a UK phone number
        array_push($errors, "Invalid phone number format");
    }

    
    //if there are no errors present in the errors array then update the users details
    if (count($errors) == 0){
    
        //localise users session id for compatibility for query
         $u_id = $_SESSION['id'];
         
        //build the query
        $query = "UPDATE users SET name = '$name', email = '$email', address_line_1 = '$address_line_1', address_line_2 = '$address_line_2', address_line_3 = '$address_line_3', postcode = '$postcode', dob = '$dob', phone_no = '$phone_no' WHERE id = '$u_id' ";

        //if the query is successful then store all the inputs into session variables to update the users session information
        if(mysqli_query($db, $query)) {
            array_push($success, "Updated Details Successfully");
            $_SESSION['u_name'] = $name;
            $_SESSION['u_email'] = $email;
            $_SESSION['u_address_line_1'] = $address_line_1;
            $_SESSION['u_address_line_2'] = $address_line_2;
            $_SESSION['u_address_line_3'] = $address_line_3;
            $_SESSION['u_postcode'] = $postcode;
            $_SESSION['u_dob'] = $dob;
            $_SESSION['u_phone_no'] = $phone_no;
        }
        else {
            //if the query doesnt succeed, add an error to the error array
            array_push($errors, "Error Updating User");
            
        }

    }
}

//change password
if (isset($_POST['submit-password'])) {
    
    //localise users id for query compatibility
    $u_id = $_SESSION['id'];
    
    //store form data into local variables using escape string to prevent sql injection
    $currentpassword = mysqli_real_escape_string($db, $_POST['current-password']);
    $newpassword = mysqli_real_escape_string($db, $_POST['new-password']);
    $confirmnewpassword = mysqli_real_escape_string($db, $_POST['confirm-new-password']);
    
    //store session password into local variable for checking
    $password_hash = $_SESSION['u_password'];
    
    //verify whether the current password they've entered matches the passowrd stored in db
    $password_verify = password_verify($currentpassword, $password_hash);
        
    //if the password does match
    if ($password_verify){
        
        if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$newpassword)) {// check new password against existing password criteria
            
            //push error into error array if it does not meet criteria
            array_push($errors, "Password must contain an uppercase, lowercase, number or special character and a minimum of 8 characters");
        
        }
        
        //if the password meets criteria, check new password against confirmation password
        if($newpassword == $confirmnewpassword) {
            
            //if passwords match then re-hash the new password
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
            
            //build the query
            $query = "UPDATE users SET password='$hashed_password' WHERE id='$u_id'";
            
            //if the query is successful
            if(mysqli_query($db, $query)) {
                
                //push success string into array
                array_push($success, "Updated Password Successfully!");
                
            }
        } else {
            
            //if the passwords do not match then update the error array
            array_push($errors, "Failed Password Update");
            
        }
        
    } else {
        //if current password does not match hashed password update error array
        array_push($errors, "Failed Password Hash");
        
    }
}

//delete button process
if (isset($_POST['delete'])) {

    //localise user session id  
    $u_id = $_SESSION['id'];

    //build query
    $query = "DELETE FROM users WHERE id=$u_id";
    
    //if the query is successful
    if (mysqli_query($db, $query)) {
        
        //set success session variable to string
        $_SESSION['success'] = "Deleted account";
        
        //destroy session
        session_destroy();
        
        //unset all session variables
        session_unset;
        
        //locate the user to index page
        header("location: index.php");
    } else {
        
        //if the query is unsuccessful add error to error array
        array_push($errors, "Error deleting account");
    }

}
?>