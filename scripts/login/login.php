<?php

require_once "../../common/db_handler.php";

session_start();

if (userIsLoggedIn() || $_SERVER["REQUEST_METHOD"] != "POST") {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$id_array = ["email" => $_POST["email"], "password" => $_POST["pwd"]];
if (($errmsg = session_handler("Login", $id_array, "not_logged_in")) != null) {
    setPopupMessage('error', $errmsg);
    redirect('../../index.php');
}

setPopupMessage('success', 'login succesful!');

redirectForce('../../index.php');
?>
