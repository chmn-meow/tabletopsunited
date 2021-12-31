<?php
require_once ('includes.php');
session_start();

$ourmkt = new MktPage();
$ourmkt->DoHeader();
echo "<p>This is where we will put our shit.</p>";
$ourmkt->DoFooter();
?>