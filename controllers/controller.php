<?php
session_start();

include "../classes/wishlist.php";
include "../classes/user.php";
include "../classes/review.php";

$wishlist = new wishlist();
$user = new user();
$review = new review();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}

    function add_to_wishlist(){
        if (isset($_POST["user_id"]) && isset($_POST["author_id"]) && isset($_POST['book_id'])) {
            $user_id = (int)$_POST['user_id'];
            $author_id = (int)$_POST['author_id'];
            $book_id = (int)$_POST['book_id'];
            global $wishlist;

            $wishlist->add_new_item($user_id, $author_id, $book_id);
    }else{
            echo "0";
        }
    }

    function login_validation (){
        global $user;
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($user->login($username, $password)) {
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                echo "1";
            }
        }else{
        echo "0";
        }
    }

    function delete_review(){
        global $review;
        if (isset($_GET['reviewID'])) {
            $reviewID = $_GET['reviewID'];
            $review->delete_review($reviewID);
        }

    }

    function insert_question(){

        if (isset($_POST['question']) && isset($_POST['email'])) {
            global $user;
            global $username;
            $question = $_POST['question'];
            $email = $_POST['email'];
            $user -> insert_question($email,$question,$username);
        }
    }

    function signup_validation (){
       global $user;
        $username = $_GET["create_username"];
        $result = $user -> get_user($username);
        if ($result->num_rows === 0) {
            echo "1";
        } else {
            echo "0";
        }

    }

    function send_mail(){

        if (isset($_POST['email'])) {
            global $user;
            $email = $_POST['email'];

            $result = $user->get_user_by_email($email);
            if ($result->num_rows === 0) {
                echo "0";
            } else {
                $user->sendMail($email);
                echo "1";
            }
        } else {
            echo "Uneti podatke!";
        }

    }

if (isset ($_POST["action"])){

    switch ($_POST["action"]){

        case "wishlist":
            add_to_wishlist();
            break;
        case "login_validation" :
            login_validation();
            break;
        case "insert_question" :
            insert_question();
            break;
        case "send_mail":
            send_mail();
            break;
    }

}else if (isset($_GET['action'])){
    switch ($_GET["action"]) {
        case "delete_review":
            delete_review();
            break;
        case "signup_validation":
            signup_validation();
            break;
    }

}else{
echo "0";
}
