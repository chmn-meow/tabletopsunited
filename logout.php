<?php
require_once ('includes.php');
session_start();
unset($_SESSION['valid_user']);
header("Location: index.php");
?>