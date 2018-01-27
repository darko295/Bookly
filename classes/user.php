<?php
include(dirname(__FILE__)."/../connection.php");
 class user
 {


      function get_user($username)
     {
         global $mysqli;

         $sql = "SELECT * FROM user WHERE username = '" . $username . "'";

         if ($result = $mysqli->query($sql)){
             if (mysqli_num_rows($result) == 0) {

                 exit();
             } else {

                 return $result;

             }
         } else {

             echo "Greska prilikom konektovanja sa bazom";
}
       $mysqli -> close();
    }

     function get_user_by_email($email)
     {
         global $mysqli;

         $sql = "SELECT * FROM user WHERE email = '" . $email . "'";

         if ($result = $mysqli->query($sql)){
             if (mysqli_num_rows($result) == 0) {

                 exit();
             } else {
                 return $result;

             }
         } else {

             echo "Greska prilikom konektovanja sa bazom";
         }
         $mysqli -> close();
     }


    public function isValidUsername($username){
        if (strlen($username) < 3) return false;
        if (strlen($username) > 17) return false;
        if (!ctype_alnum($username)) return false;
        return true;
    }

    public function password_verify($entered, $fromdb){
        if($entered != $fromdb) return false;

        return true;
    }

    public function setToActive($username, $broj){
        global $mysqli;

        $sql="UPDATE user SET active = '". $broj ."' WHERE username = '" .$username. "'";
        if ($mysqli->query($sql)){
            if ($mysqli->affected_rows == 1 ) {

        return true;
            }
        }
        return false;
            }

     public function setToInactive($username, $broj){
         global $mysqli;

         $upit="UPDATE user SET active = '" .$broj. "' WHERE username = '" .$username. "'";
         if ($mysqli->query($upit)){
             if ($mysqli->affected_rows == 1 ) {
                 return true;
             }
         }
         return false;
     }

    public function login($username,$password){
        if (!$this->isValidUsername($username)) return false;
        if (strlen($password) < 5) return false;
        $row = $this->get_user($username);
        $red = $row->fetch_array();
        if(!$this->password_verify($password,$red['password'])) return false;
        if(!$this-> setToActive($username, 1)) return false;
        return true;
    }


    public function is_logged_in(){
        if(isset($_['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }
        return false;
    }

    public function is_admin ($username){
        global $mysqli;

        $sql = "SELECT isAdmin FROM user WHERE username = '" . $username . "'";

        if ($result = $mysqli->query($sql)){
            $red = $result->fetch_array();
            if (mysqli_num_rows($result) == 1 && $red['isAdmin'] == 1) {

                return true;
            } else {

                return false;

            }
        } else {

            echo "Greska prilikom konektovanja sa bazom";
        }
        $mysqli -> close();

    }



    public function sendMail($email){


        $res = $this->get_user_by_email($email);
        $red = $res->fetch_array();


        $password = $red['password'];
        $username = $red['username'];
        $to = $email;
        $subject = "Password Reset on Bookly";

        $message = "Hello ".$username.",\n\nYou requested password reset for your Bookly account. If this is a mistake, do nothing and nothing will happen.\r\n\nYour password is: ".$password."\r\n\nCheers,\nBookly team.";
        mail($to,$subject,$message);



    }

    public function getNumberOfActiveUsers(){

        global $mysqli;

        $sql = "SELECT * FROM user WHERE active = 1";

        if ($result = $mysqli->query($sql)){

         return   mysqli_num_rows($result);
        } else {

            echo "nepoznat";
        }
        $mysqli -> close();

    }

}


