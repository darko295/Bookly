<?php
include "connection.php";
if(isset($_GET['unos'])) {
    $keyword = $_GET['unos'];
    $keyword='%'.$keyword.'%';
    $query = "SELECT bookTitle FROM book WHERE bookTitle LIKE '" . $keyword . "' LIMIT 3";


    $result = $mysqli->query($query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_object()) {
                ?>
                <a href="#" onclick="place(this)"><?php  echo $row->bookTitle;?></a>
                <br/>
                <?php

            }
        }else{
            echo "U bazi ne postoji naslov koji počinje sa ";
        }
    }
?>
