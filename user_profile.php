<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: index.php");
}

include "classes/user.php";
$user = new user();
$result = $user -> get_user($_SESSION['username']);
$info = $result -> fetch_array();

?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">


    <title>Bookly | User profile</title>

    <link rel="shortcut icon" href="https://d1r7943vfkqpts.cloudfront.net/ccad7baaa6aea631c4c825c1e3a11921.png"/>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_userprof.css">

    <link href="css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-orange.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="css/_animations.css">
    <link rel="stylesheet" href="css/_colors.css">
    <link rel="stylesheet" href="css/_mixins.css">

    <!-- JS -->
    <script src="js/modernizr.js"></script>
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/prefixfree.min.js"></script>
    <script src="js/footer.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
    <div class="container">
        <a class="navbar-brand fancy-font" href="#">Bookly</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bookly.php">Reviews page</a>
                </li>

                <li class="nav-item btn-group">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Partners
                    </a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="http://www.laguna.rs/">Laguna</a>
                        <a class="dropdown-item" href="http://www.delfi.rs/">Delfi</a>
                    </div>
                </li>
                <?php
                if (isset($_SESSION['username']))
                    if ($user->is_admin($_SESSION['username'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_panel.php">Admin panel</a>
                        </li>
                    <?php } ?>
            </ul>
            <?php
                $current = $_SESSION['username'];
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item btn-group">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $current; ?>&nbsp;</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;View
                                Profile</a>
                            <a class="dropdown-item" href="controllers/logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign
                                Out</a>
                        </div>
                    </li>
                </ul>

        </div>
    </div>
</nav>

<!--/.Navbar-->


<div class="view hm-black-light">
    <div class="full-bg-img">
        <ul class="animated fadeInUp">

            <div class="profile-wrap">
                <div class="profile_pic-wrap">
                    <img id="user-img" src="https://www.menon.no/wp-content/uploads/person-placeholder.jpg" alt="" />
                </div>
                <br>
                <h3>Hello <strong><?php echo $info['username']; ?></strong> this is your profile page. </h3>
                <h5>Here is your profile info:</h5>
                <div class="info-wrap">
                    <p class="user-username"><i class="fa fa-user" aria-hidden="true"></i>  Username: <strong><?php echo $info['username']; ?></strong> </p>
                    <p class="user-mail"><i class="fa fa-envelope" aria-hidden="true"></i> E-mail: <strong> <?php echo $info['email']; ?></strong></p>
                </div>
            </div>
        </ul>
    </div>
</div>

<!--Footer-->
<?php
require "imports/footer.php";
?>
<!--/.Footer-->


<!-- SCRIPTS -->

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

<!-- Bootstrap dropdown -->
<script type="text/javascript" src="js/popper.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/main.js"></script> <!-- Gem jQuery -->
<!--RateYo-->

</body>
</html>