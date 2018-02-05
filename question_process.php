<?php
session_start();

include "connection.php";
include "classes/user.php";
$user = new user();
$username = null;

if(isset($_SESSION['username'])){
$username = $_SESSION['username'];
}

if (isset($_POST['question']) && isset($_POST['email'])) {
    $question = $_POST['question'];
    $email = $_POST['email'];
    $user -> insert_question($email,$question,$username);
}