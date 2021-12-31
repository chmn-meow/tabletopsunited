<?php
require_once ('db_fns.php');
require_once ('data_val_fns.php');


function check_valid_user() {
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['valid_user'])) {
    return true;
  } else {
    return false;
  }
}


function login($username, $password) {
// check username and password with db.  If yes, return true, else return false

  // connect to db
  $conn = db_conn();
  if (!$conn) {
    return 0;
  }

  //fix the untrustworthy
  $username = clean_db($username);
  $password = clean_db($password);
  
  // check if username is unique
  $result = $conn->query("select * from users_auth where username='".$username."' and password = sha1('".$password."')");
  if (!$result) {
     return 0;
  }

  if ($result->num_rows>0) {
     return 1;
  } else {
     return 0;
  }
}


function change_password($username, $old_password, $new_password, $new_password2) {
// change password for the user

  //first, clean the untrustworthy
  $username = clean_db($username);
  $old_password = clean_db($old_password);
  $new_password = clean_db($new_password);
  $new_password2 = clean_db($new_password2);
  
  
  // if there isn't anything there for input, throw that shit
  if (!isset($new_password) || !isset($new_password2) || !isset($old_password)) {
    throw new Exception("You haven't filled everything out.");
  }
  
  //make sure they match
  if ($new_password != $new_password2) {
    throw new Exception("Those passwords do not match.");
  }
  
  //make sure they meet our params
  if ((strlen($new_password)>16) || (strlen($new_password)<6)) {
    throw new Exception("The new password must be between 6 and 16 characters.");
  }
  
  // make sure that the old password is right
  if (login($username, $old_password)) {

    if (!($conn = db_conn())) {
      throw new Exception("Can't update your password at this time.");
    }

    $result = $conn->query("update users_auth set password = sha1('".$new_password."') where username = '".$username."'");
    if (!$result) {
      throw new Exception("We couldn't update your password for you at this time, please try again.");  // not changed
    } else {
      return true;  // changed successfully
    }
  } else {
    throw new Exception("That password was incorrect."); // old password was wrong
  }
}


function register($username, $password, $password2, $fname, $lname, $email, $city, $zip, $country, $state, $address) {
    // connect to db
    $conn = db_conn();
    
    //fix the untrustowrth
    $username = clean_db($username);
    $password = clean_db($password);
    $password2 = clean_db($password2);
    $fname = clean_db($fname);
    $lname = clean_db($lname);
    $email = clean_db($email);
    $city = clean_db($city);
    $zip = clean_db($zip);
    $country = clean_db($country);
    $state = clean_db($state);
    $address = clean_db($address);
    
  
        //try, and try again.
        if (!isset($username) || !isset($password) || !isset($password2) || !isset($fname) || !isset($lname) || !isset($email) || !isset($city) || !isset($zip) || !isset($country)) {
            throw new Exception('All of the required fields have not been filled in.');
        }
        if ($password != $password2) {
            throw new Exception('Those passwords did not match, please try again.');
        }
        if ((strlen($password) < 6) || (strlen($password) > 16)) {
            throw new Exception('Your password must be between 6 and 16 characters, please go back and try again.');
        }
        if (!valid_email($email)) {
            throw new Exception('Invalid email.');
        }
        if (strlen($zip) != 5) {
            throw new Exception('That zip is invalid');
        }
        if (strlen($state) != 2) {
            throw new Exception('State must be in two letter format.');
        }
        
        //try to input the new user
        if (input_new_user($username, $password, $fname, $lname, $email, $city, $zip, $country, $state, $address)) {
            return true;
        } else {
            throw new Exception('Unable to input user data');
        }
}


function update($username, $fname, $lname, $email, $city, $zip, $country, $state, $address) {
    // connect to db
    $conn = db_conn();
    
    //fix the untrustowrth
    $fname = clean_db($fname);
    $lname = clean_db($lname);
    $email = clean_db($email);
    $city = clean_db($city);
    $zip = clean_db($zip);
    $country = clean_db($country);
    $state = clean_db($state);
    $address = clean_db($address);
    
  
        //try, and try again.
        if (!isset($fname) || !isset($lname) || !isset($email) || !isset($city) || !isset($zip) || !isset($country)) {
            throw new Exception('One of the fields has been left empty.');
        }
        if (!valid_email($email)) {
            throw new Exception('Invalid email.');
        }
        if (strlen($zip) != 5) {
            throw new Exception('That zip is invalid.');
        }
        if (strlen($state) != 2) {
            throw new Exception('State must be in two letter format.');
        }
        
        //try to input the new user
        if (input_update_user($username, $fname, $lname, $email, $city, $zip, $country, $state, $address)) {
            return true;
        } else {
            throw new Exception('Unable to update user data.');
        }
}


function update_bio($username, $bio, $games, $interested) {
    // connect to db
    $conn = db_conn();
    
    //fix the untrustowrth
    $bio = clean_db($bio);
    $games = clean_db($games);
    $interested = clean_db($interested);
  
        //try to update the user's bio
        if (input_update_bio($username, $bio, $games, $interested)) {
            return true;
        } else {
            throw new Exception('Unable to update user data.');
        }
}


function get_user_details($username) {
    
    // query db to get userid
    if ((!$username) || ($username=='')) {
        return false;
    }
    $conn = db_conn();
    $userid = get_userid($username);
    $result = $conn->query("select * from user_info where userid='".$userid."'");
    if (!$result) {
        return false;
    }
    $userinfo = @$result->fetch_assoc();
    return $userinfo;
}

function get_user_profile($username) {
    
    // query db to get userid
    if ((!$username) || ($username=='')) {
        return false;
    }
    $conn = db_conn();
    $userid = get_userid($username);
    $result = $conn->query("select * from user_prof where userid='".$userid."'");
    if (!$result) {
        return false;
    }
    $userprofile = @$result->fetch_assoc();
    return $userprofile;
}

function submit_review($username, $target, $review) {
    // connect to db
    $conn = db_conn();
    
    //fix the untrustowrth
    $target = clean_db($target);
    $review = clean_db($review);
    
        //try to update the user's bio
        if (input_review($username, $target, $review)) {
            return true;
        } else {
            throw new Exception('Unable to update user data.');
        }
}

function submit_review_update($username, $target, $review) {
    // connect to db
    $conn = db_conn();
    
    //fix the untrustowrth
    $target = clean_db($target);
    $review = clean_db($review);
    
        //try to update the user's bio
        if (update_review($username, $target, $review)) {
            return true;
        } else {
            throw new Exception('Unable to update user data.');
        }
}

?>