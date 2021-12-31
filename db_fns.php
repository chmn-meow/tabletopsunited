<?php
function db_conn() {
    $result = new mysqli('localhost', 'ttu_user', 'pigsnout', 'ttu');
    if (!$result) {
        return false;
    }
    $result->autocommit(TRUE);
    return $result;
}


function clean_db($input) {
    $result = mysqli_real_escape_string((db_conn()), $input);
    if (!$result) {
        return false;
    }
    return $result;
}


function get_res_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {
     $res_array[$count] = $row;
   }

   return $res_array;
}

function get_userid($username) {
  // query db to get userid
  $conn = db_conn();
  $result = $conn->query("select userid from users_auth where username='".$username."'");
  $row = $result->fetch_assoc();
  $userid = $row['userid'];
  if (!$result) {
     return false;
  }
  return $userid;
}

function get_username($userid) {
  // query db to get userid
  $conn = db_conn();
  $result = $conn->query("select username from users_auth where userid='".$userid."'");
  $row = $result->fetch_assoc();
  $username = $row['username'];
  if (!$result) {
     return false;
  }
  return $username;
}


function input_new_user($username, $password, $fname, $lname, $email, $city, $zip, $country, $state, $address) {
// register new person with db
// return true or error message

  // connect to db
  $conn = db_conn();

  // check if username is used
  $result = $conn->query("select * from users_auth where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }

  if ($result->num_rows>0) {
    throw new Exception('That username is taken - go back and choose another one.');
  }


  // if ok, put in db
  $result = $conn->query("insert into users_auth (userid, username, password) values (NULL, '".$username."', sha1('".$password."'))");
  $userid = get_userid($username);
  $result2 = $conn->query("insert into user_info (userid, fname, lname, email, address, city, state, zip, country) 
                                values ('".$userid."', '".$fname."', '".$lname."', '".$email."', '".$address."', '".$city."', '".$state."', '".$zip."', '".$country."')");
  $result3 = $conn->query("insert into user_prof (userid, bio, games, interested) VALUES ('".$userid."', NULL, NULL, NULL);");
  if (!$result || !$result2 || !$result3) {
    throw new Exception('Could not register you at this time - please try again later.');
  }
  return true;
}


function input_update_user($username, $fname, $lname, $email, $city, $zip, $country, $state, $address) {
// update user in the database
// return true or error message

  // connect to db
  $conn = db_conn();

  // check if user is in the database
  $result = $conn->query("select * from users_auth where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query.');
  }

  if ($result->num_rows<0) {
    throw new Exception('You do not exist, how are you here?  Am I real?');
  }


  // if ok, put in db
  $userid = get_userid($username);
  $result2 = $conn->query("update user_info set fname=('".$fname."'), lname=('".$lname."'), email=('".$email."'), address=('".$address."'), 
                            city=('".$city."'), state=('".$state."'), zip=('".$zip."'), country=('".$country."') where userid=('".$userid."')");

  if (!$result || !$result2) {
    throw new Exception('Could not update your information at this time - please try again later.');
  }
  return true;
}



function input_update_bio($username, $bio, $games, $interested) {
// update a user's bio
// return true or error message

  // connect to db
  $conn = db_conn();

  // check if user is in the database
  $result = $conn->query("select * from users_auth where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query.');
  }

  if ($result->num_rows<0) {
    throw new Exception('You do not exist, how are you here?  Am I real?');
  }


  // if ok, put in db
  $userid = get_userid($username);
  $result2 = $conn->query("update user_prof set bio=('".$bio."'), games=('".$games."'), interested=('".$interested."') where userid=('".$userid."')");

  if (!$result || !$result2) {
    throw new Exception('Could not update your bio at this time - please try again later.');
  }
  return true;
}



function input_review($username, $target, $review) {
// input a review

  // connect to db
  $conn = db_conn();


  // check if user is in the database
  $result = $conn->query("select * from users_auth where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query.');
  }

  if ($result->num_rows<0) {
    throw new Exception('You do not exist, how are you here?  Am I real?');
  }

  $userid = get_userid($username);
  
  if (($userid) == ($target)) {
    throw new Exception('You can\'t review yourself, narcissist');
  }
  
  // if ok, put in db

  $result2 = $conn->query("insert into review_user (review_id, reviewer_id, reviewee_id, review) values (NULL, '".$userid."', '".$target."', '".$review."')");

  if (!$result || !$result2) {
    throw new Exception('Could not submite review - please try again later.');
  }
  return true;
}



function update_review($username, $reviewid, $review) {
// input a review

  // connect to db
  $conn = db_conn();


  // check if user is in the database
  $result = $conn->query("select * from users_auth where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query.');
  }

  if ($result->num_rows<0) {
    throw new Exception('You do not exist, how are you here?  Am I real?');
  }

  $userid = get_userid($username);
  $target = $conn->query("select reviewee_id from review_user where review_id='".$reviewid."'");
  
  if (($userid) == ($target)) {
    throw new Exception('You can\'t change what other people have said');
  }
  
  // if ok, put in db
  if ($review == false) {
    $result2 = $conn->query("delete from review_user where review_id=('".$reviewid."')");
  } else {
  $result2 = $conn->query("update review_user set review=('".$review."') where review_id=('".$reviewid."')");
  }
  if (!$result || !$result2) {
    throw new Exception('Could not update review - please try again later.');
  }
  return true;
}
?>