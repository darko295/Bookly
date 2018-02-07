<?php
include(dirname(__FILE__) . "/../public/connection.php");

class user
{

    function get_user($username)
    {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) == 0) {
                exit();
            } else {
                return $result;
            }
        } else {
            echo "Greska prilikom konektovanja sa bazom";
        }
        $mysqli->close();
    }

    function get_user_by_email($email)
    {
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) == 0) {
                exit();
            } else {
                return $result;
            }
        } else {
            echo "Greska prilikom konektovanja sa bazom";
        }
        $mysqli->close();
    }


    public function isValidUsername($username)
    {
        if (strlen($username) < 3) return false;
        if (strlen($username) > 17) return false;
        if (!ctype_alnum($username)) return false;
        return true;
    }

    public function password_verify($entered, $fromdb)
    {
        if(!password_verify($entered, $fromdb)) return false;

        return true;
    }

    public function setToActive($username)
    {
        global $mysqli;
        $sql = "UPDATE user SET active = '1'  WHERE username = '" . $username . "'";
        if($mysqli->query($sql)){
            if ($mysqli->affected_rows == 1) {
                return true;
                }
            }
        return false;
    }

    public function setToInactive($username)
    {
        global $mysqli;
        $upit = "UPDATE user SET active = '0' WHERE username = '" . $username . "'";
        if ($mysqli->query($upit)) {
            if ($mysqli->affected_rows == 1) {
                return true;
            }
        }
        return false;
    }

    public function login($username, $password)
    {
        if (!$this->isValidUsername($username)) return false;
        if (strlen($password) < 5) return false;
        $row = $this->get_user($username);
        $red = $row->fetch_array();
        if (!$this->password_verify($password, $red['passwordHash'])) return false;
        if (!$this->setToActive($username)) return false;
        return true;
    }

    public function create_account($username, $password, $mail, $active)
    {
        global $mysqli;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO user (username,password,passwordHash,email,active) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $password,$hashed_password, $mail, $active);

        if ($stmt->execute()) {
            echo '<script>window.location.href = "../index.php";
               alert("Uspesna registracija, molimo ulogujte se!");</script>';
        } else {
            echo '<script>window.location.href = "#";</script>';
        }
    }

    public function is_logged_in()
    {
        if (isset($_['loggedin']) && $_SESSION['loggedin'] == true) {
            return true;
        }
        return false;
    }

    public function is_admin($username)
    {
        global $mysqli;

        $sql = "SELECT isAdmin FROM user WHERE username = '" . $username . "'";

        if ($result = $mysqli->query($sql)) {
            $red = $result->fetch_array();
            if (mysqli_num_rows($result) == 1 && $red['isAdmin'] == 1) {

                return true;
            } else {
                return false;
            }
        } else {
            echo "Greska prilikom konektovanja sa bazom";
        }
        $mysqli->close();

    }

    public function sendMail($email)
    {
        $res = $this->get_user_by_email($email);
        $red = $res->fetch_array();


        $password = $red['password'];
        $username = $red['username'];
        $to = $email;
        $subject = "Password Reset on Bookly";

        $message = "Hello " . $username . ",\n\nYou requested password reset for your Bookly account. If this is a mistake, do nothing and nothing will happen.\r\n\nYour password is: " . $password . "\r\n\nCheers,\nBookly team.";
        mail($to, $subject, $message);
    }

    public function getNumberOfActiveUsers()
    {

        global $mysqli;
        $sql = "SELECT * FROM user WHERE active = 1";

        if ($result = $mysqli->query($sql)) {

            return mysqli_num_rows($result);
        } else {

            echo "nepoznat";
        }
        $mysqli->close();
    }

    public function logout($username)
    {

        $this->setToInactive($username);
        session_destroy();
        header("Location: ../index.php");

    }

    public function insert_question($mail, $text, $username)
    {
        global $mysqli;
        $is_answered = 0;
        $is_member = 0;
        $user_id = null;
        if ($username != null) {
            $result = $this->get_user($username);
            $user_array = $result->fetch_array();
            $user_id = $user_array['userID'];
            $is_member = 1;
        }
        $date = date("Y-m-d H:i:s");
        $stmt = $mysqli->prepare("INSERT INTO question (questionEmail, questionText, questionTime, isAnswered, isMember, userID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiii", $mail, $text, $date, $is_answered, $is_member, $user_id);
        if ($stmt->execute()) {
            echo "1";
        } else {
            echo "0";
        }

    }
}