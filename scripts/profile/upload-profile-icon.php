<?php

require_once '../../common/db_handler.php';

session_start();
$db = connect_to_db();

if(!userIsLoggedIn() || !verifyToken($_POST)) {
    setPopupMessage('error', 'unauthorized access!');
    redirectForce('../../index.php');
}

if($_FILES['profile-icon']['error'] != UPLOAD_ERR_OK) {
    setPopupMessage('error', 'could not upload profile icon.');
    redirect('../../index.php');
}

$tmp_filename = $_FILES['profile-icon']['tmp_name'];
if(!exif_imagetype($tmp_filename)) {
    setPopupMessage('error', 'invalid file format!');
    redirect('../../index.php');
}

$filename = $_FILES['profile-icon']['name'];
$extension = pathinfo($_FILES['profile-icon']['name'], PATHINFO_EXTENSION);
$icon_location = 'user-icons/' . getUserAttribute('account_id') . '.' . $extension ;
$max_filename_length = 256;
if(mb_strlen($icon_location) > 256) { // extremely rare occasion if someone tries to "attack" server by made-up file extension but valid actual file format.
    setPopupMessage('error', "invalid file extension '$extension'.");
    redirect('../../index.php');
}

$umask = umask(); // store current umask
umask(000);
if (!move_uploaded_file($tmp_filename, '../../'.$icon_location)) {
    setPopupMessage('error', "unable to store the profile icon.");
    redirect('../../index.php');
}
umask($umask); // load umask back

setUserAttribute('profile_icon', $icon_location);
$id_array['profile_icon'] = $icon_location;
$id_array['account_id'] = getUserAttribute('account_id');
update_table_column('Account', 'SET profile_icon = :profile_icon', 'account_id = :account_id', $id_array);

setPopupMessage('success', 'icon updated successfully!');
redirect('../../index.php');

?>
