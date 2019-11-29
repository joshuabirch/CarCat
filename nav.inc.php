<!-- Sidenav build -->
<div id="mySidenav" class="sidenav">
    <div class="user-info">
    <a href="javascript:void(0)" class="btn closebtn float-right" onclick="closeNav()"><i class="fas fa-times fa-lg"></i></a>
        <!-- Display user info for personalised greeting -->
        <img alt="profile image" src="<?php echo $_SESSION['u_profile_img'];?>" class="profile-img-nav">
        <h1>Hi, <?php echo $_SESSION['u_name']; ?></h1>
        <p><?php echo $_SESSION['u_email']; ?></p>
    </div>
    <a href="profile.php"><i class="fas fa-user-cog"></i>&nbsp;Your Profile</a>
    <a href="profile.php#favourite-cars"><i class="fas fa-heart"></i>&nbsp;Favourited Cars</a>
    <a href="profile.php#edit-user-details">
        <?php 
            $u_address_line_1 = $_SESSION['u_address_line_1'];
        
            if ($u_address_line_1 == "") {
                echo "<span><i class='fas fa-exclamation-circle text-white'></i></span>";
            }
        ?>
        <i class="fas fa-user-edit"></i>&nbsp;Edit Account
    </a>
    <a href="profile.php?logout=1"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
</div>

<!-- Main navigation -->
<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
    <img src="assets/small-logo.png" width="30" height="30" alt=""> CarCat.
    </a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="catalogue.php">Catalogue</a>
            </li>
        </ul>
        <!-- If the session id isn't set then display the login link. If it is, display the profile icon -->
        <ul class="navbar-nav ml-auto">
            <?php if (!isset($_SESSION['id'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openNav()">
                        <i class="fas fa-user-circle"></i>
                        <?php 
                            $u_address_line_1 = $_SESSION['u_address_line_1'];
                        
                            if ($u_address_line_1 == "") {
                                echo "<span><i class='fas fa-exclamation-circle text-white'></i></span>";
                            }
                        ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<script>
    
</script>

<!-- open nav JS - push content and navbar by 250px and opacity drop for animation --> 
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("content").style.marginRight = "250px";
  document.getElementById("content").style.opacity = "0.8";

// mobile responsive validation 
  function myFunction(x) {
        if (x.matches) { // If media query matches
            document.getElementById("mySidenav").style.width="100%";
        }
    }
    var x = window.matchMedia("(max-width: 700px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction) // Attach listener function on state changes
}
//close button function
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("content").style.marginRight= "0";
  document.getElementById("content").style.opacity = "1";
}
</script>