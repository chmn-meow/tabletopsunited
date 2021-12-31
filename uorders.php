<?php
require_once ('includes.php');
session_start();

  $uorders = new UserPage();
  
if (check_valid_user()) {
    $uorders->DoHeader();
    echo "<p>Here's all the shit you ordered.</p>"; 
    $uorders->DoFooter();
} else {
    header("Location: users.php");
    exit;
}
?>