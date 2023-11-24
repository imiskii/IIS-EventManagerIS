<?php


require_once "../config/common.php";

session_start();

if (isset($_SESSION["USER"])) {
    unset($_SESSION["USER"]);
}

redirectForce('../index.php');
?>
