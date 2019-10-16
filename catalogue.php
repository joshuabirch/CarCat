<?php

include_once 'server.php';

if(!isset($_SESSION['id'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if(isset($_GET['logout'])){
    session_destroy();
    session_unset;
    header("location: login.php");
}

/* This sets the $time variable to the current hour in the 24 hour clock format */
$time = date("H");
/* Set the $timezone variable to become the current timezone */
$timezone = date("e");
/* If the time is less than 1200 hours, show good morning */
if ($time < "12") {
    $msg = "Good morning";
} else
/* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
if ($time >= "12" && $time < "17") {
    $msg = "Good afternoon";
} else
/* Should the time be between or equal to 1700 and 1900 hours, show good evening */
if ($time >= "17" && $time < "19") {
    $msg = "Good evening";
} else
/* Finally, show good night if the time is greater than or equal to 1900 hours */
if ($time >= "19") {
    $msg = "Good night";
}

?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>CarCat</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/catalogue.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


</head>

<body>
    
    <?php include_once 'nav.inc.php'; ?>

   
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="error success">
                            <h1>
                                <?php
                                    if(isset($_SESSION['id'])) : ?>
                                        <p id="welcome-text" class="text-center"><?php echo $msg; ?>&nbsp;<strong><?php echo $_SESSION['u_name']; ?>!</strong></p>
                                <?php endif ?>
                            </h1>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-3">
                    <form class="searchform" name="searchform" method="POST" action="catalogue.php">
                        <input id="inputSearch" type="text" name="search" placeholder="Ford, BMW, Petrol, Red..." required autofocus>
                        <button id="searchBtn" type="submit" name="submit_search"><i class="fas fa-search fa-lg text-white"></i></button>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php 

                    if (!isset($_POST['submit_search'])) {
                        $query = "SELECT * FROM cars";
                        $results = mysqli_query($db, $query);
                        $queryResults = mysqli_num_rows($results);

                        if ($queryResults > 0) {
                            
                            while ($row = mysqli_fetch_assoc($results)) {

                                echo "<div class='col-md-4 mb-4'>
                                <div class='card'>
                                    <img src='".$row['image']."' class='card-img-top' alt='...'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>".$row['manufacturer'] . ' ' . $row['model']."</h5>
                                        <div class='row'>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-calendar-check'></i> ".$row['car_year']."</p>
                                            </div>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-gas-pump'></i> ".$row['fuel_type']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-tachometer-alt'></i> ".$row['engine_capacity']."</p>
                                            </div>
                                            <div class='col-md-6 p-2'>    
                                                <p class='card-text'><i class='fas fa-tint'></i> ".$row['colour']."</p>
                                            </div>
                                        </div>
                                        <a href='#' id='favBtn' class='btn btn-primary mt-3'>I Like This!</a>
                                    </div>
                                </div>
                            </div>";
                            }
                        }
                    } else if (isset($_POST['submit_search'])) {
                        $search = mysqli_real_escape_string ($db, $_POST['search']);
                        $query = "SELECT * FROM cars WHERE manufacturer LIKE '%$search%' OR model LIKE '%$search%' OR car_year LIKE '%$search%' OR fuel_type LIKE '%$search%' OR engine_capacity LIKE '%$search%' OR colour LIKE '%$search%'";
                        $results = mysqli_query($db, $query);
                        $queryResults = mysqli_num_rows($results);

                        

                        if ($queryResults > 0) {
                            while ($row = mysqli_fetch_assoc($results)) {
                                echo "<div class='col-md-4 mb-4'>
                                <div class='card'>
                                    <img src='".$row['image']."' class='card-img-top' alt='...'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>".$row['manufacturer'] . ' ' . $row['model']."</h5>
                                        <div class='row'>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-calendar-check'></i> ".$row['car_year']."</p>
                                            </div>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-gas-pump'></i> ".$row['fuel_type']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6 p-2'>
                                                <p class='card-text'><i class='fas fa-tachometer-alt'></i> ".$row['engine_capacity']."</p>
                                            </div>
                                            <div class='col-md-6 p-2'>    
                                                <p class='card-text'><i class='fas fa-tint'></i> ".$row['colour']."</p>
                                            </div>
                                        </div>
                                        <a href='#' id='favBtn' class='btn btn-primary mt-3'>I Like This!</a>
                                    </div>
                                </div>
                            </div>";
                            }
                        } else {
                            echo "There are no search results";
                        }
                    }

                ?>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="js/all.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>