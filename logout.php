<?php

session_start();

if (isset($_SESSION["USER"])) {
    unset($_SESSION["USER"]);
}

header('Location: ' . (isset($_SESSION['return_to']) ? $_SESSION['return_to'] : "index.php"));

?>
