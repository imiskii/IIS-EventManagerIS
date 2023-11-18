<?php 
    if ($table == "Login" && $account_type == "not_logged_in") {
        $query = "SELECT password, account_type FROM Account WHERE email = :email";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $stored_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$stored_data){
            sendResponse(401, "No user with provided email exists.\n");
            return;
        }

        // if (password_verify($data['pwd'], $stored_data['pwd'])) { // right now we don't hash passwords
        if ($stored_data['password'] == $data['password']){
            $_SESSION['account_type'] = $stored_data['account_type'];
            sendResponse(200, "Log in successfull.\n");
        }
        else{
            sendResponse(401, "Log in failed: No email-password configuration found or valid.\n");
        }
    }
    else if ($table == 'Login' && $account_type != "not_logged_in") {
        sendResponse(200, "You are already logged in.\n");
    }
    else if ($table == 'Logout' && $account_type != "not_logged_in") {
        session_destroy();
        sendResponse(200, "Log out successfull.\n");
    }
    else {
        sendResponse(400, "Attempt to Log out error: user was never logged in.\n");
    }
?>