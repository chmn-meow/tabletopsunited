<?php
require_once ('includes.php');
session_start();

$mission = new AboutPage();
$mission->DoHeader();
echo "<h3>Our goals and aims are as follows:</h3>\n
        <ul>\n
          <li>Help creative people get their content to the people who'd appreciate it</li>\n
          <li>Provide content and tools to enhance gamer experience</li>\n
          <li>Help make the things we're passionate about more awesome and interactive</li>\n
          <li>Do this full time</li>\n
        </ul>\n";
$mission->DoFooter();
?>