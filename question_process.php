<?php
session_start();
$user_id = null;

include "classes/user.php";
include "connection.php";
$user = new user();

$is_member = 0;

if(isset($_SESSION['username'])){
    $result = $user -> get_user($_SESSION['username']);
    $user_array = $result -> fetch_array();
    $user_id = $user_array['userID'];
    $is_member = 1;

}

if (isset($_POST['question']) && isset($_POST['email'])) {
    $question = $_POST['question'];
    $email = $_POST['email'];
    $date = date("Y-m-d H:i:s");

global $mysqli;

    $sql = "INSERT INTO question (questionEmail, questionText, questionTime, isAnswered, isMember, userID) VALUES ('" . $email . "','" . $question . "', '" . $date . "','" . 0 . "', '" . $is_member . "','" . $user_id . "')";
    if ($mysqli->query($sql)) {
        echo "1";

    } else {
        echo "1";
    }


}
