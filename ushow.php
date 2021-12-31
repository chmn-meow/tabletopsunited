<?php
require_once ('includes.php');
session_start();

$umktplc = new MktPage();
$umktplc->DoHeader();
echo "<p>This is where the user driven content will be.</p>";
$umktplc->DoFooter();
?>