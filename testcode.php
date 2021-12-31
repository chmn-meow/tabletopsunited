<?php
require_once ('includes.php');
session_start();
    $sidemenu = array(
        "View admin profile" => "users.php?vwusr=1");

$test = new Page();



$form = '';




    @$view_profile = htmlspecialchars($_GET['vwusr']);

    if(!empty($view_profile)) {
        $userid = clean_db($view_profile);
        $username = get_username($userid);
        $userprofile = get_user_profile($username);
        $userinfo = get_user_details($username);
    
        if (!empty($userinfo) && !empty($userid) && !empty($userprofile)){
            $test->DoHeader($username.'\'s Profile');
            $content = "";
            $test->DoBody($content);
            $test->BuildProfile($userid, $username, $userprofile, $userinfo);
            
            
            echo "    <div class=\"content\">
                        <h2>
                            Reviews of this user:
                        </h2>
                        <h4>";
            $rev_array = get_review_user($userid);
            display_reviews_user($rev_array);            
            echo "</div>";
                        
            
            
            
            
            $test->DoFooter();
            exit;
        } else {
            $test->DoHeader('Problem');
            $content = "<p>Couldn't find the user specified</p>";
            $test->DoBody($content);
            $test->DoFooter();
            exit;
        }
    }








$test->DoHeader('Testbed');

$username = $_SESSION['valid_user'];

$userinfo = get_user_details($username);
$userid = get_userid($username);
$content = "<p>This is a testbed</p>";
$test->DoBody($content, '2', $sidemenu);
$test->DoFooter('2');
?>