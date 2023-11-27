<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$valid_columns = ['comment_text'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$error_msg_array = [];
if (!validateData($input_data, $error_msg_array)) {
    setPopupMessage('error', implode(' ', $error_msg_array));
    redirect('../../index.php');
}

if(update_table_row('Comment', $input_data, 'comment_id', $_POST['comment_id'])) {
    setPopupMessage('success', 'comment edited successfully.');
} else {
    setPopupMessage('error', 'failed to edit the comment.');
}

redirect('../../index.php');

?>
