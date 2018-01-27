<?php
include "connection.php";


$table = "question";
$primaryKey = 'questionID';

$columns = array(
    array(
        'db' => 'questionID',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            return $d;
        }
    ),
    array( 'db' => 'questionID', 'dt' => 0 ),
    array( 'db' => 'questionEmail',  'dt' => 1 ),
    array( 'db' => 'questionText',   'dt' => 2 ),
    array( 'db' => 'questionTime',     'dt' => 3 ),
    array( 'db' => 'isAnswered',     'dt' => 4 ),
    array( 'db' => 'isMember',     'dt' => 5 ),
    array( 'db' => 'userID',     'dt' => 6 ),

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
