<?php
require '../config/common.php';

$db = connect_to_db();

$email = 'sampleemail.com';
$firstName = 'John';
$lastName = 'Doeringo';
$nick = 'johndoe123';
$password = 'sample_password'; // Always hash your passwords, don't store them as plain text!
$accountType = 'standard';
$status = 'active';

// Use a prepared statement to insert the account
$stmt = $db->prepare("INSERT INTO Account (email, first_name, last_name, nick, password, account_type, status) VALUES (:email, :first_name, :last_name, :nick, :password, :account_type, :status)");

$stmt->bindParam(':email', $email);
$stmt->bindParam(':first_name', $firstName);
$stmt->bindParam(':last_name', $lastName);
$stmt->bindParam(':nick', $nick);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':account_type', $accountType);
$stmt->bindParam(':status', $status);

if ($stmt->execute()) {
    echo "Account added successfully!";
} else {
    echo "Error adding account!";
}

?>
