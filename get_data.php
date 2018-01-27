
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


$sql1="SELECT * FROM totalviews WHERE page_total = '".$string."' OR page_total = '".$string1."' ORDER BY id_total DESC";
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


