<html>
<head>
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
</head>

<body>

<?php

if (isset($_POST['create_submit'])) {

    if (isset($_POST['create_username']) && isset($_POST['create_email']) && isset($_POST['create_password'])) {
        $username = $_POST["create_username"];
        $password = $_POST["create_password"];
        $mail = $_POST["create_email"];

        $username = trim($username);
        $password = trim($password);
        $mail = trim($mail);


        include "connection.php";

        $sql = "INSERT INTO user (username,password,email,active) VALUES ('" . $username . "', '" . $password . "', '" . $mail . "',0)";

        if ($mysqli->query($sql)) {
            ?>
            <script>
                window.location.href = "index.php";
                alert("Uspesna registracija, molimo ulogujte se!");
            </script>
        <?php
        } else {
        ?>
            <script>
                window.location.href = "#0";
            </script>
            <?php
            echo "<p>Nastala je greška pri ubacivanju korisnika</p>" . $mysqli->error;
        }


    } else {
        alert("Nedostajuci podaci!");
    }

    $mysqli->close();
}
?>


</body>
</html>
