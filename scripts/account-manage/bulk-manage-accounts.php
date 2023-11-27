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
$valid_columns = ['delete', 'change_status', 'account_id'];
loadInputData($_POST, $input_data, $valid_columns);

if(!key_exists('account_id', $input_data)) {
    setPopupMessage('warning', 'no categories were selected');
    redirect('../../index/php');
}


foreach($input_data['account_id'] as $account_id) {
    if (getAccountType($account_id) == 'administrator' && !idMatchesUser($account_id)) {
        setPopupMessage('error', 'cannot edit account of another administrator!');
        redirect('../../index.php');
    }
}

if (in_array('delete', $input_data)) {
    if(!delete_from_table('Account', $input_data['account_id'], 'account_id')) {
        setPopupMessage('error', 'could not delete the selected accounts.');
    } else {
        setPopupMessage('success', 'selected accounts deleted successfully.');
    }
} else {
    $active_accounts = getTableColumnsByValue('Account', 'account_id', $input_data['account_id'], 'account_status', 'active');
    $disabled_accounts = getTableColumnsByValue('Account', 'account_id', $input_data['account_id'], 'account_status', 'disabled');
    if (!empty($active_accounts) && !update_table_column('Account', 'SET account_status = "disabled"', 'account_id IN ("'.implode('", "', $active_accounts).'")', null) ||
        !empty($disabled_accounts) && !update_table_column('Account', 'SET account_status = "active"', 'account_id IN ("'.implode('", "', $disabled_accounts).'")', null) ) {
        setPopupMessage('error', 'could not change status on the selected accounts.');
    } else {
        setPopupMessage('success', 'selected accounts updated successfully!');
    }
}

redirect('../../index.php');

?>
