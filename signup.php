<?php

if (isset($_POST['create_submit'])) {

    if (isset($_POST['create_username']) && isset($_POST['create_email']) && isset($_POST['create_password'])) {
        $username = $_POST["create_username"];
        $password = $_POST["create_password"];
        $mail = $_POST["create_email"];

        $username = trim($username);
        $password = trim($password);
        $mail = trim($mail);

        include "connection.php";
        include "classes/user.php";
        $user = new user();
        $user -> create_account($username,$password,$mail,0);

    } else {
       echo '<script> alert("Nedostajuci podaci!")</script>';
    }
}