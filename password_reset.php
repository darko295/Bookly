<?php
include "connection.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    include "classes/user.php";
    $user = new user();

    $result = $user->get_user_by_email($email);
    if ($result->num_rows === 0) {
        echo "0";
    } else {
        $user->sendMail($email);
        echo "1";
    }
    $mysqli->close();

} else {
    echo "Uneti podatke!";
}