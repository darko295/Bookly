<?php
include "connection.php";
if(isset($_POST['email'])){
    $email = $_POST['email'];

    $sql="SELECT * FROM user WHERE email='".$email."'";
    $rezultat = $mysqli->query($sql);
    if ($rezultat->num_rows == 0){
        echo "0";
    } else {
        include "classes/user.php";

        $user = new user();
        $user -> sendMail($email);
        echo "1";




    }
    $mysqli->close();


}else{
    echo "Uneti podatke!";
}