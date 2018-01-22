<?php
session_start();
include "classes/user.php";
$user = new  user();
$user -> setToInactive($_SESSION['username'], 0);

session_destroy();


header("Location: index.php");
?>