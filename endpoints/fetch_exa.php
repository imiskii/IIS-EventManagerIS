<?php
require '../config/common.php';

$db = connect_to_db();

$emailToSearch = 'sample@email.com';

// Use a prepared statement to fetch the account
$stmt = $db->prepare("SELECT * FROM Account WHERE email = :email");
$stmt->bindParam(':email', $emailToSearch);

$stmt->execute();

$account = $stmt->fetch(PDO::FETCH_ASSOC);

if ($account) {
    echo "Account details: \n";
    echo "ID: " . $account['id'] . "\n";
    echo "Email: " . $account['email'] . "\n";
    echo "First Name: " . $account['first_name'] . "\n";
    // ... print other details ...
} else {
    echo "No account found with email: " . $emailToSearch;
}

?>