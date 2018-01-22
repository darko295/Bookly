<?php
if (!isset ($_GET["create_username"])) {
    echo "Parametar Username nije prosleđen!";
} else {
    $username = $_GET["create_username"];
    include "connection.php";

    $sql = "SELECT * FROM user WHERE username='" . $username . "'";
    $rezultat = $mysqli->query($sql);
    if ($rezultat->num_rows == 0) {
        echo "1";
    } else {
        echo "0";
    }
    $mysqli->close();
}

