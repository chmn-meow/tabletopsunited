<?php
require_once ('includes.php');
session_start();

$users = new UserPage();


if ((@$_POST['username']) && (@$_POST['password'])) {
//they have just tried to log in
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(check_valid_user()){
        $users->DoHeader();
        echo "<p>You are already logged in.</p>";
        $users->DoFooter();
        exit;
    }
    if(login($username, $password)) {
    //if they are in the database, register the user id
        $_SESSION['valid_user'] = $username;
    } else {
    //unsuccessful login 
        $notusers = new Page();  
        $notusers->DoHeader('Login', '1');
        echo "<p>You could not be logged in, please try again later.</p>";
        $notusers->DoFooter();
        exit;
    }
}
    


if (!check_valid_user()) {
    $notusers = new Page();
    $notusers->DoHeader('Login', '1');
    echo "<p>You need to be logged in to use the user area, moron!</p>"; 
    $notusers->DisplayLoginForm();
    $notusers->DoFooter();
    exit;
} else {

    @$view_profile = htmlspecialchars($_GET['vwusr']);

    if(!empty($view_profile)) {
        $userid = clean_db($view_profile);
        $username = get_username($userid);
        $userprofile = get_user_profile($username);
        $userinfo = get_user_details($username);
    
        if (!empty($userinfo) && !empty($userid) && !empty($userprofile)){
            $users->DoHeader($username.'\'s Profile');
            $content = "";
            $users->DoBody($content);
            $users->BuildProfile($userid, $username, $userprofile, $userinfo);
            $users->DoFooter('1');
            exit;
        } else {
            $users->DoHeader('Problem');
            $content = "<p>Couldn't find the user specified</p>";
            $users->DoBody($content);
            exit;
        }
    }

    $users->DoHeader();
    echo "<p>This area is under construction.  We would like to use you soon, user!</p>";
    $users->DoFooter();
    exit;
} 




?>