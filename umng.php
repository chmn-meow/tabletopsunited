<?php
require_once ('includes.php');
session_start();

if (!check_valid_user()) {
    header("Location: users.php");
    exit;
}

$umng = new UserPage();

    $sidemenu = array(
        "View Your Profile" => "umng.php?vwpf=1",
        "Edit Information" => "umng.php?edusr=1",
        "Edit Bio" => "umng.php?edbio=1",
        "Change Profile Pic" => "umng.php?upht=1",
        "Change Password" => "umng.php?chpw=1",
        "Your Reviews" => "umng.php?vwrv=2",
        "Reviews of You" => "umng.php?vwrv=1"        
        );


@$change_password = htmlspecialchars($_GET['chpw']);
@$edit_user = htmlspecialchars($_GET['edusr']);
@$view_profile = htmlspecialchars($_GET['vwpf']);
@$edit_bio = htmlspecialchars($_GET['edbio']);
@$upload_photo = htmlspecialchars($_GET['upht']);
@$view_reviews = htmlspecialchars($_GET['vwrv']);



if (isset($change_password) && empty($edit_user) && empty($view_profile) && empty($edit_bio) && empty($upload_photo) && empty($view_reviews)) {
    if (($change_password) == 1) {
        $umng->DoHeader('Change Password');
        $content = "<p>Please fill out the form below completely.<br />Reminder: all passwords must be between 6 and 16 characters.</p>";
        $umng->DoBody($content, '2', $sidemenu);
        $umng->DisplayPasswordForm();
        $umng->DoFooter();
        exit;
    } else if (($change_password) == 2) {
        if ((@$_POST['old_password']) || (@$_POST['new_password']) || (@$_POST['new_password2'])) {
            //they have just tried to register
    
            $new_password = $_POST['new_password'];
            $new_password2 = $_POST['new_password2'];
            $old_password = $_POST['old_password'];

            if(!filled_out($_POST)) {
                $umng->DoHeader('Change Password');
                $content = "<p>You didn't fill out the form completely, please try again.</p>";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DisplayPasswordForm();
                $umng->DoFooter();
                exit;
            }
            try {
            change_password($_SESSION['valid_user'], $old_password, $new_password, $new_password2);

                $umng->DoHeader('Success');
                $content = "<p>You have successfully changed your password.</p>";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }   
            //couldn't change password
            catch (Exception $e) {
            $error_message = $e->getMessage();
            $umng->DoHeader('Problem');
            $content = "<p>Sorry, there was a problem: ".$error_message."</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DisplayPasswordForm();
            $umng->DoFooter();
            exit;
            }
        }
    }
}



if (isset($edit_user) && empty($change_password) && empty($view_profile) && empty($edit_bio) && empty($upload_photo) && empty($view_reviews)) {
    if (($edit_user) == 1){
        $userinfo = get_user_details($_SESSION['valid_user']);
        if (!empty($userinfo)) {
            $umng->DoHeader('Update Your Information');
            $content = "<p>Please don't empty required fields.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DisplayUserUpdateForm($userinfo);
            $umng->DoFooter();
            exit;
        } else {
            $umng->DoHeader('Problem');
            $content = "<p>We could not retrieve your user details at this time.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
        }
    } else if (($edit_user) == 2) {
        if ((@$_POST['fname']) || (@$_POST['lname']) || (@$_POST['email']) || (@$_POST['address']) || 
            (@$_POST['city']) || (@$_POST['state']) || (@$_POST['zip']) || (@$_POST['country'])) {
            
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $zip = $_POST['zip'];
            $country = $_POST['country'];
            
            try {
                $username = $_SESSION['valid_user'];
                update($username, $fname, $lname, $email, $city, $zip, $country, $state, $address);
                $umng->DoHeader('Success');
                $content = "<p>Your information has successfully been updated.</p>";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }
            catch (Exception $e) {
                $umng->DoHeader('Update Your Information', '1');
                $error_message = $e->getMessage();
                $content = "<p>There was a problem: ".$error_message."<br />Please try again later.";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }
        }
    }
}



if (isset($edit_bio) && empty($change_password) && empty($view_profile) && empty($edit_user) && empty($upload_photo) && empty($view_reviews)) {
    if (($edit_bio) == 1){
        $userprofile = get_user_profile($_SESSION['valid_user']);
        if (!empty($userprofile)) {
            $umng->DoHeader('Update Your Bio');
            $content = "<p>Edit the bio section of your profile.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DisplayUserBioForm($userprofile);
            $umng->DoFooter();
            exit;
        } else {
            $umng->DoHeader('Problem');
            $content = "<p>We could not retrieve user details at this time.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
        }
    } else if (($edit_bio) == 2) {
        if ((@$_POST['bio']) || (@$_POST['games']) || (@$_POST['interested'])) {
            
            $bio = $_POST['bio'];
            $games = $_POST['games'];
            $interested = $_POST['interested'];
            
            try {
                $username = $_SESSION['valid_user'];
                update_bio($username, $bio, $games, $interested);
                $umng->DoHeader('Success');
                $content = "<p>Your bio has successfully been updated.</p>";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }
            catch (Exception $e) {
                $umng->DoHeader('Update Your Information', '1');
                $error_message = $e->getMessage();
                $content = "<p>There was a problem: ".$error_message."<br />Please try again later.";
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }
        }
    }
}



if (isset($upload_photo) && empty($edit_bio) && empty($change_password) && empty($view_profile) && empty($edit_user) && empty($view_reviews)) {
    if (($upload_photo) == 1){
        $userid = get_userid($_SESSION['valid_user']);
        if (!empty($userid)) {
            $umng->DoHeader('Updload Profile Picture');
            $content = '<h2>Upload a picture to your profile</h2><h5>Reminder: Please only upload .jpg at this time</h5>';
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DisplayFileUpload();
            $umng->DoFooter();
            exit;
        } else {
            $umng->DoHeader('Problem');
            $content = "<p>We could not set up the transfer at this time.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
        }
    } else if (($upload_photo) == 2) {
        if ($_FILES['userfile']['error'] > 0) {
            switch ($_FILES['userfile']['error']){
                case 1:
                    $content = "File exceeded max upload filesize";
                    break;
                case 2:
                    $content = "File exceeded max filesize";
                    break;
                case 3:
                    $content = "File was only partially uploaded";
                    break;
                case 4:
                    $content = "No file uploaded";
                    break;
                case 6:
                    $content = "Couldn't upload file: No temp directory specified";
                    break;
                case 7:
                    $content = "Upload failed: couldn't write to disk";
                    break;
            }
            $umng->DoHeader('Problem');
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
        }
        
        if (($_FILES['userfile']['type'] != 'image/jpeg')) {
            
            $umng->DoHeader('Problem');
            $content = "<p>The file must be .jpg at this time</p>";
            $umng->Dobody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
            } else {
            define ('SITE_ROOT', realpath(dirname(__FILE__)));
            $ext = get_ext($_FILES['userfile']['name']);
            $name = get_userid($_SESSION['valid_user']);
            
            $upfile = SITE_ROOT.'\\img\\users\\'.$name.'.'.$ext;
            
            
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)) {
                    $umng->DoHeader('Problem');
                    $content = "couldn't move file to destination directory";
                    $umng->DoBody($content, '2', $sidemenu);
                    $umng->DoFooter();
                    exit;
                } else {
                    $umng->DoHeader('Success?');
                    $content = "Looks like everything worked";
                    $umng->DoBody($content, '2', $sidemenu);
                    $umng->DoFooter();
                    exit;
                } 
            } else {
                $umng->DoHeader('problem');
                $content = "This is a possible file upload attack. Filename: ".$_FILES['userfile']['name'];
                $umng->DoBody($content, '2', $sidemenu);
                $umng->DoFooter();
                exit;
            }
        }
    }
}



if(isset($view_profile) && empty($change_password) && empty($edit_user) && empty($edit_bio) && empty($upload_photo) && empty($view_reviews)) {
    if (($view_profile) == 1) {
        $umng->DoHeader('Your Profile');
        
        $username = $_SESSION['valid_user'];
        $userinfo = get_user_details($username);
        $userid = get_userid($username);
        $userprofile = get_user_profile($username);
        
        if (!empty($userinfo) && !empty($userid) && !empty($userprofile)){
            $content = "<p> This is your profile:</p><br /><br />";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->BuildProfile($userid, $username, $userprofile, $userinfo);
            $umng->DoFooter();
            exit;
        } else {
            $umng->DoHeader('Problem');
            $content = "<p>We could not retrieve your user details at this time.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $umng->DoFooter();
            exit;
        }
    }
}



if(isset($view_reviews) && empty($view_profile) && empty($change_password) && empty($edit_user) && empty($edit_bio) && empty($upload_photo)) {
    $userid = get_userid($_SESSION['valid_user']);
    if (($view_reviews) == 1) {
        $umng->DoHeader('Reviews of You');
        $content = "<p>Here are the reviews other's have made.</p>";
        $umng->DoBody($content, '2', $sidemenu);
        
        
        $rev_array = get_reviews_of_user($userid);
        display_reviews_user($rev_array);
        
        $umng->DoFooter();
        exit;
        } else if (($view_reviews) == 2) {
            $umng->DoHeader('Reviews You\'ve Made');
            $content = "<p>Here are the reviews that you've submitted.</p>";
            $umng->DoBody($content, '2', $sidemenu);
            $rev_array = get_reviews_user($userid);
            display_reviews_user($rev_array);
            
            $umng->DoFooter();
            exit;
        } else if (($view_reviews) == 3) {
            $target = htmlspecialchars($_GET['edrv']);
            $umng->DoHeader('Submit a review');
            $content = "<p>Type up your review below</p>";
            $umng->DoBody($content);
            $umng->DisplayReviewForm($target);
            $umng->DoFooter();
            exit;
        } else if (($view_reviews) == 4) {
            if ((@$_POST['review'])) {
                $target = htmlspecialchars($_GET['edrv']);
                $review = $_POST['review'];
                
                if (!filled_out($_POST)) {
                    $umng->DoHeader('Problem');
                    $content = "<p>You didn't write anything.</p>";
                    $umng->DoBody($content);
                    $umng->DoFooter();
                    exit;
                }
                
                try {
                    $username = $_SESSION['valid_user'];
                    submit_review($username, $target, $review);
                    $umng->DoHeader('Success');
                    $content = "<p>Your review has been input.</p>";
                    $umng->DoBody($content);
                    $umng->DoFooter();
                    exit;
                }
                catch (Exception $e) {
                    $umng->DoHeader('Problem');
                    $error_message = $e->getMessage();
                    
                }
            }
        } else if (($view_reviews) == 5) {
            $reviewid = htmlspecialchars($_GET['edrv']);
            $review = get_review($reviewid);
            $umng->DoHeader('Edit your review');
            $content = "<p>Edit your review below</p>";
            $umng->DoBody($content);
            $umng->DisplayReviewUpdateForm($review);
            $umng->DoFooter();
            exit;
        } else if (($view_reviews) == 6) {
            $reviewid = htmlspecialchars($_GET['edrv']);
            $review = @$_POST['review'];
            $delete = @$_POST['delete'];
            
            
            if (isset($delete) || empty($review)) {
                $input = false;
            } else {
                $input = $review;
            }
            
            try {
                $username = $_SESSION['valid_user'];
                submit_review_update($username, $reviewid, $input);
                
            }
            catch (Exception $e) {
                $umng->DoHeader('Problem');
                $error_message = $e->getMessage();
                $content = "<p>There was a problem: ".$error_message."<br />Please try again later.";
                $umng->DoBody($content);
                $umng->DoFooter();
                exit;
            }
        }
    }

    $content = "<p>This is the area where you'll be able to manage your account and profile information</p>";

    $umng->DoHeader('Account Management');
    $umng->DoBody($content, '2', $sidemenu);
    $umng->DoFooter();

?>