<?php

include_once 'server.php';


?>

<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>CarCat</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap" rel="stylesheet">



        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
        </style>

        <link rel="stylesheet" href="css/style.css">
        
    </head>
    
    <body class="text-center">
        <form role="form" method="POST" action="register.php" name="signupform" class="form-signin">
            <img id="carcat-logo-small" class="mb-4" src="assets/small-logo.png" alt="small-logo-carcat" width="72" height="72">
            <h1 class="h1 mb-3 font-weight-normal welcome-text">CarCat.</h1>

            <?php include ('errors.php'); ?>
            
            <label for="inputName" class="sr-only">Name</label>
            <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" value="<?php echo $name;?>" required autofocus>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $email; ?>" required autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            
            <label for="inputCPassword" class="sr-only">Confirm Password</label>
            <input type="password" name="cpassword" id="inputCPassword" class="form-control" placeholder="Confirm Password" required>
            

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup" value="Sign Up">Sign in</button>
            <p class="p-3">Already have an account? Login <a href="login.php">here</a></p>
            <p class="mt-5 mb-3 text-muted">CarCat&copy; 2019. All Rights Reserved.</p>
        </form>

        
    </body>
</html>