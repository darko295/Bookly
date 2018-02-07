<?php
include(dirname(__FILE__) . "/../public/connection.php");

class stats
{

    public function incrementDailyViews($filename)
    {
        global $mysqli;

        $query1 = "SELECT views, views_date FROM dailyviews WHERE page='" . $filename . "' AND views_date = '" . date("Y-m-d") . "'";
        if ($result = $mysqli->query($query1)) {

            if (mysqli_num_rows($result) == 1) {
                $resultArray = $result->fetch_array();
                $views = $resultArray['views'] + 1;
                $query2 = "UPDATE dailyviews SET views=" . $views . " WHERE page= '" . $filename . "' AND views_date='" . date("Y-m-d") . "'";
                if ($mysqli->query($query2)) {
                    if ($mysqli->affected_rows != 1) {

                    }
                } else {

                    error_log("Nije prosao update incrementDailyViews()", 0);
                }
            } else if (mysqli_num_rows($result) == 0) {
                $query3 = "INSERT INTO dailyviews (views, page, views_date) VALUES (1, '" . $filename . "', '" . date("Y-m-d") . "')";
                if ($mysqli->query($query3)) {

                    error_log("Nije prosao INSERT - incrementDailyViews()", 0);
                }
            } else {

                error_log("Dva reda sa istim vrednostima za datum?! incrementDailyViews()", 0);
            }
        }
    }

    public function incrementTotalViews($filename)
    {
        global $mysqli;
        $query4 = "SELECT * FROM totalviews WHERE page_total='" . $filename . "'";
        if ($result = $mysqli->query($query4)) {

            if (mysqli_num_rows($result) == 1) {
                $resultArray = $result->fetch_array();
                $viewsTotal = $resultArray['views_total'] + 1;
                $query2 = "UPDATE totalviews SET views_total=" . $viewsTotal . " WHERE page_total= '" . $filename . "'";

                if ($mysqli->query($query2)) {
                    if ($mysqli->affected_rows != 1) {
                        error_log("Nije uticalno samo na 1 red! incrementTotalViews()", 0);

                    }
                } else {

                    error_log("Nije prosao update incrementTotalViews()", 0);
                }
            } else if (mysqli_num_rows($result) == 0) {
                $query3 = "INSERT INTO totalviews (views_total, page_total) VALUES (1, '" . $filename . "')";
                if (!$mysqli->query($query3)) {

                    error_log("Nije prosao INSERT - incrementTotalViews()", 0);
                }
            } else {

                error_log("Dva reda sa istim vrednostima za datum?! incrementTotalViews()", 0);
            }


        }
    }

    public function getDailyStatsForBookly(){
        global $mysqli;
        $page = "bookly.php";
        $query1 = "SELECT * FROM dailyviews WHERE page='" .$page  . "'";
        if ($result = $mysqli->query($query1)) {

            return $result -> fetch_array();
        }else{

            error_log("Nije prosao SELECT - getDailyStatsForBookly", 0);

        }


        }
    public function getStats()
    {
        global $mysqli;
        $sql = "SELECT (SELECT COUNT(*) FROM book) AS bookCount, (SELECT COUNT(*) FROM   user) AS userCount,(SELECT COUNT(*) FROM   review) AS reviewCount FROM DUAL";
        if ($rezultat = $mysqli->query($sql)) {
            return $rezultat;
        }
        return null;
    }

    function napravi_json_daily(){
    global $mysqli;
        $sql="SELECT * FROM dailyviews WHERE page = 'bookly.php' OR page = 'index.php' ORDER BY views_date DESC";
        if (!$q=$mysqli->query($sql)){
            $json_podaci = '{"error":"Nastala je greška pri izvršavanju upita."}';
        } else {
            if ($q->num_rows>0){
                $json_podaci = '';
                $niz = array();
                while ($row=$q->fetch_object()){
                    $niz[] = $row;
                }
                $json_podaci .= json_encode ($niz);
            } else {
                $json_podaci = '{"error":"Nema rezultata."}';
            }
        }
        $fajl = fopen('json/views_by_day.json', 'w');

        fwrite($fajl, $json_podaci);

        fclose($fajl);

    }

    function napravi_json_total(){
        global $mysqli;
        $sql1="SELECT * FROM totalviews WHERE page_total = 'bookly.php' OR page_total = 'index.php' ORDER BY id_total DESC";
        if (!$q1=$mysqli->query($sql1)){
            $json_podaci1 = '{"error":"Nastala je greška pri izvršavanju upita."}';
        } else {
//ako je upit u redu
            if ($q1->num_rows>0){
                $json_podaci1 = '';
//ako ima rezultata u bazi
                $niz1 = array();
                while ($row1=$q1->fetch_object()){
                    $niz1[] = $row1;
                }
                $json_podaci1 .= json_encode ($niz1);
            } else {
//ako nema rezultata u bazi
                $json_podaci1 = '{"error":"Nema rezultata."}';
            }
        }
//otvaranje novog fajla
        $fajl1 = fopen('json/total_views.json', 'w');
//upis podataka u fajl
        fwrite($fajl1, $json_podaci1);
//zatvaranje fajla
        fclose($fajl1);

    }

}