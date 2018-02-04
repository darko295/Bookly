<?php
if (isset($_GET['action']) && isset($_GET['author_name']) && isset($_GET['author_surname'])) {

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
        $title = (string) $item->best_book->title;
        echo '<tr class="wishlist-row">';
        echo '<td class="wishlist-data">' . $count . '</td>';
        echo '<td class="wishlist-data">' . $item->best_book->title . '</td>';
        echo '<td class="wishlist-data">' . $item->average_rating . '</td>';
        echo '<td class="wishlist-data">' . $item->original_publication_year . '</td>';
        echo '<td class="wishlist-data">';
        echo '<button class="btn-blue btn btn-md more-item" id="more-item-'. $title .'" type="button" onclick="view_more(this)">View more</button>';
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


} else {
    echo "0";

}