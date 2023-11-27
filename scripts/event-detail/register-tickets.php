<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$input_data['instance_id'] = $_POST['instance_id'];
$input_data['account_id'] = getUserAttribute('account_id');
for($i = 0; $i < sizeof($_POST['fee_name']); $i++) {
    $input_data['fee_name'] = $_POST['fee_name'][$i];
    $input_data['ticket_count'] = $_POST['ticket_count'][$i];
    if (!insert_into_table('Registration', $input_data)) {
        setPopupMessage('error', 'could not register the tickets.');
        redirect('../../index.php');
    }
}

setPopupMessage('success', 'tickets registered successfully. Please wait for confirmation of the owner.');
redirect('../../index.php');

?>
