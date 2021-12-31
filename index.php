<?php
require_once ('includes.php');
session_start();

$home = new Page();
$home->DoHeader();
echo "<p>Welcome to Tabletops United.  We hope to see you soon.</p>";
$home->DoFooter();
?>