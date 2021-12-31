<?php
require_once ('includes.php');
session_start();

$umkt = new UserPage();

if (check_valid_user()) {
    $umkt->DoHeader();
    echo "<p>Here is a listing of the shit you're trying to sell.</p>"; 
    $umkt->DoFooter();
} else {
    header("Location: users.php");
    exit();
}

?>