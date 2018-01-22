<html>
<body>
<?php
include(dirname(__FILE__)."/../connection.php");

class author
{

    public function doesItExist($name, $surname)
    {
        global $mysqli;
        $sql = "SELECT * FROM author WHERE name='" . $name . "' AND surname='" . $surname . "'";
        if ($rezultat = $mysqli->query($sql)) {
            if (mysqli_num_rows($rezultat) == 0) {
                return 0;
            } else {
                $res = $rezultat->fetch_array();
                return $res["authorID"];
            }
        } else {
            echo "Greska";
            $mysqli->close();
        }
    }


    public function addAuthorIfDoesntExist($name, $surname)
    {
        global $mysqli;
        $id = $this->doesItExist($name, $surname);
        if ($id == 0) {
            $sql = "INSERT INTO author (name, surname) VALUES ('" . $name . "','" . $surname . "')";
            if ($mysqli->query($sql)) {
                return mysqli_insert_id($mysqli);

            } else {
                echo "Greska u delu autori";

            }

        } else {
            return $id;

        }


    }
}

?>
</body>
</html>
