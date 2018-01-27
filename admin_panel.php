<html>
<?php
session_start();

include "classes/user.php";
$user = new user();
$aktivni = $user->getNumberOfActiveUsers();

include "classes/stats.php";
$stats = new stats();

if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = true;
    $stats->incrementDailyViews(basename($_SERVER["SCRIPT_FILENAME"]));
    $stats->incrementTotalViews(basename($_SERVER["SCRIPT_FILENAME"]));

}

$data = $stats->getDailyStatsForBookly();

include "get_data.php";

?>
<head>

    <title>Bookly | Admin panel</title>
    <link rel="shortcut icon" href="https://d1r7943vfkqpts.cloudfront.net/ccad7baaa6aea631c4c825c1e3a11921.png"/>

<!--    Data Tables-->
    <script src="DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css"/>
    <script src="DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="js/data_tables.js"></script>
    <script src="js/jquery-2.1.1.min.js"></script>

<!--    Bootstrap-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.css">

<!--    Chart JS-->
    <script type="text/javascript" src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>




</head>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Back to home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="bookly.php">Reviews page</a>
        </li>
    </ul>

    <!-- Navbar text-->
    <ul class="nav navbar-right navbar-nav" style="margin-left: 65%;">
    <span class="navbar-text">
    Currently <?php echo $aktivni; ?> user(s) online.
  </span>
    </ul>
</nav>

<div class="container-fluid text-center">
    <h3 style="padding: 20px;">LISTA UTISAKA</h3>
    <div class="row">
        <div class=" col-sm-1"></div>
        <div class="col-sm-10">
            <table class="tabela display table-bordered table-responsive ">
            </table>
        </div>
    </div>
</div>


<div class="container-fluid text-center" style="background-color: #f6f6f6; height: 500px">
    <h3 style="padding: 40px">STATISTIKA BROJA POSETA</h3>

    <div class="col-lg-12 row">
        <div class="col-lg-6">
            <canvas id="mycanvas"></canvas>
        </div>
        <div class="col-lg-6">
            <canvas id="mycanvas1"></canvas>
        </div>

    </div>
</div>

<div class="container-fluid text-center">
    <h3 style="padding: 20px;">LISTA PITANJA</h3>
    <div class="row">
        <div class=" col-sm-1"></div>
        <div class="col-sm-10">
            <table class="tabela1 display table-bordered table-responsive ">
            </table>
        </div>
    </div>
</div>


<script rel="script" src="js/graphs.js"></script>


</body>
</html>

