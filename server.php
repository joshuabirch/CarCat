<?php
session_start();

//initialise variables

$name = "";
$email = "";
$errors = array();

//connect to database

$db = mysqli_connect ('localhost', 'root', '','CarCat');

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
            array_push($errors, "Username already exists");
        }

        if ($user['email'] == $email) { //check to see if theres an email matched with the input
            array_push($errors, "email already exists");
        }

        if (!preg_match("/^[a-zA-Z]+$/",$name)) { //check to see if the name has any numbers and special characters
            array_push($errors, "Name must only contain letters and spaces");
        }

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { //check the validation of email
            array_push($errors, "Enter a Valid Email");
        }

        if (strlen($password) < 6) { //check the length of the password
            array_push($errors, "Password must a minimum of 6 characters");
        }
    }
    

    //Permitting no errors in the array, the user can be added to the database
    if (count($errors) == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT); //hash password for security

        $query = "INSERT INTO users (name, email, password) 
                    VALUES ('$name', '$email', '$password')";

        mysqli_query($db, $query);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['success'] = "Welcome! You're Logged In";
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
        //de-hash the password
        // build the query
        $query = "SELECT * FROM users WHERE email='$email'";
        //return the results via integer in the variable
        $results = mysqli_query($db, $query);
        // if the integer is exactly 1
        if (mysqli_num_rows($results) == 1) {
            //create an array of the result
            
            
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

            $password_hash = $row['password'];

            if (password_verify($password, $password_hash)) {
                // store database result into session variables
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
                $_SESSION['success'] = "You Are Logged In";
                //send the user to the catalogue
                header('location: catalogue.php');
            } else {
                
                array_push($errors, $password_hash);
            }
            
        } else {
            //if the integer is 0 then the user has entered the wrong email or password
            array_push($errors, "Wrong Email/Password 2");
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

    //build the query
    $query = "UPDATE users SET name = '$name', email = '$email', address_line_1 = '$address_line_1', address_line_2 = '$address_line_2', address_line_3 = '$address_line_3', postcode = '$postcode', dob = '$dob', phone_no = '$phone_no' WHERE id = '$_SESSION[id]' ";

    //if the query is successful then store all the inputs into session variables to update the users session information
    if(mysqli_query($db, $query)) {
        $_SESSION['success'] = "Updated Details Successfully";
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

?>