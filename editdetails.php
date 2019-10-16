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
    
    <body>

        <?php include_once 'nav.inc.php'; ?>

        <div class="container">
            <div class="wrapper">
                <form role="form" method="POST" action="editdetails.php" name="editform" class="form-signin text-center">
                    <img id="carcat-logo-small" class="mb-4" src="assets/small-logo.png" alt="small-logo-carcat" width="72" height="72">
                    <h1 class="h1 mb-3 font-weight-normal welcome-text">CarCat.</h1>

                    <?php include ('errors.php'); ?>
                    
                    <label for="inputName" class="sr-only">Name</label>
                    <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" value="<?php echo $_SESSION['u_name']; ?>" required autofocus>

                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $_SESSION['u_email']; ?>" required autofocus>
                    
                    <label for="inputAddress1" class="sr-only">Address Line 1</label>
                    <input type="text" name="address_line_1" id="inputAdress1" class="form-control" placeholder="House Number/Name" value="<?php echo $_SESSION['u_address_line_1']; ?>" required>

                    <label for="inputAddress2" class="sr-only">Address Line 2</label>
                    <input type="text" name="address_line_2" id="inputAddress2" class="form-control" placeholder="Town" value="<?php echo $_SESSION['u_address_line_2']; ?>" required>
                    
                    <label for="inputAddress3" class="sr-only">Address Line 3</label>
                    <input type="text" name="address_line_3" id="inputAddress3" class="form-control" placeholder="City" value="<?php echo $_SESSION['u_address_line_3']; ?>" required>

                    <label for="inputPostcode" class="sr-only">Postcode</label>
                    <input type="text" name="postcode" id="inputPostcode" class="form-control" placeholder="Postcode" value="<?php echo $_SESSION['u_postcode']; ?>" required>

                    <label for="inputDob" class="sr-only">Date of Birth</label>
                    <input type="date" name="dob" id="inputDob" class="form-control" placeholder="Date of Birth" value="<?php echo $_SESSION['u_dob']; ?>" required>

                    <label for="inputPhoneNo" class="sr-only">Phone Number</label>
                    <input type="text" name="phone_no" id="inputPhoneNo" class="form-control" placeholder="Phone Number" value="<?php echo $_SESSION['u_phone_no']; ?>" required>

                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="edit" value="Edit">Save</button>
                    <p class="mt-2 mb-2 text-muted">CarCat&copy; 2019. All Rights Reserved.</p>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
    </body>
</html>
