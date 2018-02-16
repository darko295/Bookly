<?php
require 'flight/Flight.php';
require 'indent.php';
include "../public/connection.php";
$json_podaci = file_get_contents("php://input");
$xml_podaci = file_get_contents("php://input");
Flight::set('json_podaci', $json_podaci);
Flight::set('xml_podaci', $xml_podaci);

Flight::route('/ws/', function () {
    echo 'hello world!';
});

//JSON

//1. daj sve autore
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

//2. daj autora sa nekim ID-jem
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

//3. daj wishlist odredjenog korisnika
Flight::route('GET /wishlist/@id.json', function ($user_id) {
    header("Content-Type: application/json; charset=utf-8");
    global $mysqli;

    $query = "SELECT a.name, a.surname, b.bookTitle, w.recordID  FROM wishlist w JOIN user u ON w.userID = u.userID
            JOIN author a ON w.authorID = a.authorID JOIN book b ON b.bookID = w.bookID WHERE w.userID = '".$user_id."' ORDER BY w.dateAdded ASC";
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

//4. dodaj u wishlist
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
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO wishlist (userID, authorID, bookID, dateAdded) VALUES ('" . $podaci_query["userID"] . "','" . $podaci_query["authorID"] . "','" . $podaci_query["bookID"] . "','" . $date . "')";
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

//5. izbrisi iz wishlista
Flight::route('DELETE /wishlist/delete/@id', function ($record_id) {
    global $mysqli;
    header("Content-Type: application/json; charset=utf-8");
    $sql ="DELETE FROM wishlist WHERE recordID =".$record_id;
    if ($q = $mysqli->query($sql)) {
        $odgovor["poruka"] = "Item deleted successefuly";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;
    } else {
        $odgovor["poruka"] = "Error deleting item from wishlist";
        $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
        echo $json_odgovor;
        return false;
    }
});

//6. izmeni utisak sa odredjenim ID-jem
Flight::route('PUT /review/update/@id', function ($id) {
    header("Content-Type: application/json; charset=utf-8");
    global $mysqli;
    $podaci_json = Flight::get("json_podaci");
    $podaci = json_decode($podaci_json);
    if ($podaci == null) {
        $odgovor["poruka"] = "No data sent";
        $json_odgovor = json_encode($odgovor);
        echo $json_odgovor;
    } else {
        if (!property_exists($podaci, 'reviewContent') || !property_exists($podaci, 'reviewStars')) {
            $odgovor["poruka"] = "Wrong data passed";
            $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
            echo $json_odgovor;
            return false;

        } else {
            $podaci_query = array();
            foreach ($podaci as $k => $v) {
                $v = "'" . $v . "'";
                $podaci_query[$k] = $v;
            }
            $stmt = $mysqli -> prepare("UPDATE review SET reviewContent = ?, reviewStars = ? WHERE reviewID = ?");
            $stmt -> bind_param("sdi",$podaci->reviewContent,$podaci->reviewStars, $id);
            if ($stmt -> execute()) {
                $odgovor["poruka"] = "Review updated";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            } else {
                $odgovor["poruka"] = "Error updating review";
                $json_odgovor = json_encode($odgovor, JSON_UNESCAPED_UNICODE);
                echo $json_odgovor;
                return false;
            }
        }
    }
});

//XML
//7. daj sve autore
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

//8. daj autora sa odredjenim ID-jem
Flight::route('GET /authors/@id.xml', function ($id) {
    header("Content-Type: application/xml; charset=utf-8");
    global $mysqli;
    $query = "SELECT * FROM author WHERE authorID =".$id;
    $dom = new DomDocument('1.0', 'utf-8');
    $author = $dom->appendChild($dom->createElement('author'));
    if (!$result = $mysqli->query($query)) {
        $error = $author->appendChild($dom->createElement('error'));
        $error->appendChild($dom->createTextNode("Error while executing query"));
    } else {
        if (mysqli_num_rows($result) === 1) {

            $red = $result->fetch_object();

                $authorID = $author->appendChild($dom->createElement('authorID'));
                $authorID -> appendChild($dom->createTextNode($red->authorID));

                $name = $author->appendChild($dom->createElement('name'));
                $name->appendChild($dom->createTextNode($red->name));

                $surname = $author->appendChild($dom->createElement('surname'));
                $surname->appendChild($dom->createTextNode($red->surname));

        }else{
            $error = $author->appendChild($dom->createElement('error'));
            $error->appendChild($dom->createTextNode("No author with that id"));
        }
    }
    $xml_string = $dom->saveXML();
    echo $xml_string;
    $mysqli->close();
    return false;
});

//9. daj wishlist odredjenog korisnika
Flight::route('GET /wishlist/@id.xml', function ($user_id) {
    header("Content-Type: application/xml; charset=utf-8");
    global $mysqli;

    $query = "SELECT a.name, a.surname, b.bookTitle, w.recordID, w.dateAdded  FROM wishlist w JOIN user u ON w.userID = u.userID
            JOIN author a ON w.authorID = a.authorID JOIN book b ON b.bookID = w.bookID WHERE w.userID = '".$user_id."' ORDER BY w.dateAdded ASC";

    $dom = new DomDocument('1.0', 'utf-8');
    $wishlist = $dom->appendChild($dom->createElement('wishlist'));
        if (!$result = $mysqli->query($query)) {
            $error = $wishlist->appendChild($dom->createElement('error'));
            $error->appendChild($dom->createTextNode("Error while executing query"));
        } else {
        if (mysqli_num_rows($result) > 0) {
            while($red = $result->fetch_object()){

                $record_number = $wishlist->appendChild($dom->createElement('item'));

                $bookTitle = $record_number->appendChild($dom->createElement('bookTitle'));
                $bookTitle -> appendChild($dom->createTextNode($red->bookTitle));

                $name = $record_number->appendChild($dom->createElement('authorName'));
                $name->appendChild($dom->createTextNode($red->name));

                $surname = $record_number->appendChild($dom->createElement('authorSurname'));
                $surname->appendChild($dom->createTextNode($red->surname));

                $time = $record_number->appendChild($dom->createElement('dateAdded'));
                $time->appendChild($dom->createTextNode($red->dateAdded));
            }
        }else{
            $error = $wishlist->appendChild($dom->createElement('error'));
            $error->appendChild($dom->createTextNode("No user with that id"));
        }
    }

    $xml_string = $dom->saveXML();
    echo $xml_string;
    $mysqli->close();

    return false;
});

Flight::start();
?>
