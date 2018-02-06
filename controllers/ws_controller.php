<?php
session_start();
include "../classes/user.php";
$user = new user();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

function ws_delete()
{
    if (isset($_POST['record_id'])) {

        $record_id = (int)$_POST['record_id'];

        $data = array("record_id" => $record_id);
        $url = "localhost/domaci_1/ws/wishlist/delete/" . $record_id;
        $curl_zahtev = curl_init($url);
        curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_zahtev, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl_zahtev, CURLOPT_POSTFIELDS, $data);
        $curl_odgovor = curl_exec($curl_zahtev);
        curl_close($curl_zahtev);

        echo $curl_odgovor;
    } else {
        echo "0";
    }
}

function more_by_author()
{

    if (isset($_GET['author_name']) && isset($_GET['author_surname'])) {

        $server = "https://www.goodreads.com/search.xml?key=";
        $key = "ogHWnXgHLlnmnfKFnG0BCQ";
        $query = "&q=" . $_GET['author_name'] . "+" . $_GET['author_surname'] . "&search=author";

        $url = $server . $key . $query;
        $curl_zahtev = curl_init($url);
        curl_setopt($curl_zahtev, CURLOPT_HTTPGET, TRUE);
        curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
        $curl_odgovor = curl_exec($curl_zahtev);
        curl_close($curl_zahtev);


        $response_xml = new SimpleXMLElement($curl_odgovor, null, false);

        if ($response_xml->search->results->work->count() === 0) {

            echo ' <div class="modal-header" style="position:relative">';
            echo '   <button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 10px; right:10px">&times;</button>';

            echo ' <h4 class="modal-title left">Other releases by this author will appear here</h4></div>';
            echo '<div class="modal-body">';
            echo '<p> Looks like you we could not find any other book by this author. </p>';

            echo '</div>';
            echo ' </div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            echo '</div>';


        } else {

            echo ' <div class="modal-header" style="position:relative">';
            echo '   <button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 10px; right:10px">&times;</button>';

            echo ' <h4 class="modal-title left">There is ' . $response_xml->search->results->work->count() . ' more book(s) by this author.</h4></div>';
            echo '<div class="modal-body">';
            echo '<div class="table-responsive">';
            echo '<table class="table-bordered more-books-table table-striped">';
            echo '<tr class="wishlist-row">';
            echo '<th class="wishlist-data">#</th>';
            echo '<th class="wishlist-data">Book title</th>';
            echo '<th class="wishlist-data">Rating on Goodreads</th>';
            echo '<th class="wishlist-data">Year of release</th>';
            echo '<th class="wishlist-data">View more</th>';
            echo '</tr>';
            $count = 1;
            foreach ($response_xml->search->results->work as $item) {
                $title = (string)$item->best_book->title;
                echo '<tr class="wishlist-row">';
                echo '<td class="wishlist-data">' . $count . '</td>';
                echo '<td class="wishlist-data">' . $item->best_book->title . '</td>';
                echo '<td class="wishlist-data">' . $item->average_rating . '</td>';
                echo '<td class="wishlist-data">' . $item->original_publication_year . '</td>';
                echo '<td class="wishlist-data">';
                echo '<button class="btn-blue btn btn-md more-item" id="more-item-' . $title . '" type="button" onclick="view_more(this)">View more</button>';
                echo '</td>';
                echo '</tr>';
                $count = $count + 1;

            }
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo ' </div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            echo '</div>';
        }

    } else {
        echo "0";
    }

}

function show_wishlist()
{
    global $user;
    global $username;

    $result = $user->get_user($username);
    $assoc = $result->fetch_array();
    $url = "localhost/domaci_1/ws/wishlist/" . $assoc['userID'] . ".json";
    $curl_zahtev = curl_init($url);
    curl_setopt($curl_zahtev, CURLOPT_HTTPGET, TRUE);
    curl_setopt($curl_zahtev, CURLOPT_RETURNTRANSFER, true);
    $curl_odgovor = curl_exec($curl_zahtev);
    curl_close($curl_zahtev);
    $json_objekat = json_decode($curl_odgovor);

    if (count($json_objekat) == 0) {


        echo '<div class="modal-header" style="position:relative">';
        echo '<button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 10px; right:10px">&times;</button>';
        echo ' <h4 class="modal-title left">This is your wishlist panel</h4></div>';
        echo '<div class="modal-body">';
        echo '<p> Looks like you did not add any item to your wishlist yet. </p>';
        echo ' </div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        echo '</div>';

    } else {

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
            echo '<button class="btn-red btn btn-md" id="delete-item-' . $vrednost->recordID . '" type="button" onclick="obrisi(' . $vrednost->recordID . ')">Delete</button>';
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

}


if (isset ($_POST["action"])) {

    switch ($_POST["action"]) {
        case "ws_delete":
            ws_delete();
            break;
        case "show_wishlist":
            show_wishlist();
            break;
    }

} else if (isset($_GET['action'])) {

    switch ($_GET["action"]) {
        case "morebyauthor":
            more_by_author();
            break;
    }

} else {
    echo "0";
}