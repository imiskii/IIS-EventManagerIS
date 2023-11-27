<?php
require_once "../../common/db_handler.php";
require_once '../../common/input_validator.php';

session_start();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirect('../../index.php');
}

$db = connect_to_db();

$input_data = [];
$valid_columns = ['delete', 'reg_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('reg_id', $input_data)) {
    setPopupMessage('warning', 'no registrations were selected');
    redirect('../../index/php');
}

if (in_array('delete', $input_data)) {
    if(!delete_from_table('Registration', $input_data['reg_id'], 'reg_id')) {
        setPopupMessage('error', 'could not delete the selected registrations.');
    } else {
        setPopupMessage('success', 'registrations deleted successfully.');
    }
}

redirect('../../index.php');

?>
