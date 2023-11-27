<?php

require_once '../../common/db_handler.php';
require_once '../../common/input_validator.php';

session_start();
$db = connect_to_db();

if(!verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

$delete_id = [$_POST['comment_id']];
if (!delete_from_table('Comment', $delete_id, 'comment_id')) {
    setPopupMessage('error', 'could not delete the comment');
} else {
    setPopupMessage('success', 'comment deleted successfully.');
}

redirect('../../index.php');

?>
