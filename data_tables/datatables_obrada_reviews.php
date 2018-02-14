<?php
include "../public/connection.php";



$table = "review";
$primaryKey = 'reviewID';

$columns = array(
    array(
        'db' => 'reviewID',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            return $d;
        }
    ),
    array( 'db' => 'reviewID', 'dt' => 0 ),
    array( 'db' => 'userID',  'dt' => 1 ),
    array( 'db' => 'bookID',   'dt' => 2 ),
    array( 'db' => 'authorID',     'dt' => 3 ),
    array( 'db' => 'reviewContent',     'dt' => 4 ),
    array( 'db' => 'reviewStars',     'dt' => 5 ),
    array( 'db' => 'reviewTime',     'dt' => 6 ),

);


// SQL server connection information
$sql_details = array(
    'user' => "root",
    'pass' => "",
    'db'   => "mydb",
    'host' => "localhost"
);



require( 'DataTables-1.10.4/examples/server_side/scripts/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )

);
