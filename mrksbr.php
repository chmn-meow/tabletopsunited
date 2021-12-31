<?php
require_once ('includes.php');
session_start();
  
$owens = new MktPage();
$owens->DoHeader();
echo "<p>This is where you will be able to get Owens' laser swords 'n' shit.</p>";
$owens->DoFooter();
?>