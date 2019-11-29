<?php

//include main php file
include_once 'server.php';


?>
<!doctype html>
<head>
    <meta charset="utf-8">
    
    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>CarCat</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Main font link -->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Black&display=swap" rel="stylesheet">

    <!-- local CSS file -->
    <link rel="stylesheet" href="css/index.css">

    <!-- AOS animation css file -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


</head>

<body>
    
    <!-- include navbar -->
    <?php include_once 'nav.inc.php'; ?>
    
    
    <!-- main content -->
    <div id="content" class="content">
        <div class="container">
            <div data-aos="fade-right" class="wrapper pl-1">
                <h1>Welcome to CarCat.</h1>
                <a role="button" href="register.php" class="btn btn-signup">
                    <?php 
                    //if the session id is set the change text in button to "browse catalogue" instead
                    if (isset($_SESSION['id'])) {
                        echo "Browse Catalogue";
                    } else {
                        echo "Sign Up Today";
                    }
                    ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Include all relevant JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/all.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();//initialise AOS animation data attributes
    </script>

</body>
</html>
