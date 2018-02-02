<?php
include "connection.php";
if (isset($_POST['record_id'])) {

    $record_id = (int)$_POST['record_id'];

    $data = array("record_id" => $record_id);
    $url = "localhost/domaci_1/ws/wishlist/delete/record_id=" . $record_id;
    $curl_zahtev = curl_init($url);
    curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_zahtev, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl_zahtev, CURLOPT_POSTFIELDS, $data);
    $curl_odgovor = curl_exec($curl_zahtev);
    curl_close($curl_zahtev);
    $json_objekat = json_decode($curl_odgovor);

    echo $curl_odgovor;
} else {
    echo "0";
}