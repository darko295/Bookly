<html>
<?php
session_start();

include "classes/user.php";
$user = new user();
$aktivni = $user -> getNumberOfActiveUsers();

include "classes/stats.php";
$stats = new stats();

if(!isset($_SESSION['admin'])){
    $_SESSION['admin'] = true;
    $stats -> incrementDailyViews(basename($_SERVER["SCRIPT_FILENAME"]));
    $stats -> incrementTotalViews(basename($_SERVER["SCRIPT_FILENAME"]));

}

$data = $stats -> getDailyStatsForBookly();

include "get_data.php";

?>
<head>

    <title>Bookly | Admin panel</title>

    <link rel="shortcut icon" href="https://d1r7943vfkqpts.cloudfront.net/ccad7baaa6aea631c4c825c1e3a11921.png"/>

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css"/>
    <script src="DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">

    <script type="text/javascript" src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>

    <script type="text/javascript" src="js/utils.js"></script>







    <script>
        $(document).ready(function () {
            $(".tabela").DataTable({
                "columns": [
                    {"title": "Review ID"},
                    {"title": "User ID"},
                    {"title": "Book ID"},
                    {"title": "Author ID"},
                    {"title": "Review Content"},
                    {"title": "Review stars"},
                    {"title": "Review time"}
                ],
                "ajax": "datatables_obrada.php",
                "processing": true,
                "serverSide": true
            });

        });
    </script>

    <script>

        $(document).ready(function() {
            var t = $('#tabela').DataTable( {
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]]
            } );

            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );

    </script>


</head>

<body>
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
    Currently <?php echo $aktivni;?> user(s) online.
  </span>
    </ul>
</nav>


<table class="tabela display table-bordered table-responsive "  width="80%">
</table>


<div id="chart-container" style="height: 600px; width: 600px">
    <canvas id="mycanvas" ></canvas>
</div>

<script>

    $(document).ready(function(){
        $.ajax({
            url: "json/views_by_day.json",
            method: "GET",
            success: function(data) {
                console.log(data);
                var date = [];
                var viewsBookly = [];
                var viewsIndex = [];
                for(var i in data) {
                    if(!date.includes("On " + data[i].views_date)){
                        date.push("On " + data[i].views_date);
                    }
                    if(data[i].page === "bookly.php"){
                    viewsBookly.push(data[i].views);
                    }else if(data[i].page === "index.php"){
                        viewsIndex.push(data[i].views);
                    }
                }
                date.reverse();
                viewsBookly.reverse();
                viewsIndex.reverse();
                var chartdata = {
                    labels: date,
                    datasets : [
                        {
                            label: 'Hits on index.php',
                            borderColor: 'rgba(250, 100, 100, 0.75)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: viewsIndex
                        },
                        {
                            label: 'Hits on bookly.php',
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: viewsBookly
                        }
                    ]
                };

                var ctx = $("#mycanvas");

                var barGraph = new Chart(ctx, {
                    type: 'line',
                    data: chartdata
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>

</body>
</html>

