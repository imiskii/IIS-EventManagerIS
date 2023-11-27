<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$valid_columns = ['comment_text', 'comment_rating', 'event_id', 'account_id'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if(insert_into_table('Comment', $input_data)) {
    setPopupMessage('success', 'comment posted successfully.');
} else {
    setPopupMessage('error', 'failed to post comment.');
}

redirectForce('../../event-detail?event_id='.$input_data['event_id']);

?>
