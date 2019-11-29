<?php

include_once 'server.php';

$u_id = $_SESSION['id'];

$error = "";

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

if (isset($_POST['fave'])) {
    echo "faved";
    $u_id = $_SESSION['id'];
    $car_id = $_POST['car_id'];
    mysqli_query($db, "INSERT INTO favourited_cars (user_id, car_id) VALUES ($u_id, $car_id)");
  } else {
      //array_push($errors, "Error Favouriting Car");
  }

  if (isset($_POST['unfave'])) {
    echo "unfaved";
    $u_id = $_SESSION['id'];
    $car_id = $_POST['car_id'];
    mysqli_query($db, "DELETE FROM favourited_cars WHERE user_id=$u_id AND car_id=$car_id");
} else {
    //array_push($errors, "Error Unfavouriting Car");
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
                            <p class="text-center supp-text">What are you looking for?</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <div id="search-area" class="container">
            <div class="row">
                <div class="col-12 p-3">
                    <form class="searchform" name="searchform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input id="inputSearch" type="text" name="search" placeholder="Ford, BMW, Petrol, Red..." autofocus>
                        <button id="searchBtn" type="submit" name="submit_search"><i class="fas fa-search fa-lg text-white"></i></button>

                        <?php

                            if (isset($_POST['submit_search'])) {
                                $search = mysqli_real_escape_string ($db, $_POST['search']);

                                if($search != "") {
                                    $save_search = "INSERT INTO save_search (save_string, user_id) VALUES ('$search', '$u_id')";
                                    $save_search_query = mysqli_query($db, $save_search);
                                }
                                
                            } else if (isset($_POST['delete_recent_search'])) {

                                $recent_search = mysqli_real_escape_string($db, $_POST['delete_recent_search']);
                                $query = "DELETE FROM save_search WHERE save_string = '$recent_search'";
                                mysqli_query($db, $query);
                            
                            }

                            $query = "SELECT * FROM save_search WHERE user_id = '$u_id' ORDER BY id desc LIMIT 5";
                            $results = mysqli_query ($db, $query);
                            $queryResults = mysqli_num_rows ($results);

                            if ($queryResults > 0) {

                                while ($row = mysqli_fetch_assoc($results)) {

                                    $recent_search = $row['save_string'];

                                    echo "<button type='submit' value='$recent_search' name='recent_search' class='btn btn-save-search pt-1 pb-1 pl-2 pr-2 mt-3 rounded-left'>".$row['save_string']." </button> <button class='btn btn-delete-search pt-1 pb-1 pl-2 pr-2 mr-1 mt-3 ml-0 rounded-right' type='submit' name='delete_recent_search' value='$recent_search'><i class='fas fa-times-circle text-white align-text-bottom'></i></button>";
                                }
                            }
                    
                        ?>
                    </form>
                </div>
            </div>
            <!-- <div class="row"> -->
                <!-- <div class="col mb-3"> -->
                    <?php

                    
                    ?>

                    
                <!-- </div> -->
            <!-- </div> -->
            <div class="row">
                <?php 

                if (isset($_POST['recent_search'])) {

                    $search = mysqli_real_escape_string ($db, $_POST['recent_search']);
                    $query = "SELECT * FROM cars WHERE manufacturer LIKE '%$search%' OR model LIKE '%$search%' OR car_year LIKE '%$search%' OR fuel_type LIKE '%$search%' OR engine_capacity LIKE '%$search%' OR colour LIKE '%$search%'";
                    $results = mysqli_query($db, $query);
                    $queryResults = mysqli_num_rows($results);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($results)) {
                            echo "<div class='col-md-4 mb-4'>
                            <div data-aos='flip-left' class='card'>
                                <img src='".$row['image']."' class='card-img-top' alt='...'>
                                <div class='card-body'>
                                    <h3 class='card-title'>".$row['manufacturer'] . ' ' . $row['model']."</h3>
                                    <div class='row'>
                                        <div class='col-6 p-2'>
                                            <p class='card-text'><i class='fas fa-calendar-check'></i> ".$row['car_year']."</p>
                                        </div>
                                        <div class='col-md-6 p-2'>
                                            <p class='card-text'><i class='fas fa-gas-pump'></i> ".$row['fuel_type']."</p>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-6 p-2'>
                                            <p class='card-text'><i class='fas fa-tachometer-alt'></i> ".$row['engine_capacity']."</p>
                                        </div>
                                        <div class='col-6 p-2'>    
                                            <p class='card-text'><i class='fas fa-tint'></i> ".$row['colour']."</p>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-12'>";
                                        $fav_query = mysqli_query($db, "SELECT * FROM favourited_cars WHERE user_id=".$_SESSION['id']." AND car_id=".$row['id']."");

                                        if (mysqli_num_rows($fav_query) == 1) {
                                        echo "<button data-id=".$row['id']." href='#' id='favBtn' class='unfave lock btn btn-primary mt-3 w-100'>
                                                <i class='fas fa-heart icon-unlock'></i>
                                                <i class='fas fa-minus icon-lock'></i>
                                            </button>
                                            <button data-id=".$row['id']." href='#' id='favBtn' class='fave hidden lock btn btn-primary mt-3 w-100'>
                                                <i class='far fa-heart icon-unlock'></i>
                                                <i class='fas fa-plus icon-lock'></i>
                                            </button>";
                                        } else {
                                            echo "<button data-id=".$row['id']." href='#' id='favBtn' class='unfave hidden lock btn btn-primary mt-3 w-100'>
                                                <i class='fas fa-heart icon-unlock'></i>
                                                <i class='fas fa-minus icon-lock'></i>
                                            </button>
                                            <button data-id=".$row['id']." href='#' id='favBtn' class='fave lock btn btn-primary mt-3 w-100'>
                                                <i class='far fa-heart icon-unlock'></i>
                                                <i class='fas fa-plus icon-lock'></i>
                                            </button>";
                                        }
                                        echo '
                                            <input hidden value='.$row['id'].'>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                        }
                    }
                }
                
                else if (!isset($_POST['submit_search'])) {
                        $query = "SELECT * FROM cars";
                        $results = mysqli_query($db, $query);
                        $queryResults = mysqli_num_rows($results);

                        if ($queryResults > 0) {
                            
                            while ($row = mysqli_fetch_assoc($results)) {


                                echo "<div class='col-md-4 mb-4'>
                                <div data-aos='flip-left' class='card'>
                                    <img src='".$row['image']."' class='card-img-top' alt='...'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>".$row['manufacturer'] . ' ' . $row['model']."</h3>
                                        <div class='row'>
                                            <div class='col-6 pb-3'>
                                                <p class='card-text'><i class='fas fa-calendar-check'></i> ".$row['car_year']."</p>
                                            </div>
                                            <div class='col-6 pb-3'>
                                                <p class='card-text'><i class='fas fa-gas-pump'></i> ".$row['fuel_type']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-6 pb-3'>
                                                <p class='card-text'><i class='fas fa-tachometer-alt'></i> ".$row['engine_capacity']."</p>
                                            </div>
                                            <div class='col-6 pb-3'>    
                                                <p class='card-text'><i class='fas fa-tint'></i> ".$row['colour']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-12'>";
                                            $fav_query = mysqli_query($db, "SELECT * FROM favourited_cars WHERE user_id=".$_SESSION['id']." AND car_id=".$row['id']."");

                                            if (mysqli_num_rows($fav_query) == 1) {
                                               echo "<button data-id=".$row['id']." id='favBtn' class='unfave lock btn btn-primary mt-3 w-100'>
                                                    <i class='fas fa-heart icon-unlock'></i>
                                                    <i class='fas fa-minus icon-lock'></i>
                                                </button>
                                                <button data-id=".$row['id']."  id='favBtn' class='fave hidden lock btn btn-primary mt-3 w-100'>
                                                    <i class='far fa-heart icon-unlock'></i>
                                                    <i class='fas fa-plus icon-lock'></i>
                                                </button>";
                                            } else {
                                                echo "<button data-id=".$row['id']." id='favBtn' class='unfave hidden lock btn btn-primary mt-3 w-100'>
                                                    <i class='fas fa-heart icon-unlock'></i>
                                                    <i class='fas fa-minus icon-lock'></i>
                                                </button>
                                                <button data-id=".$row['id']." id='favBtn' class='fave lock btn btn-primary mt-3 w-100'>
                                                    <i class='far fa-heart icon-unlock'></i>
                                                    <i class='fas fa-plus icon-lock'></i>
                                                </button>";
                                            }
                                            echo '
                                                <input hidden value='.$row['id'].'>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
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
                                <div data-aos='flip-left' class='card'>
                                    <img src='".$row['image']."' class='card-img-top' alt='...'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>".$row['manufacturer'] . ' ' . $row['model']."</h3>
                                        <div class='row'>
                                            <div class='col-6 p-2'>
                                                <p class='card-text'><i class='fas fa-calendar-check'></i> ".$row['car_year']."</p>
                                            </div>
                                            <div class='col-6 p-2'>
                                                <p class='card-text'><i class='fas fa-gas-pump'></i> ".$row['fuel_type']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-6 p-2'>
                                                <p class='card-text'><i class='fas fa-tachometer-alt'></i> ".$row['engine_capacity']."</p>
                                            </div>
                                            <div class='col-6 p-2'>    
                                                <p class='card-text'><i class='fas fa-tint'></i> ".$row['colour']."</p>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-12'>";
                                            $fav_query = mysqli_query($db, "SELECT * FROM favourited_cars WHERE user_id=".$_SESSION['id']." AND car_id=".$row['id']."");

                                            if (mysqli_num_rows($fav_query) == 1) {
                                               echo "<button data-id=".$row['id']." href='#' id='favBtn' class='unfave lock btn btn-primary mt-3 w-100'>
                                                    <i class='fas fa-heart icon-unlock'></i>
                                                    <i class='fas fa-minus icon-lock'></i>
                                                </button>
                                                <button data-id=".$row['id']." href='#' id='favBtn' class='fave hidden lock btn btn-primary mt-3 w-100'>
                                                    <i class='far fa-heart icon-unlock'></i>
                                                    <i class='fas fa-plus icon-lock'></i>
                                                </button>";
                                            } else {
                                                echo "<button data-id=".$row['id']." href='#' id='favBtn' class='unfave hidden lock btn btn-primary mt-3 w-100'>
                                                    <i class='fas fa-heart icon-unlock'></i>
                                                    <i class='fas fa-minus icon-lock'></i>
                                                </button>
                                                <button data-id=".$row['id']." href='#' id='favBtn' class='fave lock btn btn-primary mt-3 w-100'>
                                                    <i class='far fa-heart icon-unlock'></i>
                                                    <i class='fas fa-plus icon-lock'></i>
                                                </button>";
                                            }
                                            echo '
                                                <input hidden value='.$row['id'].'>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                                }
                            }
                        }  else {
                            echo "There are no search results";
                        }

                        
                    

                ?>

            </div>
        </div>
    </div>


    <?php include_once 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script defer src="js/all.js"></script>
    
    <script>
        $(document).ready(function () {
    var path = window.location.pathname;
    var page = path.split("/").pop();

    // when the user clicks on the fave button
    $('.fave').on('click', function () {
      var carid = $(this).data('id');
      $car = $(this);

      $.ajax({
        url: page,
        type: 'post',
        data: {
          'fave': 1,
          'car_id': carid
        },
        success: function (response) {
          $car.addClass('hidden');
          $car.siblings().removeClass('hidden');
        }
      });
    });

    // when the user clicks on unfave
    $('.unfave').on('click', function () {
      var carid = $(this).data('id');
      $car = $(this);

      $.ajax({
        url: page,
        type: 'post',
        data: {
          'unfave': 1,
          'car_id': carid
        },
        success: function (response) {
          $car.addClass('hidden');
          $car.siblings().removeClass('hidden');
        }
      });
    });
  });
    </script>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>
</html>