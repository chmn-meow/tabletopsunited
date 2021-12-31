<?php
require_once ('includes.php');
session_start();

$contact = new AboutPage();
$contact->DoHeader();
echo "<p>Currently, you can contact us one of three ways: <br /><u>companymain@tabletopsunited.com</u><br />P.O. Box bleh<br />Not contact us</p>";
$contact->DoFooter();
?>