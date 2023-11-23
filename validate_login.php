<?php

require_once "config/common.php";

session_start();
if (isset($_SESSION['return_to'])) {
    echo $_SESSION['return_to'];
} else {
    echo "no return value";
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

// TODO: popups: missing email or password or invalid password
if (!isset($_POST["email"]) || !isset($_POST["pwd"])) {
    return;
}

$db = connect_to_db();

$id_array = ["email" => $_POST["email"], "password" => $_POST["pwd"]];
session_handler("Login", $id_array, "not_logged_in");

?>
