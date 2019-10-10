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
        if ($user['name'] == $name) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] == $email) {
            array_push($errors, "email already exists");
        }
    }

    //Permitting no errors in the array, the user can be added to the database
    if (count($errors) == 0) {
        $password = md5($password); //hash password for security

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
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if(empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if(count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            $_SESSION['id'] = $row['id'];
            $_SESSION['u_name'] = $row['name'];
            $_SESSION['success'] = "You Are Logged In";
            header('location: catalogue.php');
        }else {
            array_push($errors, "Wrong Email/Password");
        }
    }
}

?>