<?php


require_once "../../common/db_handler.php";

session_start();

if (isset($_SESSION["USER"])) {
    unset($_SESSION["USER"]);
}

redirectForce('../../index.php');
?>
