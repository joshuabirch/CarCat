<?php
//include main php file
include_once 'server.php';

//if the session id is set then send them back to the catalogue page as they do not need to access this page while logged in
if(isset($_SESSION['id'])) {
    header('location: catalogue.php');
}


?>

<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <!-- viewport responsiveness -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>CarCat.</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- main font link -->
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

        <!-- main css file -->
        <link rel="stylesheet" href="css/style.css">
        
    </head>
    
    <body>

        <?php include_once 'nav.inc.php'; ?>

        <div class="container">
            <div class="wrapper">
                <!-- build form & use htmlspecialchars and php server self to deny js injection -->
                <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="signupform" class="form-signin text-center">
                    <img id="carcat-logo-small" class="mb-4" src="assets/small-logo.png" alt="small-logo-carcat" width="72" height="72">
                    <h1 class="h1 mb-3 font-weight-normal welcome-text">CarCat.</h1>
                    
                    <!-- include errors file -->
                    <?php include ('errors.php'); ?>
                    
                    <label for="inputName" class="sr-only">Name</label>
                    <input type="text" name="name" id="inputName" class="form-control rounded-top" placeholder="Name" value="<?php echo $name;?>" required autofocus>

                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" name="email" id="inputEmail" class="form-control rounded-0" placeholder="Email address" value="<?php echo $email; ?>" required autofocus>

                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control rounded-0" placeholder="Password" rel="txtTooltip" title="At least 1 letter, 1 number, special characters and 8-12 characters" data-toggle="tooltip" data-placement="right" required>
                    
                    <label for="inputCPassword" class="sr-only">Confirm Password</label>
                    <input type="password" name="cpassword" id="inputCPassword" class="form-control rounded-bottom" placeholder="Confirm Password" required>

                    
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="signup" value="Sign Up">Sign Up</button>
                    <p class="p-3">Already have an account? Login <a href="login.php">here</a></p>
                    <p class="mt-1 mb-0 text-muted">CarCat&copy; 2019. All Rights Reserved.</p>
                </form>
            </div>
        </div>
        
        <!-- main js includes -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="js/all.js"></script>

        <!-- initialise tooltip -->
        <script>
            $(document).ready(function() {
                $('input[rel="txtTooltip"]').tooltip();
            });
        </script>
    </body>
</html>
