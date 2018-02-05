<?php
if (!isset ($_GET["create_username"])) {
    echo "Parametar  nije prosleđen!";
} else {
    $username = $_GET["create_username"];
    include "connection.php";
    include "classes/user.php";
    $user = new user();
    $result = $user -> get_user($username);

    if ($result->num_rows === 0) {
        echo "1";
    } else {
        echo "0";
    }
}

