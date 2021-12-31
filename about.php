<?php
require_once ('includes.php');
session_start();

$about = new AboutPage();
$about->DoHeader();
echo "<p>We are a few dudes with programming/gaming experience who don't do this fulltime.  We'd like to change that.</p>";
$about->DoFooter();
?>