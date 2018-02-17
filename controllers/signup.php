<?php

if (isset($_POST['create_submit'])) {

    if (isset($_POST['create_username']) && isset($_POST['create_email']) && isset($_POST['create_password'])) {
        $username = $_POST["create_username"];
        $password = $_POST["create_password"];
        $mail = $_POST["create_email"];



        include(dirname(__FILE__) . "/../public/connection.php");
        include(dirname(__FILE__) . "/../classes/user.php");
        $user = new user();
        $user -> create_account($username,$password,$mail,0);

    } else {
       echo '<script> alert("Nedostajuci podaci!")</script>';
    }
}