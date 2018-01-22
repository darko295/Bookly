<!DOCTYPE html>
<?php
include "classes/review.php";
$review_index = new review();

include "classes/user.php";
$user = new user();


session_start();
?>


<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">


    <title>Bookly | Home page</title>

    <link rel="shortcut icon" href="https://d1r7943vfkqpts.cloudfront.net/ccad7baaa6aea631c4c825c1e3a11921.png"/>


    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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



    <script type="text/javascript">
        $(document).ready(function () {
            $("#signup-username").blur(function () {
                var vrednost = $("#signup-username").val();
                if (vrednost.length < 3) {
                    $("#info").html("Username too short!");
                    $("#signup-username").focus();
                } else if (vrednost.length > 18) {
                    $("#info").html("Username too long!");
                    $("#signup-username").focus();
                } else {
                    $.get("signup_validation.php", {create_username: vrednost},
                        function (data) {
                            if (data == 0) {
                                $("#info").html("Username not available");
                                $("#signup-username").focus();
                            }
                            if (data == 1) {
                                $("#info").html("Username available");
                            }
                        });
                }
            });
        });
    </script>


    <script type="text/javascript">
        function valid_login() {
            var login_username = $('#signin-username').val();
            var login_password = $('#signin-password').val();

            if (login_username.length < 3 || login_password.length < 5) {
                $("#failed-login").html("Username or password is/are too short!");
                return;
            } else {

                $.ajax({
                    type: "POST",
                    url: "login_validation.php",
                    data: {
                        username: login_username,
                        password: login_password
                    },
                    success: function (result) {
                        if (result) {
                            $("#failed-login").html("Redirecting to reviews page...");
                            setTimeout(' window.location.href = "bookly.php"; ', 3000);
                        } else {
                            $("#failed-login").html("Wrong credentials!");

                        }
                    }
                });
            }
        }

    </script>

    <script type="text/javascript">
        function password_reset() {

            var email_reset = $('#reset-email').val();


            $.ajax({
                type: "POST",
                url: "password_reset.php",
                data: {
                    email: email_reset
                },
                success: function (result) {
                    if (result == 1) {

                        $("#failed-reset").html("Check out your mail!");

                    } else {
                        $("#failed-reset").html("Wrong email given!");

                    }
                }
            });
        }

    </script>

    <script>

        function show_form() {
            $("#registration").click();
        }

    </script>


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
                    <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
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
                if(isset($_SESSION['username']))
                if($user-> is_admin($_SESSION['username'])){
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
                            <a class="dropdown-item" href="user_profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View
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
                <span class="cd-error-message">Error message here!</span>
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
            <div class="demo-blog mdl-layout mdl-js-layout has-drawer is-upgraded">
                <main class="mdl-layout__content">
                    <div class="demo-blog__posts mdl-grid">
                        <div class="mdl-card book-pic mdl-cell mdl-cell--8-col">

                            <div class="mdl-card__media mdl-color-text--grey-50">
                                <a id="show-form" href="#" onclick="show_form()"><h3>Registruj se i ti!</a></h3>
                            </div>
                            <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                <div style="text-align: justify">Osim mogucnosti da citas utiske, ukljuci se u nasu
                                    zajednicu i ostavi svoje misljenje o knjizi koju trenutno citas.
                                    Mozda bas tvoj utisak pomogne nekome da se odluci sta ce sledece procitati.
                                </div>
                            </div>
                        </div>

                        <?php
                        require "imports/stats_block.php";
                        ?>


                        <div class="mdl-card on-the-road-again mdl-cell mdl-cell--12-col">
                            <div class="mdl-card__media mdl-color-text--grey-50">
                                <h3>Saljite nam fotografije sa vasih putovanja</a>
                            </div>
                            <div class="mdl-color-text--grey-600 mdl-card__supporting-text">
                                Uskoro u sklopu portala Bookly nova sekcija. Ovoga puta okrecemo se fotografiji kako bismo upotpunili dozivljaj svim
                                posetiocima sajta. Fotografije ce biti objavljene kao deo galerije gde ce se glasanjem birati najbolja, a mi smo spremili nagrade
                                za najbolje.
                            </div>
                            <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                <div class="minilogo"></div>
                                <div>
                                    <strong>Posted by admin</strong>
                                    <span>2 days ago</span>
                                </div>
                            </div>
                        </div>


                        <?php
                        $result = $review_index->getLatest();
                        if ($result == null) {
                            echo "<script> alert('Doslo je do greske prilikom komunikacije sa bazom, ponovo ucitajte stranicu'); </script>";
                        }
                        if ($result->num_rows == 0) {
                            echo "<script> alert('Lista utisaka je prazna.'); </script>";
                        } else {
                            $latest = $result->fetch_object();
                            $date_formated = date('d. F Y.', strtotime(explode(" ", $latest->reviewTime)[0])) . " at " . date('H:m', strtotime(explode(" ", $latest->reviewTime)[1]));
                            ?>


                            <div class="mdl-card amazing mdl-cell mdl-cell--12-col" style="min-height: 130px">
                                <div class="mdl-card__title mdl-color-text--grey-50" style="position: relative">
                                    <i><h3 class="quote"><?php echo $latest->reviewContent; ?></h3></i>
                                    <i><h5 class="quote title-position"
                                           style="position: absolute; bottom: 5px;right: 36px"><?php echo $latest->name . " " . $latest->surname . ", " . $latest->bookTitle; ?></h5>
                                    </i>
                                    <div style="position: absolute; top: 15px;right: 20px">Latest post</div>
                                </div>
                                <div class="mdl-card__supporting-text mdl-color-text--grey-600">

                                    <script>

                                        $(function () {

                                            $("#latest-rating").rateYo({
                                                rating: <?php echo $latest->reviewStars; ?>,
                                                ratedFill: "#000",
                                                readOnly: true
                                            })
                                        });

                                    </script>
                                    <div id="latest-rating"></div>

                                    <h3 style="position: absolute; right: 10px;bottom: 70px;">
                                        Rating: <?php echo $latest->reviewStars; ?></h3>
                                </div>
                                <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                    <div class="minilogo"></div>
                                    <div>
                                        <strong><?php echo "Posted by " . $latest->username; ?></strong>
                                        <span><?php echo $date_formated; ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                        <div class="mdl-card shopping mdl-cell mdl-cell--12-col">
                            <div class="mdl-card__media mdl-color-text--grey-50">
                                <h3><a href="https://www.laguna.rs/laguna-bukmarker-akcija-10-knjiga-za-999-dinara-samo-na-sajtu-wwwdelfirs-unos-7658.html">Nova akcija u Laguna knjizarama</a></h3>
                            </div>
                            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                            Ovog meseca Laganu knjizare spremile su za vas specijalan popust, pogledajte vise na ovom linku.
                            </div>
                            <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                <div class="minilogo"></div>
                                <div>
                                    <strong>Posted by admin</strong>
                                    <span>7 days ago</span>
                                </div>
                            </div>
                        </div>


<!--                        <nav class="demo-nav mdl-cell mdl-cell--12-col">-->
<!--                            <div class="section-spacer"></div>-->
<!--                            <a href="entry.html" class="demo-nav__button" title="show more">-->
<!--                                More-->
<!--                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">-->
<!--                                    <i class="material-icons" role="presentation">arrow_forward</i>-->
<!--                                </button>-->
<!--                            </a>-->
<!--                        </nav>-->
                    </div>

                </main>
                <div class="mdl-layout__obfuscator"></div>
            </div>
            <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    </div>
</div>
</li>

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