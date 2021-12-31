<?php
require_once ('includes.php');
session_start();

$mktplc = new MktPage();
$mktplc->DoHeader();
echo "<p>Coming soon. This area is currently under construction.</p>";
$mktplc->DoFooter();
?>