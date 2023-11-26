<?php

require_once "../common/db_handler.php";

session_start();

if (!verifyMethod('POST') || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../index.php');
}
$db = connect_to_db();

// TODO: validate values
$distinct_values['email'] = $_POST['email'];
$distinct_values['nick'] = $_POST['nick'];

$conflicting_email = fetch_table_entry('Account', 'email', ['email' => $_POST['email']], 'email = :email');
if (!empty($conflicting_email)) {
    echo "Account with this email already exists!";
    exit;
}
$conflicting_nick = fetch_table_entry('Account', 'nick', ['nick' => $_POST['nick']], 'nick = :nick');
if (!empty($conflicting_nick)) {
    echo "Account with this nick already exists!";
    exit;
}

if($_POST['password'] != $_POST['password2']) {
    setPopupMessage('error', 'passwords do not match!');
    redirect('../index.php');
    exit;
}

$db_columns = ['password', 'nick', 'first_name', 'last_name', 'email'];
foreach ($db_columns as $column) {
    $id_array[$column] = $_POST[$column];
}

$id_array['account_type'] = 'regular';
$id_array['account_status'] = 'active';

if (!insert_into_table('Account', $id_array)) {
    echo 'Error!';
    exit;
}

$id_array = ["email" => $_POST["email"], "password" => $_POST["password"]];
session_handler("Login", $id_array, "not_logged_in");

redirect('../index.php');
