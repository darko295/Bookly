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

<?php
    require "imports/login_signup_form.php";
?>


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