<?php
session_start();
include "classes/user.php";
$user1 = new user();
if(isset($_POST['action'])){

$result = $user1 -> get_user($_SESSION['username']);
$assoc = $result -> fetch_array();
$url = "localhost/domaci_1/ws/wishlist/".$assoc['userID'].".json";
$curl_zahtev = curl_init($url);
curl_setopt($curl_zahtev, CURLOPT_HTTPGET, TRUE);
curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
$curl_odgovor = curl_exec($curl_zahtev);
curl_close($curl_zahtev);
$json_objekat = json_decode($curl_odgovor);

if(count($json_objekat) == 0) {


    echo '<div class="modal-header" style="position:relative">';
    echo '<button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 10px; right:10px">&times;</button>';
    echo ' <h4 class="modal-title left">This is your wishlist panel</h4></div>';
    echo '<div class="modal-body">';
        echo '<p> Looks like you did not add any item to your wishlist yet. </p>';
    echo ' </div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    echo '</div>';

}else{

    echo '<div class="modal-header" style="position:relative">';
    echo '<button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 10px; right:10px">&times;</button>';
    echo ' <h4 class="modal-title left">You have ' . count($json_objekat) . ' item(s) in your wishlist</h4></div>';
    echo '<div class="modal-body">';
    echo '<div class="table-responsive">';


    echo '<table class="table-bordered wishlist-table table-striped">';
    echo '<tr class="wishlist-row">';
    echo '<th class="wishlist-data">#</th>';
    echo '<th class="wishlist-data">Naslov</th>';
    echo '<th class="wishlist-data">Ime i prezime autora</th>';
    echo '<th class="wishlist-data">Obrisi</th>';

    echo '</tr>';
    $count = 1;
    foreach ($json_objekat as $vrednost) {

        echo '<tr class="wishlist-row">';
        echo '<td class="wishlist-data">' . $count . '</td>';
        echo '<td class="wishlist-data">' . $vrednost->bookTitle . '</td>';
        echo '<td class="wishlist-data">' . $vrednost->name . " " . $vrednost->surname . '</td>';
        echo '<td class="wishlist-data">';
        echo '<button class="btn-red btn btn-md" id="delete-item-'. $vrednost->recordID .'" type="button" onclick="obrisi(' . $vrednost->recordID . ')">Delete</button>';
        echo '</td>';
        echo '</tr>';
        $count = $count + 1;
    }
    echo '</table >';
    echo '</div>';
    echo ' </div>';
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    echo '</div>';


}
}else{
    echo "0";
}

