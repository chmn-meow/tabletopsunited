<?php
require_once ('includes.php');
session_start();

$gmportal = new Page();
$gmportal->DoHeader();
echo "<p>This is where you'll be able to search for other people and shit.</p>";
$gmportal->DoFooter();
?>