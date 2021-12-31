<?php
require_once ('includes.php');
session_start();

$faqs = new AboutPage();
$faqs->DoHeader();
echo "<p>We haven't been asked any questions yet.  You can certainly ask away at <u>companymain@tabletopsunited.com</u></p>";
$faqs->DoFooter();
?>