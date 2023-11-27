<?php

require_once "../../common/db_handler.php";
require_once "../../common/input_validator.php";

session_start();

if (!verifyMethod('POST') || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}
$db = connect_to_db();

$valid_columns = ['nick', 'first_name', 'last_name', 'email', 'password', 'password2'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);
$errmsg_array = [];
if(!validateData($input_data, $errmsg_array)) {
    setPopupMessage('error', implode(' ', $errmsg_array));
    redirect('../../index.php');
}

$conflicting_email = fetch_table_entry('Account', 'email', ['email' => $_POST['email']], 'email = :email');
if (!empty($conflicting_email)) {
    setPopupMessage('error', 'Account with this email already exists!');
    redirect('../../index.php');
}
$conflicting_nick = fetch_table_entry('Account', 'nick', ['nick' => $_POST['nick']], 'nick = :nick');
if (!empty($conflicting_nick)) {
    setPopupMessage('error', 'Account with this nick already exists!');
    redirect('../../index.php');
}

if($_POST['password'] != $_POST['password2']) {
    setPopupMessage('error', 'passwords do not match!');
    redirect('../../index.php');
}

unset($input_data['password2']);
$input_data['account_type'] = 'regular';
$input_data['account_status'] = 'active';

if (!insert_into_table('Account', $input_data)) {
    setPopupMessage('error', 'could not create new account');
    redirect('../../index.php');
}

$id_array = ["email" => $_POST["email"], "password" => $_POST["password"]];
session_handler("Login", $id_array, "not_logged_in");

setPopupMessage('success', 'registration successful!');
redirectForce('../../index.php');
