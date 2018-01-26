
<?php

include "connection.php";
$string = "bookly.php";
$string1 = "index.php";
$sql="SELECT * FROM dailyviews WHERE page = '".$string."' OR page = '".$string1."' ORDER BY views_date DESC";
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


//$sql="SELECT * FROM dailyviews WHERE page LIKE '".$string."' ORDER BY views_date DESC";
//if (!$q=$mysqli->query($sql)){
//    $json_podaci = '{"error":"Nastala je greška pri izvršavanju upita."}';
//} else {
////ako je upit u redu
//    if ($q->num_rows>0){
//        $json_podaci = '';
////ako ima rezultata u bazi
//        $niz = array();
//        while ($row=$q->fetch_object()){
//            $niz[] = $row;
//        }
//        $json_podaci .= json_encode ($niz);
//    } else {
////ako nema rezultata u bazi
//        $json_podaci = '{"error":"Nema rezultata."}';
//    }
//}
////otvaranje novog fajla
//$fajl = fopen('json/views_by_day_index.json', 'w');
////upis podataka u fajl
//fwrite($fajl, $json_podaci);
////zatvaranje fajla
//fclose($fajl);
//

