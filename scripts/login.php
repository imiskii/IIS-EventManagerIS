<?php

require_once "../common/db_handler.php";

session_start();

if (userIsLoggedIn() || $_SERVER["REQUEST_METHOD"] != "POST") {
    redirect('../index.php');
}

// TODO: popups: missing email or password or invalid password
if (!isset($_POST["email"]) || !isset($_POST["pwd"])) {
    redirect('../index.php');
}

$db = connect_to_db();

$id_array = ["email" => $_POST["email"], "password" => $_POST["pwd"]];
session_handler("Login", $id_array, "not_logged_in");

redirect('../index.php');
?>
