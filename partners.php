<?php
require_once ('includes.php');
session_start();

$partners = new AboutPage();
$partners->DoHeader();
echo "<h3>Here are all our current partners:</h3>\n
       <ul>\n
         <li>Meriksabers</li>\n
         <li>Oursleves</li>\n
       </ul>\n";          
$partners->DoFooter();
?>