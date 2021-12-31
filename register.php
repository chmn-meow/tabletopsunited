<?php
require_once ('includes.php');
session_start();

$register = new Page();

if ((@$_POST['username']) || (@$_POST['password']) || (@$_POST['password2']) || (@$_POST['fname']) || (@$_POST['lname']) 
    || (@$_POST['email']) || (@$_POST['address']) || (@$_POST['city']) || (@$_POST['state']) || (@$_POST['zip']) || (@$_POST['country'])) {
    //they have just tried to register
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    
    try {
    register($username, $password, $password2, $fname, $lname, $email, $city, $zip, $country, $state, $address);
        //if they're successfully input, register them
        $_SESSION['valid_user'] = $username;
        $register->DoHeader();
        echo "<p>Thank you for registering, everything went smoothly.<br />Your username is: ".$username.".<br />  If this is incorrect, please contact the
                                support section.</p>";
        $register->DoFooter();
        exit;
    }   
    //unsuccessful registration
    catch (Exception $e) {
        $register->DoHeader('Register', '1');
        $error_message = $e->getMessage();
        echo "<p>Sorry, there was a problem: ".$error_message."<br />Please try again.</p>";        
        $register->DoFooter();
        exit;
    }
}

if (check_valid_user()) {
    $register->DoHeader();
    echo "<p>You are already registered.  If you'd like to change anything about your account, please click <a href=\"umng.php\" class=\"body\">here</a></p>";
    $register->DoFooter();
} else {
    $register->DoHeader('Register', '1');
    $content = "<p>Registration form:</p>";
    $register->DoBody($content, '1', '', '2');
    exit;
}