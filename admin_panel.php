<html>
<?php
session_start();

include "classes/user.php";
$user = new user();
$aktivni = $user -> getNumberOfActiveUsers();
?>
<head>

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="DataTables-1.10.4/media/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css"/>
    <script src="DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">


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


<table class="tabela display table-bordered table-responsive " width="80%">
</table>

</body>
</html>

