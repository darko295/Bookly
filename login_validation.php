<?php
session_start();
include "classes/user.php";
$user = new user();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        if ($user->login($username, $password)) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;

            echo '<script>window.location.href = "bookly.php"; </script>';


            return true;

        }
    }
    return false;


