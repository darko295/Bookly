<?php
session_start();
include "classes/user.php";
include "classes/review.php";
include "classes/stats.php";

$user = new user();
$review = new review();
$stats = new stats();

$current = "Guest";


if (!isset($_SESSION['bookly'])) {
    $_SESSION['bookly'] = true;
    $stats->incrementDailyViews(basename($_SERVER["SCRIPT_FILENAME"]));
    $stats->incrementTotalViews(basename($_SERVER["SCRIPT_FILENAME"]));

}


?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Bookly | Reviews page</title>
    <link rel="shortcut icon" href="https://d1r7943vfkqpts.cloudfront.net/ccad7baaa6aea631c4c825c1e3a11921.png"/>

    <!-- JS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-orange.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery.rateyo.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/_animations.css">
    <link rel="stylesheet" href="css/_colors.css">
    <link rel="stylesheet" href="css/_mixins.css">


    <script type="text/javascript" src="js/bookly.js"></script>
    <script src="js/footer.js"></script>


    <style>
        .wishlist-table {
            border-spacing: 5px;

        }

        .wishlist-data {
            padding: 20px;

        }
    </style>

</head>

<body>
<?php
if (isset($_SESSION['username'])) {
    $current = $_SESSION['username'];
    $user_id = $user->get_user($_SESSION['username']);
    $id = $user_id->fetch_array();
}
?>


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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Reviews page<span class="sr-only">(current)</span></a>
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
            if (isset($_SESSION['username'])) {
                ?>
                <ul class="nav navbar-nav navbar-right" style="padding-left: 10px">
                    <li class="nav-item btn-group">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $current; ?>&nbsp;</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="user_profile.php"><span
                                        class="glyphicon glyphicon-user"></span>&nbsp;View
                                Profile</a>
                            <a class="dropdown-item open" id="show-wishlist" href="#" data-toggle="modal"
                               data-target="#myModal"><span
                                        class="glyphicon glyphicon-user"></span>&nbsp;My wishlist</a>
                            <a class="dropdown-item" href="controllers/logout.php"><span
                                        class="glyphicon glyphicon-log-out"></span>&nbsp;Sign
                                Out</a>
                        </div>
                    </li>

                </ul>
            <?php } ?>
        </div>
    </div>
</nav>

<!--/.end of navbar-->

<?php
require "imports/modals.php";
?>

<!--Reviews-->
<div class="view hm-black-light">
    <div class="full-bg-img">
        <ul class="animated fadeInUp">
            <div class="demo-blog mdl-layout mdl-js-layout has-drawer is-upgraded">
                <main class="mdl-layout__content">
                    <div class="demo-blog__posts mdl-grid">

                        <?php
                        if (!isset($_SESSION['username'])) {
                            ?>
                            <div class="mdl-card book-pic mdl-cell mdl-cell--8-col">
                                <div class="mdl-card__media mdl-color-text--grey-50">
                                    <a href="index.php"><h3>Registruj se i ti!</a></h3>
                                </div>
                                <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                    <div style="text-align: justify">Osim mogucnosti da citas utiske, ukljuci se u nasu
                                        zajednicu i ostavi svoje misljenje o knjizi koju trenutno citas.
                                        Mozda bas tvoj utisak pomogne nekome da se odluci sta ce sledece procitati.
                                    </div>
                                </div>
                            </div>

                            <?php
                        } else {
                            ?>

                            <div class="mdl-card  mdl-cell mdl-cell--8-col" style="background-color: #e0e0e0">
                                <h3 style="font-family: 'Xiomara-Script'; padding: 10px">Add new review</h3>

                                <div class="container">

                                    <form id="add-review" method="get" action="controllers/review_process.php">
                                        <div class="form-group" style="width: 43%;">
                                            <label for="title"></label>
                                            <input class="form-control-mine back-col" id="title" type="text"
                                                   name="title" required placeholder="Book title">
                                        </div>
                                        <div class="row container" style="margin-bottom: 10px">

                                            <div class="form-group" style="width: 45%; margin-right: 40px">
                                                <label for="author-name"></label>
                                                <input class="form-control-mine back-col down-border" id="author-name"
                                                       type="text"
                                                       name="author_name" required placeholder="Author name"></div>

                                            <div class="form-group" style="width: 45%">
                                                <label for="author-surname"></label>
                                                <input class="form-control-mine back-co down-borderl"
                                                       id="author-surname"
                                                       type="text" name="author_surname" required
                                                       placeholder="Author surname">
                                            </div>
                                        </div>
                                        <div class="rateYo">Rating:</div>
                                        <input type="hidden" value="-1" name="stars_rating" id="stars-rating">


                                        <div class="form-group" style="margin-top: -5px">
                                            <textarea class="md-textarea back-col down-border" id="review-text"
                                                      name="review_text"
                                                      required placeholder="Review here"
                                                      style="max-width: 80%"></textarea>
                                        </div>


                                        <button type="submit" class="btn-grey btn" id="review-button"
                                                name="review_button"
                                                style="width: 25%; margin-left: 0; margin-bottom: 15px;">Send review
                                        </button>


                                    </form>
                                </div>

                            </div>

                        <?php } ?>

                        <?php
                        require "imports/stats_block.php";
                        ?>

                        <?php
                        $result = $review->getAll();
                        if ($result == null) {
                            echo "<script> alert('Doslo je do greske prilikom komunikacije sa bazom, ponovo ucitajte stranicu'); </script>";
                        }
                        if ($result->num_rows == 0) {
                            echo "<script> alert('Lista utisaka je prazna.'); </script>";
                        } else {

                            ?>

                            <table>
                                <tr></tr>
                                <?php
                                $counter = 1;

                                while ($row = $result->fetch_object()) {
                                    $date_formated = date('d. F Y.', strtotime(explode(" ", $row->reviewTime)[0])) . " at " . date('H:m', strtotime(explode(" ", $row->reviewTime)[1]));
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="position: relative">
                                                <?php
                                                if (isset($_SESSION['username']) && $row->username != $current) {
                                                    ?>
                                                    <button class="mdl-button mdl-js-ripple-effect mdl-js-button mdl-button--fab mdl-color--accent"
                                                            id="<?php echo "menubtn-" . $counter; ?>"
                                                            style="position: absolute; right: -15px;top:40px; z-index: 20">
                                                        <i class="material-icons mdl-color-text--white"
                                                           role="presentation">add</i>
                                                        <span class="visuallyhidden">add</span>
                                                    </button>
                                                <?php } ?>
                                                <div class="mdl-card amazing mdl-cell mdl-cell--12-col"
                                                     id="<?php echo "review" . $row->reviewID; ?>">

                                                    <div class="mdl-card__title mdl-color-text--grey-50"
                                                         style="position: relative">

                                                        <?php
                                                        if ($row->username == $current || $user->is_admin($current)) {
                                                            ?>
                                                            <a class="remove-row"
                                                               id="remove_<?php echo $row->reviewID; ?>"
                                                               style="position: absolute; top: 15px;right: 20px"
                                                               href="#"><span class="fa fa-close"></span></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <i><h3 class="quote"><?php echo $row->reviewContent; ?></h3></i>

                                                        <i><h5 class="quote title-position"
                                                               style="position: absolute; bottom: 5px;right: 36px"><?php echo $row->name . " " . $row->surname . ", " . $row->bookTitle; ?></h5>
                                                        </i>
                                                    </div>
                                                    <div class="mdl-card__supporting-text mdl-color-text--grey-600">

                                                        <script>

                                                            $(function () {

                                                                $("<?php echo "#a" . $counter?>").rateYo({
                                                                    rating: <?php echo $row->reviewStars; ?>,
                                                                    ratedFill: "#000",
                                                                    readOnly: true
                                                                })
                                                            });
                                                        </script>

                                                        <?php if ($row->reviewStars != -1) { ?>
                                                            <div id="<?php echo "a" . $counter; ?>"></div>
                                                            <h3 style="position: absolute; right: 10px;bottom: 70px;">
                                                                Rating: <?php echo $row->reviewStars; ?></h3>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
                                                        <div class="minilogo"></div>
                                                        <div>
                                                            <b><?php echo "Posted by " . $row->username; ?></b>
                                                            <span style="font-size: 12px"><?php echo $date_formated; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="mdl-menu mdl-js-menu mdl-menu--right mdl-js-ripple-effect"
                                                    for="<?php echo "menubtn-" . $counter; ?>">
                                                    <li class="mdl-menu__item wishlist-add"
                                                        id="<?php echo "wishlist-" . $id['userID'] . "-" . $row->authorID . "-" . $row->bookID; ?>">
                                                        Add to wishlist
                                                    </li>
                                                    <li class="mdl-menu__item more-by-this-author"
                                                        id="<?php echo "morebyauthor-" . $row->name . "-" . $row->surname; ?>"
                                                        data-toggle="modal"
                                                        data-target="#myModal2">More by this author
                                                    </li>
                                                    <li class="mdl-menu__item more-info" data-toggle="modal"
                                                        data-target="#myModal1"
                                                        id="<?php echo "moreinfo-" . $row->name . "-" . $row->surname . "-" . $row->bookTitle; ?>">
                                                        Get author info
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php
                                    $counter = $counter + 1;
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
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
<!--/end of review section-->


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
<script type="text/javascript" src="js/jquery.rateyo.js"></script>
<script type="text/javascript" src="js/notify.js"></script>

</body>
</html>