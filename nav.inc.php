<nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
        <img src="assets/small-logo.png" width="30" height="30" alt=""> CarCat.
        </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul data-aos="fade-down" class="navbar-nav navbar-right">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogue.php">Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <?php if (!isset($_SESSION['id'])) { ?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php } else { ?>
                        <a class="nav-link" href="editdetails.php">Edit Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="catalogue.php?logout='1'">Logout</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
</nav>