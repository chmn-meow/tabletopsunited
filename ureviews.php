<?php
require_once ('includes.php');
session_start();

if (!check_valid_user()) {
    header("Location: users.php");
    exit;
}

$urevs = new UserPage();



    $urevs->DoHeader();
    echo "<p>This is where you'll see the reviews that ruined someone's day.</p>"; 
    $urevs->DoFooter();
?>