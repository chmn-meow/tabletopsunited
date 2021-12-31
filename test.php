<?php
require_once ('includes.php');
session_start();

$test = new Page();
$test->DoHeader();
$test->DoBody();
$test->DoFooter();

?>