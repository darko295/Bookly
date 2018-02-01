<?php
require 'flight/Flight.php';
require 'indent.php';
include "../connection.php";
Flight::register('db', 'Database', array('rest'));
$json_podaci = file_get_contents("php://input");
$xml_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci);
Flight::set('xml_podaci', $xml_podaci);

Flight::route('/ws/', function () {
    echo 'hello world!';
});

Flight::route('GET /novosti.json', function () {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $db->select();
    $niz = array();
    while ($red = $db->getResult()->fetch_object()) {
        $niz[] = $red;
    }
    //JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
    //Omogućava Unicode enkodiranje JSON fajla
    //Bez ovog parametra, vrši se escape Unicode karaktera
    //Na primer, slovo č će biti \u010
    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;
});

Flight::route('GET /novosti/@id.json', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();

    $query = "SELECT * FROM novosti n JOIN kategorije k ON n.kategorija_id = k.kategorija_id WHERE id=" . $id;
    $db->select("novosti", "*", "kategorije", "kategorija_id", "id", "novosti.id = " . $id, null);
    if ($result = $db->query($query)) {


        $db->ExecuteQuery($query);
        $red = $db->getResult()->fetch_object();
        //JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
        //Omogućava Unicode enkodiranje JSON fajla
        //Bez ovog parametra, vrši se escape Unicode karaktera
        //Na primer, slovo č će biti \u010
        $json_niz = json_encode($red, JSON_UNESCAPED_UNICODE);
        echo indent($json_niz);
    }
    return false;
});
Flight::route('GET /kategorije.json', function () {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $db->select("kategorije", "*", null, null, null, null, null);
    $niz = array();
    $i = 0;
    while ($red = $db->getResult()->fetch_object()) {

        $niz[$i]["id"] = $red->id;
        $niz[$i]["kategorija"] = $red->kategorija;
        $db_pomocna = new Database("rest");
        $db_pomocna->select("novosti", "*", null, null, null, "novosti.kategorija_id = " . $red->id, null);
        while ($red_pomocna = $db_pomocna->getResult()->fetch_object()) {
            $niz[$i]["novosti"][] = $red_pomocna;
        }
        $i++;
    }
    //JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
    //Omogućava Unicode enkodiranje JSON fajla
    //Bez ovog parametra, vrši se escape Unicode karaktera
    //Na primer, slovo č će biti \u010
    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;
});


Flight::route('GET /kategorije/@id.json', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $db->select("kategorije", "*", null, null, null, "kategorije.id = " . $id, null);
    $niz = array();

    $red = $db->getResult()->fetch_object();

    $niz["id"] = $red->id;
    $niz["kategorija"] = $red->kategorija;
    $db_pomocna = new Database("rest");
    $db_pomocna->select("novosti", "*", null, null, null, "novosti.kategorija_id = " . $red->id, null);
    while ($red_pomocna = $db_pomocna->getResult()->fetch_object()) {
        $niz["novosti"][] = $red_pomocna;
    }

    //JSON_UNESCAPED_UNICODE parametar je uveden u PHP verziji 5.4
    //Omogućava Unicode enkodiranje JSON fajla
    //Bez ovog parametra, vrši se escape Unicode karaktera
    //Na primer, slovo č će biti \u010
    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;


});
Flight::route('POST /novosti', function () {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    if ($podaci == null) {
        $odgovor["poruka"] = "Niste prosledili podatke";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
        return false;
    } else {
        if (!property_exists($podaci, 'naslov') || !property_exists($podaci, 'tekst') || !property_exists($podaci, 'kategorija_id')) {
            $odgovor["poruka"] = "Niste prosledili korektne podatke";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $k => $v) {
                $v = "'" . $v . "'";
                $podaci_query[$k] = $v;
            }
            if ($db->insert("novosti", "naslov, tekst, kategorija_id, datumvreme", array($podaci_query["naslov"], $podaci_query["tekst"], $podaci_query["kategorija_id"], 'NOW()'))) {
                $odgovor["poruka"] = "Novost je uspešno ubačena";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Došlo je do greške pri ubacivanju novosti";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }
}
);
Flight::route('POST /kategorije', function () {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    if ($podaci == null) {
        $odgovor["poruka"] = "Niste prosledili podatke";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
    } else {
        if (!property_exists($podaci, 'kategorija')) {
            $odgovor["poruka"] = "Niste prosledili korektne podatke";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $k => $v) {
                $v = "'" . $v . "'";
                $podaci_query[$k] = $v;
            }
            if ($db->insert("kategorije", "kategorija", array($podaci_query["kategorija"]))) {
                $odgovor["poruka"] = "Kategorija je uspešno ubačena";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Došlo je do greške pri ubacivanju novosti";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }


});
Flight::route('PUT /novosti/@id', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    if ($podaci == null) {
        $odgovor["poruka"] = "Niste prosledili podatke";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
    } else {
        if (!property_exists($podaci, 'naslov') || !property_exists($podaci, 'tekst') || !property_exists($podaci, 'kategorija_id')) {
            $odgovor["poruka"] = "Niste prosledili korektne podatke";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $k => $v) {
                $v = "'" . $v . "'";
                $podaci_query[$k] = $v;
            }
            if ($db->update("novosti", $id, array('naslov', 'tekst', 'kategorija_id'), array($podaci->naslov, $podaci->tekst, $podaci->kategorija_id))) {
                $odgovor["poruka"] = "Novost je uspešno izmenjena";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Došlo je do greške pri izmeni novosti";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }


});
Flight::route('PUT /kategorije/@id', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    if ($podaci == null) {
        $odgovor["poruka"] = "Niste prosledili podatke";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
    } else {
        if (!property_exists($podaci, 'kategorija')) {
            $odgovor["poruka"] = "Niste prosledili korektne podatke";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $k => $v) {
                $v = "'" . $v . "'";
                $podaci_query[$k] = $v;
            }
            if ($db->update("kategorije", $id, array('kategorija'), array($podaci->kategorija))) {
                $odgovor["poruka"] = "Kategorija je uspešno izmenjena";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Došlo je do greške pri izmeni kategorije";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }

});
Flight::route('DELETE /novosti/@id', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    if ($db->delete("novosti", array("id"), array($id))) {
        $odgovor["poruka"] = "Novost je uspešno izbrisana";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;
    } else {
        $odgovor["poruka"] = "Došlo je do greške prilikom brisanja novosti";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;

    }

});
Flight::route('DELETE /kategorije/@id', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    $db = Flight::db();
    if ($db->delete("kategorije", array("id"), array($id))) {
        $odgovor["poruka"] = "Kategorija je uspešno izbrisana";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;
    } else {
        $odgovor["poruka"] = "Došlo je do greške prilikom brisanja kategorije";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;

    }
});


//JSON

//daj sve autore
Flight::route('GET /authors.json', function () {
    header("Content-Type: application/json; charset=utf-8");
    global $mysqli;

    $query = "SELECT * FROM author ";
    $result = $mysqli->query($query);

    $niz = array();
    $i = 0;
    while ($red = $result->fetch_object()) {

        $niz[$i]["authorID"] = $red->authorID;
        $niz[$i]["name"] = $red->name;
        $niz[$i]["surnname"] = $red->surname;

        $i++;
    }
    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;
});

//daj wishlist odredjenog korisnika
Flight::route('GET /wishlist/@id.json', function ($user_id) {
    header("Content-Type: application/json; charset=utf-8");
    global $mysqli;

    $query = "SELECT a.name, a.surname, b.bookTitle, w.recordID  FROM wishlist w JOIN author a ON w.authorID = a.authorID
              JOIN book b ON a.authorID=b.authorID JOIN review r ON b.bookID=r.bookID JOIN user u ON u.userID=r.userID WHERE w.userID =" . $user_id. "
              AND w.authorID = a.authorID AND b.bookID = w.bookID";
    $result = $mysqli->query($query);

    $niz = array();
    $i = 0;
    while ($red = $result->fetch_object()) {
        $niz[$i]["recordID"] = $red -> recordID;
        $niz[$i]["bookTitle"] = $red->bookTitle;
        $niz[$i]["name"] = $red->name;
        $niz[$i]["surname"] = $red->surname;

        $i++;
    }
    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;
});
//daj autora sa nekim ID-jem
Flight::route('GET /authors/@id.json', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    global $mysqli;

    $query = "SELECT * FROM author WHERE authorID = " . $id;
    $result = $mysqli->query($query);

    $niz = array();

    $red = $result->fetch_object();

    $niz["authorID"] = $red->authorID;
    $niz["name"] = $red->name;
    $niz["surname"] = $red->surname;

    $json_niz = json_encode($niz, JSON_UNESCAPED_UNICODE);
    echo indent($json_niz);
    return false;
});
// dodaj u wishlist
Flight::route('POST /wishlist', function () {
    header("Content-Type: application/json; charset=utf-8");
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    global $mysqli;
    if ($podaci == null) {
        $odgovor["poruka"] = "No data sent";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
    } else {
        if (!property_exists($podaci, 'userID') || !property_exists($podaci, 'authorID') || !property_exists($podaci, 'bookID')) {
            $odgovor["poruka"] = "Sent data is incorrect";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $key => $value) {
                $podaci_query[$key] = $value;
            }
            $sql = "INSERT INTO wishlist (userID, authorID, bookID) VALUES ('" . $podaci_query["userID"] . "','" . $podaci_query["authorID"] . "','" . $podaci_query["bookID"] . "')";
            if ($mysqli->query($sql)) {
                $odgovor["poruka"] = "Item successefuly inserted. ";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Error inserting item in wishlist";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }
});


//XML

Flight::route('GET /authors.xml', function () {
    header("Content-Type: application/xml; charset=utf-8");
    global $mysqli;

    $query = "SELECT * FROM author ";
    $dom = new DomDocument('1.0', 'utf-8');
    $authors = $dom->appendChild($dom->createElement('authors'));
    if (!$result = $mysqli->query($query)) {
        $error = $authors->appendChild($dom->createElement('error'));
        $error->appendChild($dom->createTextNode("Error while executing query"));
    } else {
        if (mysqli_num_rows($result) > 0) {

            while ($red = $result->fetch_object()) {

                $author = $authors->appendChild($dom->createElement('author'));

                $authorID = $author->appendChild($dom->createElement('authorID'));
                $authorID -> appendChild($dom->createTextNode($red->authorID));

                $name = $author->appendChild($dom->createElement('name'));
                $name->appendChild($dom->createTextNode($red->name));

                $surname = $author->appendChild($dom->createElement('surnname'));
                $surname->appendChild($dom->createTextNode($red->surname));
            }
        }else{
            $error = $authors->appendChild($dom->createElement('error'));
            $error->appendChild($dom->createTextNode("No authors to show"));
        }
    }
    $xml_string = $dom->saveXML();
    echo $xml_string;
    $mysqli->close();

    return false;
});


Flight::start();
?>
