<?php
function valid_email($address) {
  // check an email address is possibly valid
  $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
  // Run the preg_match() function on regex against the email address
  if (preg_match($regex, $address)) {
    return true;
  } else {
    return false;
  }
}


function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || ($value == '')) {
        return false;
     }
  }
  return true;
}


 
function get_ext ($filename) {
    $filename = strtolower($filename);
    $tmp = explode(".", $filename);
    $ext = end($tmp);
    return $ext; 
/**
 * this is how to call it... 
 * $ext = get_ext($_FILES['file']['name']); 
 */
} 
 

?>