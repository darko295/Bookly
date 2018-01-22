<!DOCTYPE html>
<?php


include "classes/user.php";
$user = new user();


session_start();
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
    <link rel="stylesheet" href="css/jquery.rateyo.css"/>
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
            if (!isset($_SESSION['username'])) {
                ?>
                <form style="margin: -10px">
                    <button class="cd-signin btn btn-info btn-md" type="button" placeholder="Login" value="login">
                        Login
                    </button>
                    <button class="cd-signup btn btn-primary btn-md" id="registration" type="button"
                            placeholder="Sign Up" value="signup">Sign Up
                    </button>
                </form>

                <?php
            } else {
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
                            <a class="dropdown-item" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign
                                Out</a>
                        </div>
                    </li>
                </ul>
            <?php }
            ?>
        </div>
    </div>
</nav>

<!--/.Navbar-->


<div class="cd-user-modal">
    <div class="cd-user-modal-container">
        <ul class="cd-switcher">
            <li style="list-style: none; text-align: center; margin-left: -20px "
            "><a href="#0">Sign in</a></li>
            <li style="list-style: none"><a href="#0">New account</a></li>
        </ul>


        <div id="cd-login"> <!-- log in form -->
            <form class="cd-form" id="login-form" method="post">

                <div id="failed-login"></div>

                <p class="fieldset">
                    <label class="image-replace cd-username" for="signin-username">Username</label>
                    <input class="full-width has-padding has-border" id="signin-username" minlength="3"
                           name="login_username" type="text" placeholder="Username" required>
                    <span class="cd-error-message">Wrong username!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signin-password">Password</label>
                    <input class="full-width has-padding has-border" name="login_password" id="signin-password"
                           minlength="5" type="password" placeholder="Password" required>
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message">Password must be at least 5 chars long.</span>
                </p>


                <p class="fieldset">
                    <input class="full-width-button" id="login-submit" type="button" name="login_submit"
                           onclick="valid_login()" value="Login">
                </p>

                <div class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></div>

            </form>


        </div> <!-- end of login form -->


        <div id="cd-signup"> <!-- sign up form -->
            <form class="cd-form" id="create_form" method="post" action="signup.php">
                <p class="fieldset">
                    <label class="image-replace cd-username" for="signup-username">Username</label>
                    <input class="full-width has-padding has-border" name="create_username" id="signup-username"
                           minlength="3" maxlength="17" type="text" required placeholder="Username">
                <div id="info"></div>

                </p>

                <p class="fieldset">
                    <label class="image-replace cd-email" for="signup-email">E-mail</label>
                    <input class="full-width has-padding has-border" name="create_email" id="signup-email" type="email"
                           minlength="10" required placeholder="E-mail"
                           oninvalid="this.setCustomValidity('Enter your e-mail Here')"
                           oninput="setCustomValidity('')">
                    <span class="cd-error-message">Wrong e-mail format!</span>
                </p>

                <p class="fieldset">
                    <label class="image-replace cd-password" for="signup-password">Password</label>
                    <input class="full-width has-padding has-border" name="create_password" id="signup-password"
                           minlength="5" type="password" required placeholder="Password">
                    <a href="#0" class="hide-password">Show</a>
                    <span class="cd-error-message">Password must be at least 5 chars long!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms" name="create_checkbox" required>
                    <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                </p>

                <p class="fieldset">
                    <input class="full-width-button has-padding" name="create_submit" type="submit"
                           value="Create account">
                </p>
            </form>


        </div> <!-- end of signup form-->

        <div id="cd-reset-password"> <!-- reset password form -->
            <p class="cd-form-message">Lost your password? Please enter your email address. You will receive your
                password.</p>

            <form class="cd-form" method="post" action="password_reset.php">
                <p class="fieldset">
                    <label class="image-replace cd-email" for="reset-email">E-mail</label>
                    <input class="full-width has-padding has-border" id="reset-email" name="email_reset" required
                           type="email" placeholder="E-mail">
                <div id="failed-reset"></div>
                </p>

                <p class="fieldset">
                    <input class="full-width-button has-padding" id="reset-button" type="button" name="reset_pass"
                           onclick="password_reset()" value="Reset password">
                </p>
                <div class="cd-form-bottom-message"><a href="#0">Back to log-in</a></div>

            </form>

        </div> <!-- end of reset password form -->
        <a href="#0" class="cd-close-form">Close</a>
    </div>
</div>


<!--Posts section-->

<div class="view hm-black-light">
    <div class="full-bg-img">
        <ul class="animated fadeInUp">

            <div class="profile-wrap">
                <div class="profile_pic-wrap">
                    <img id="user-img" src="https://si0.twimg.com/profile_images/3420243589/630181de138719039814f8ec46805319.jpeg" alt="" />
                </div>
                <div class="info-wrap">
                    <h1 class="user-name">Adam Leith P</h1>
                    <p class="user-title">User-Interface Designer</p>
                </div>

            </div>


        </ul>
    </div>
</div>
<!--/ end of review section-->


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
<script type="text/javascript" src="js/jquery.rateyo.js"></script>

</body>

</html>