<?php
require_once ("db_fns.php");



function get_reviews_user($userid) {
   // query database for a list of categories
   $conn = db_conn();
   $query = "";
   $result = $conn->query("select * from review_user where reviewer_id='".$userid."'");
   if (!$result) {
     return false;
   }
   $num_revs = @$result->num_rows;
   if ($num_revs == 0) {
      return false;
   }
   $result = get_res_array($result);
   return $result;
}

function get_reviews_of_user($userid) {
   // query database for a list of categories
   $conn = db_conn();
   $query = "";
   $result = $conn->query("select * from review_user where reviewee_id='".$userid."'");
   if (!$result) {
     return false;
   }
   $num_revs = @$result->num_rows;
   if ($num_revs == 0) {
      return false;
   }
   $result = get_res_array($result);
   return $result;
}


function display_reviews_user($rev_array) {
  if (!is_array($rev_array)) {
     echo "<p>No one has submitted a review yet.</p>";
     return;
  }
    //create a container for each review
    foreach ($rev_array as $row) {
        $url = "users.php?vwusr=".$row['reviewer_id'];
        $name = get_username($row['reviewer_id']);
        $review = $row['review'];
        
        echo "<div>";
        
        $self = get_userid($_SESSION['valid_user']);
        if (($self) == ($row['reviewer_id'])) {
            $revid = $row['review_id'];
            echo "You said:";
            echo "<a href=\"umng.php?vwrv=5&edrv=$revid\">Edit this review</a>";
        } else if (($self) == ($row['reviewee_id'])) {
            $revid = $row['review_id'];
            $reportuser = $row['reviewer_id'];
            echo "<a href=\"$url\">$name</a> said:";
            echo "<a href=\"report.php?usr=$self&repusr=$reportuser&rep=$revid\">Report</a>";
        } else {
            echo "<a href=\"$url\">$name</a> said:";
        }
        echo "<p>$review</p>";
        echo "</div>";
    }
}

function get_review($reviewid) {
    
    $conn = db_conn();
    
    $result = $conn->query("select * from review_user where review_id='".$reviewid."'");
    if (!$result) {
        return false;
    }
    $review = @$result->fetch_assoc();
    return $review;
}
?>