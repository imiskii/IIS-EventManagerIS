<?php
// FIXME = queries accepting even when they shouldn't
require_once "../common/db_handler.php";
session_start();
$db = connect_to_db();

$category_columns = ['category_name', 'category_description'];
$session_category_columns = array_map(function($value) {
    return 'suggest-category_'.$value;
}, $category_columns);
storeInSession($_GET, $category_columns, 'suggest-category_');

if(!checkRequired($_GET, $category_columns)) {
    //TODO: display error message
    redirect('../index.php');
}

$id_array = [];
populateArray($_GET, $id_array, $category_columns);
$id_array['category_status'] = 'pending';
$id_array['account_id'] = getUserAttribute('account_id');
if (insert_into_table('Category', $id_array)) {
    unsetSessionAttributes($session_category_columns);
}

redirect('../index.php');

?>
