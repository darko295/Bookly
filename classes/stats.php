<?php
include(dirname(__FILE__) . "/../connection.php");

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

}