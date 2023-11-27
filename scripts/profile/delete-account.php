<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$valid_columns = ['comment_text', 'comment_password'];
$input_data = [];
loadInputData($_POST, $input_data, $valid_columns);

$delete_values = [getUserAttribute('account_id')];
if(delete_from_table('Account', $delete_values, 'account_id')) {
    unset($_SESSION['USER']);
    setPopupMessage('success', 'account deleted successfully!');
    redirectForce('../../index.php');
} else {
    setPopupMessage('error', 'could not delete the account.');
    redirect('../../index.php');
}

?>
