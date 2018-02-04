<?php

if(isset($_GET['action']) && isset($_GET['author'])){


    $url = "https://en.wikipedia.org/api/rest_v1/page/pdf/".$_GET['author'];
    $curl_zahtev = curl_init($url);
    curl_setopt($curl_zahtev, CURLOPT_HTTPGET, TRUE);
    curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_zahtev, CURLOPT_HTTPHEADER, array(
        'Accept: application/pdf'
    ));
    $file = curl_exec($curl_zahtev);
    echo $file;


}else{
    echo  "0";

}