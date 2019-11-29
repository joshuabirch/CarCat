<?php 
//include main php file 
include_once 'server.php';
//localise session id
$u_id = $_SESSION['id'];
//localise profile image
$profile_img = $_SESSION['u_profile_img'];
//if the session id isnt set then the user isn't logged in, send them back to login 
if(!isset($_SESSION['id'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
//if the user clicks the logout link, destroy the session and log them out
if(isset($_GET['logout'])){
    session_destroy();
    session_unset;
    header("location: login.php");
}

/* This sets the $time variable to the current hour in the 24 hour clock format */
$time = date("H");
/* Set the $timezone variable to become the current timezone */
$timezone = date("GMT");
/* If the time is less than 1200 hours, show good morning */
if ($time < "12") {
    $msg = "Good Morning";
} else
/* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
if ($time >= "12" && $time < "17") {
    $msg = "Good Afternoon";
} else
/* Should the time be between or equal to 1700 and 1900 hours, show good evening */
if ($time >= "17" && $time < "19") {
    $msg = "Good Evening";
} else
/* Finally, show good night if the time is greater than or equal to 1900 hours */
if ($time >= "19") {
    $msg = "Good Night";
}

?>
<!doctype html>
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

    <!-- main css file -->
    <link rel="stylesheet" href="css/profile.css">

    <!-- aos animation css -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


</head>

<body>
    
    
    <!-- navbar includes -->
    <?php include_once 'nav.inc.php'; ?>

    <!-- content start -->   
    <div id="content" class="content">
        <div class="row">
            <div class="col">
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="error success">
                        <h1 id="welcome-text" class="text-center">
                            <?php
                                if(isset($_SESSION['id'])) : ?>
                                    <?php echo $msg; ?>,&nbsp;<?php echo $_SESSION['u_name']; ?>!
                            <?php endif ?>
                        </h1>
                        <p class="text-center supp-text">Want to edit your profile?</p>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar full height -->
                <div class="col-md-3 border-right bg-grey">
                    <div id="list-group" class="list-group list-group-flush pt-2 border-0 bg-transparent">
                        <a class="list-group-item list-group-item-action border-0 rounded bg-transparent" href="#edit-user-details"><i class="fas fa-user-edit"></i>&nbsp;Edit Your Details</a>
                        <a class="list-group-item list-group-item-action border-0 rounded bg-transparent" href="#change-password"><i class="fas fa-key"></i>&nbsp;Change Password</a>
                        <a class="list-group-item list-group-item-action border-0 rounded bg-transparent" href="#favourite-cars"><i class="fas fa-heart"></i>&nbsp;See Favourite Cars</a>
                        <a class="list-group-item list-group-item-action border-0 rounded bg-transparent" href="#delete-account"><i class="fas fa-user-minus"></i>&nbsp;Delete Account</a>
                        <a class="list-group-item list-group-item-action border-0 rounded bg-transparent" href="profile.php?logout=1"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                    </div>
                </div>
                <!-- main forms -->
                <div class="col-md-9">
                <!-- include both error and success file for updating details -->
                <div class="mt-2 mb-2"><?php include_once 'errors.php'; ?></div>
                <div class="mt-2 mb-2"><?php include_once 'success.php'; ?></div>
                
                <?php
                
                    //localise address line 1
                    $u_address_line_1 = $_SESSION['u_address_line_1'];
                    //if it is blankm, they have not entered all their details
                    if ($u_address_line_1 == "") {
                        //display an exclamation mark to tell the user they have further details to enter
                        echo "<div class='mt-2 mb-2 alert alert-info'>
                                <i class='fas fa-exclamation-circle'></i>&nbsp;Please complete your details!
                            </div>";
                    }
                ?>

                <!--Edit User Details Title -->
                <div id="edit-user-details" class="row">
                    <div class="col">
                        <h1 class="form-title">Edit Your Details</h1>
                    </div>
                </div>

                <!--Edit User Details -->
                <div class="row">
                    <div class="col">
                        <!-- build form & use htmlspecialchars with php server self to prevent js penetration -->
                        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-edituser">

                            <div class="input-group">
                                <label for="inputName" class="sr-only">Name</label>
                                <input type="text" name="name" id="inputName" class="form-control rounded-top" placeholder="Name" value="<?php echo $_SESSION['u_name']; ?>" required >

                                <label for="inputEmail" class="sr-only">Email address</label>
                                <input type="email" name="email" id="inputEmail" class="form-control rounded-top" placeholder="Email address" value="<?php echo $_SESSION['u_email']; ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="inputAddress1" class="sr-only">Address Line 1</label>
                                <input type="text" name="address_line_1" id="inputAddress1" class="form-control rounded-0" placeholder="House Number/Name" value="<?php echo $_SESSION['u_address_line_1']; ?>" required>
                            </div>
                            <div class="input-group">
                                <label for="inputAddress2" class="sr-only">Address Line 2</label>
                                <input type="text" name="address_line_2" id="inputAddress2" class="form-control rounded-0" placeholder="Town" value="<?php echo $_SESSION['u_address_line_2']; ?>" required>
                
                                <label for="inputAddress3" class="sr-only">Address Line 3</label>
                                <input type="text" name="address_line_3" id="inputAddress3" class="form-control rounded-0" placeholder="City" value="<?php echo $_SESSION['u_address_line_3']; ?>" required>
                            </div>

                            <label for="inputPostcode" class="sr-only">Postcode</label>
                            <input type="text" name="postcode" id="inputPostcode" class="form-control rounded-0" placeholder="Postcode" value="<?php echo $_SESSION['u_postcode']; ?>" required>

                            <label for="inputDob" class="sr-only">Date of Birth</label>
                            <input type="date" name="dob" id="inputDob" class="form-control rounded-0" value="<?php echo $_SESSION['u_dob']; ?>" required>

                            <label for="inputPhoneNo" class="sr-only">Phone Number</label>
                            <input type="text" name="phone_no" id="inputPhoneNo" class="form-control rounded-bottom" placeholder="Phone Number" value="<?php echo $_SESSION['u_phone_no']; ?>" required>

                            <button type="submit" name="edit" class="btn btn-submit mt-2"><i class="fas fa-save"></i>&nbsp;Save</button>
                        </form>
                    </div>
                </div>

                <hr>
                
                <!-- Change Password Title -->
                <div id="change-password" class="row">
                    <div class="col">
                        <h1 class="form-title">Change Password</h1>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <form role="form" name="change-password" class="change-password" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            
                            <label for="currentPassword" class="sr-only">Current Password</label>
                            <input type="password" name="current-password" id="currentPassword" class="form-control rounded-top" placeholder="Current Password" required>
                            
                            <label for="newPassword" class="sr-only">New Password</label>
                            <input type="password" name="new-password" id="newPassword" class="form-control rounded-0" placeholder="New Password" rel="txtTooltip" title="At least 1 letter, 1 number, special characters and 8-12 characters" data-toggle="tooltip" data-placement="bottom" required>
                            
                            <label for="confirmNewPassword" class="sr-only">New Password</label>
                            <input type="password" name="confirm-new-password" id="confirmNewPassword" class="form-control rounded-bottom" placeholder="Confirm New Password" required>
                            
                            <button type="submit" name="submit-password" class="btn btn-submit mt-2"><i class="fas fa-save"></i>&nbsp;Save</button>
                        </form>
                    </div>
                </div>
                
                <hr>

                <!-- Favourite Cars Title -->
                <div id="favourite-cars" class="row">
                    <div class="col">
                        <h1 class="form-title">See Your Favourite Cars</h1>
                    </div>
                </div>

                <!-- Favourite Cars -->
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <?php 
                            //inner join sql query to select all favourited cars from current user exclusively 
                            $query = "SELECT favourited_cars.car_id, cars.* FROM favourited_cars INNER JOIN cars ON favourited_cars.car_id = cars.id WHERE user_id = '$u_id'";
                            $results = mysqli_query($db, $query);
                            $queryResults = mysqli_num_rows($results);

                            if ($queryResults > 0) {

                                while ($row = mysqli_fetch_assoc($results)) {
                                    echo 
                                    //build cards
                                    "<div class='col-md-4'>
                                        <div class='card mb-1'>
                                            <div class='row no-gutters'>
                                                <div class='col-md-4'>
                                                    <img alt='car-image' src='".$row['image']."' class='card-img' width='100'>
                                                </div>

                                                <div class='col-md-8'>
                                                    <div class='card-body'>
                                                        <h5 class='card-title text-capitalize'>".$row['manufacturer'].' '.$row['model']."</h5>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "<div class='ml-3'>You have no favourited cars!</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Delete Account Title -->
                <div id="delete-account" class="row">
                    <div class="col">
                        <h1 class="form-title">Delete Your Account</h1>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="row">
                    <div class="col pb-2">
                        <form role="form" name="delete-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <button class="btn btn-delete mt-2 mb-2" name="delete" value="delete" type="submit"><i class="fas fa-user-minus"></i>&nbsp;Delete</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- include footer -->
    <?php include_once 'footer.php'; ?>

    <!-- main js includes -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script defer src="js/all.js"></script>
    
    <!-- initialise tooltip -->
    <script>

        $(document).ready(function() {
            $('input[rel="txtTooltip"]').tooltip();
        });

    </script>

    <!-- smooth scroll js -->    
    <script>
        // Select all links with hashes
        $('a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function(event) {
         // On-page links
        if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
        && 
        location.hostname == this.hostname
        ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
    });
    </script>
    
</body>
</html>

