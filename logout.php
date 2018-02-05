<?php
session_start();
include "classes/user.php";
$user = new  user();
$user -> logout($_SESSION['username'], 0);
