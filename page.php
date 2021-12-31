<?php
require_once ("review_fns.php");


class Page 
{
    //class Page's attributes
    public $html_header = "<html>
                           <head>
                           <meta charset=\"utf-8\" />\n";
    public $keywords = "home, tabletopsunited, tabletops united, magic the gathering, mtg, for sale, cards, dm, gm, players, gmfinder, dmfinder, gmportal, dmportal, portal, 
                       tabletops, games, nerd, dnd, d and d, dungeons and dragons, lightsabers, light sabers, lasersword, laser sword,  campaign, campaigns, to play";
    public $buttons = array(
        "Home" => "index.php",
        "Market" => "market.php",
        "GMportal" => "gmportal.php",
        "About Us" => "about.php",
        "Users" => "users.php",
        "Testbed" => "testcode.php");


    //class Page's operations
    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function DoHeader($title = "Tabletops United", $hvar = "0")
    {
        echo $this->html_header;
        $this->DisplayKeywords();
        $this->DisplayTitle($title);
        $this->DisplayStyles();
        echo "</head>\n<body class=\"page\">\n";
        $this->DisplayWebHeader($hvar);
        $this->DisplayMenu($this->buttons);
    }
    
    
    public function DoBody($content, $cvar = '1', $link = '')
    {
    if ($cvar == '1'){
        echo "<div id=\"maincontainer\">\n".$content;
        } else {
            echo "<div id=\"sidemenu\">\n<dl>";
            while (list($name, $url) = each($link)) {
                echo "<dt>\n<a href=\"".$url."\" class=\"body\">\n".$name."\n</a>\n</dt>\n";
            }
            echo "</dl></div>";            
            echo "<div id=\"container\">".$content;
        }            

    }
    
    
    public function DoFooter()
    {
            echo "\n</div>\n";

    ?>
    <table width="100%" class="footer" cellpadding="12" border="0">
      <tr>
        <td>
          <p class="foot">&copy; Tabletops United LLC.</p>
          <p class="foot">Please see our <u>legal information page</u></p>
          <p class="foot">336633<br />333333<br />003300<br />669966</p>
        </td>
      </tr>
    </table>
  </body>
</html>
<?php

    }


    public function DisplayTitle($title)
    {
        echo "<title>" . $title . "</title>\n";

    }


    public function DisplayKeywords()
    {
        echo "<meta name=\"keywords\" content=\"" . $this->keywords . "\" />\n";
    }


    public function DisplayStyles()
    {

?>
    <style type="text/css">
      body {
        background-color:#dedede;
        color:black; 
        font-size:12pt; 
        font-family:arial,sans-serif
      }
      #container {
        float: right;
        background-color:#ccc;
        width: 89%;
      }
      #sidemenu {
        float: left;
        background-color: #bbb;
        width: 10%;
      }
      #maincontainer { 
        background-color: #ccc;
        margin-left: auto;
        margin-right: auto;
        width: 92%;
      }
      h1 {
        color:white; 
        font-size:24pt; 
        text-align:center; 
        font-family:arial,sans-serif
      }
      .header {
        background-color:black;
        color:white; 
        font-size:10pt; 
        font-family:arial,sans-serif
      }
      .menu {
        background-color:black;
        font-size:12pt; 
        text-align:center; 
        font-family:arial,sans-serif; 
        font-weight:bold
      }
      .activemenu {
        background-color:#797979;
        font-size:12pt; 
        text-align:center; 
        font-family:arial,sans-serif; 
        font-weight:bold
      }
      .footer {
        background-color:black;
        color:white;
        font-size:9pt;
        text-align: center;
        font-family:arial,sans-serif;
        font-weight: bold;
      }
      form {
        background-color:#555555;
        color:white;
        width:50%;
        padding:5px;
        text-align:left;
        font-family:arial,sans-serif;
      }
      table.form{
        width:350px;
      }
      form.header{
        background-color:black;
        color:white;
        font-size:9pt;
        font-family:arial,sans-serif;
      }
      input {
        background-color:#333333;
        color:white;
      }
      p {
        color:black; 
        font-size:12pt; 
        text-align:justify; 
        font-family:arial,sans-serif; 
        font-weight:bold
      }
      p.foot {
        color:white; 
        font-size:9pt; 
        text-align:center; 
        font-family:arial,sans-serif; 
        font-weight:bold
      }
      a {
        text-decoration: none;
      }
      a.menu {
        color: #fff;
      }
      a.menu:hover {
        color: #ccc;
      }
      a.header:hover {
        color:#ccc;
      }
      a.body {
        color:black;
      }
      a.body:hover {
        color:#555;
      }
      
      /*profile test vals...I'm slowly getting better at css...*/
      #profile {
        margin:0% 2%; 
        padding-top:3%;
      }
      #profile h1 {
        float:left;
      }
      #profile .content {
        overflow:auto;
      }
      #profile .content img {
        float:left; 
        margin-right:2%; 
        border:4px solid #555;
        max-height:400px;
        max-width:350px;
        min-height:100px;
        min-width:350px;
      }
      #profile .content h2, h3{
        margin-bottom:2%;
      }
      #profile .content h3{
        margin-top:5%;
      }
      #profile .content h4{
        font-size:75%;
      }
      
      
    </style>
<?php

    }


    public function DisplayWebHeader($hvar='')
    {
    ?>
    <span class="header">
    <table width="100%" cellpadding="12" cellspacing="0" border="0">
      <tr class="header">
        <td align="left">
          <a href="index.php">
            <img src="img/logo.gif" alt="TTU logo." />
          </a>
        </td>
        <td>
          <h1>Tabletops United</h1>
        </td>
        <td align="right">
          <a href="index.php">
            <img src="img/logo.gif" alt="TTU logo." />
          </a>
        </td>
      </tr>
    </table>
    <?php
        if (check_valid_user()) {
    ?>
    <table width="100%" cellpadding="5" cellspacing="0" border="0">
      <tr class="header">
        <td align="right">
          Welcome, <?php echo $_SESSION['valid_user']; ?>. 
            <a href="logout.php" class="header">Log out?</a>
        </td>
      </tr>
    </table>
    </span>
    <?php
        } else if ($hvar == '1'){
    ?>
    <table width="100%" cellpadding="4" cellspacing="0" border="0">
      <tr class="header">
        <td>&copy;TTU</td>
      </tr>
    </table>
    </span>
    <?php
            } else {
    ?>
    
    <table width="100%" cellpadding="2" cellspacing="0" border="0">
    <form method="post" action="users.php" class="header">
      <tr class="header">
        <td width="63%"></td>
        <td align="right">
          Username: 
            <input type="text" name="username"/>
        </td>
        <td align="right">
          Password: 
            <input type="password" name="password"/>
        </td>
        <td align="right">
          <input type="submit" value="Log in"/>
        </td>
      </tr>
    </form>
    </table>
    </span>
    <?php
            }
    }


    public function DisplayMenu($buttons)
    {
        echo "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\">\n";
        echo "<tr>\n";

        //calculate button size
        $width = 100 / count($buttons);

        while (list($name, $url) = each($buttons))
        {
            $this->DisplayButton($width, $name, $url, !$this->IsURLCurrentPage($url));
        }
        echo "</tr>\n";
        echo "</table>\n";
    }
    
    
    

    public function IsURLCurrentPage($url)
    {
        if (strpos($_SERVER['PHP_SELF'], $url) == false)
        {
            return false;
        } else
        {
            return true;
        }
    }


    public function DisplayButton($width, $name, $url, $active = true)
    {
        $button1 = "<td width=\"" . $width . "%\" class=\"menu\">
            <a href=\"" . $url . "\">
            <img src=\"img/s-logo.gif\" border=\"0\" alt=\"" . $name . "\"/></a>
            <a href=\"" . $url . "\"class=\"menu\"><span class=\"menu\">" . $name .
            "</span></a>
            </td>";

        $button2 = "<td width=\"" . $width . "%\" class=\"activemenu\">
            <img src=\"img/sr-logo.gif\" border=\"0\" alt=\"" . $name . "\" />
            <a href=\"". $url ."\" class=\"menu\"><span class=\"activemenu\">" . $name . 
            "</span></a>
            </td>";
        if ($active)
        {
            echo $button1;
        } else
        {
            echo $button2;
        }
    }
    
    

    
    
    public function BuildProfile($userid, $username, $userprofile, $userinfo) {
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
        if(file_exists(SITE_ROOT.'\\img\\users\\'.$userid.'.jpg')) {
            $pic = '/tabletopsunited/img/users/'.$userid.'.jpg';
        } else {
        $pic = '/tabletopsunited/img/users/stock.png';
        }
    ?>
<div id="profile">
    <div class="content">
        <img src="<?php echo $pic; ?>" />
        <h2>
            <?php echo $username; ?>
        </h2>
        <h4>
            Rating: 
        </h4>
        <h4>
            Location: <?php echo $userinfo['city'].", ".$userinfo['state']; ?>
        </h4>
        <h2>
            My name is <?php echo $userinfo['fname']." ".$userinfo['lname']; ?>
        </h2>
        <p><?php echo $userprofile['bio']; ?>
        </p>
        <h3>
            These are the games I like to play
        </h3>
        <p><?php echo $userprofile['games']; ?>
        </p>
        <h3>
            These are the games I would be interested in playing
        </h3>
        <p><?php echo $userprofile['interested']; ?>
        </p>
    </div>
    <div class="content">
        <h2>
            Reviews of this user:
        </h2>
        <?php
        $viewing = get_userid($_SESSION['valid_user']);
            if (($viewing) != ($userid)) {
                echo "<p><a href=\"umng.php?vwrv=3&edrv=$userid\">Want to submit a review?</a></p>";
            }
        
        $rev_array = get_reviews_of_user($userid);
        display_reviews_user($rev_array);            
        ?>
    </div>
</div>
    <?php
    }
    
    
    public function DisplayLoginForm() 
    {
  // dispaly form asking for name and password
?>
<form method="post" action="users.php">
 <table>
   <tr>
     <td>Username:
     </td>
     <td>
       <input type="text" name="username" size="16" maxlength="16" />
     </td>
   </tr>
   <tr>
     <td>Password:
     </td>
     <td>
       <input type="password" name="password" size="16" maxlength="16" />
     </td>
   </tr>
   <tr>
     <td colspan="2" align="center">
       <input type="submit" value="Log in"/>
     </td>
   </tr>
   <tr>
     <td>Not a user?  Feel free to 
       <a href="register.php">register</a>
     </td>   
   </tr>
 </table>
</form>
<?php
    }
    
    
    function DisplayPasswordForm() 
    {
    // displays html change password form
    ?>
   <form action="umng.php?chpw=2" method="post">
   <table class="form">
   <tr>
     <td>Old password:
     </td>
     <td>
       <input type="password" name="old_password" size="16" maxlength="16" />
     </td>
   </tr>
   <tr>
     <td>New password:
     </td>
     <td>
       <input type="password" name="new_password" size="16" maxlength="16" />
     </td>
   </tr>
   <tr>
     <td>Repeat new password:
     </td>
     <td>
       <input type="password" name="new_password2" size="16" maxlength="16" />
     </td>
   </tr>
   <tr>
     <td colspan=2 align="center">
       <input type="submit" value="Change password">
     </td>
   </tr>
   </table>
   </form>
    <?php
    }
    
    
    public function DisplayRegisterForm() 
    {
?>
<h2>At this time, all fields are required.  Sorry for the inconvenience.</h2>
<form method="post" action="register.php">
  <table bgcolor="#9B9A9A">
    <tr>
      <td>Username:</td>
      <td>
        <input type="text" name="username" size="16" maxlength="16" />
      </td>
    </tr>
    <tr>
      <td>Password:
      </td>
      <td>
        <input type="password" name="password" size="16" maxlength="16" />
      </td>
    </tr>
    <tr>
      <td>Confirm password:
      </td>
      <td>
        <input type="password" name="password2" size="16" maxlength="16" />
      </td>
    </tr>
    <tr>
      <td>First name:
      </td>
      <td>
        <input type="text" name="fname" size="16" maxlength="30" />
      </td>
    </tr>
    <tr>
      <td>Last name:
      </td>
      <td>
        <input type="text" name="lname" size="16" maxlength="30" />
      </td>
    </tr>
    <tr>
      <td>Email:
      </td>
      <td>
        <input type="text" name="email" size="16" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td>Address:
      </td>
      <td>
        <input type="text" name="address" size="16" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>City:
      </td>
      <td>
        <input type="text" name="city" size="16" maxlength="30" />
      </td>
    </tr>
    <tr>
      <td>State:
      </td>
      <td>
        <input type="text" name="state" size="2" maxlength="2" />
      </td>
    </tr>
    <tr>
      <td>Zip:
      </td>
      <td>
        <input type="text" name="zip" size="5" maxlength="5" />
      </td>
    </tr>
    <tr>
      <td>Country:
      </td>
      <td>
        <input type="text" name="country" size="10" maxlength="20" />
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Register"/>
      </td>
    </tr>
  </table>
</form>
<?php
    }
    
    
    public function DisplayUserUpdateForm($user) 
    {
    // this form will show the form with all fields filled in with previous user input
    // <td><input type="text" name="title"  /></td>


    ?>
    <form method="post" action="umng.php?edusr=2">
  <table>
    <tr>
      <td>First name:
      </td>
      <td>
        <input type="text" name="fname" size="12" maxlength="30" value="<?php echo $user['fname']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Last name:
      </td>
      <td>
        <input type="text" name="lname" size="16" maxlength="30" value="<?php echo $user['lname']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Email:
      </td>
      <td>
        <input type="text" name="email" size="30" maxlength="100" value="<?php echo $user['email']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Address:
      </td>
      <td>
        <input type="text" name="address" size="30" maxlength="80" value="<?php echo $user['address']; ?>" />
      </td>
    </tr>
    <tr>
      <td>City:
      </td>
      <td>
        <input type="text" name="city" size="16" maxlength="30" value="<?php echo $user['city']; ?>" />
      </td>
    </tr>
    <tr>
      <td>State:
      </td>
      <td>
        <input type="text" name="state" size="2" maxlength="2" value="<?php echo $user['state']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Zip:
      </td>
      <td>
        <input type="text" name="zip" size="5" maxlength="5" value="<?php echo $user['zip']; ?>" />
      </td>
    </tr>
    <tr>
      <td>Country:
      </td>
      <td>
        <input type="text" name="country" size="15" maxlength="20" value="<?php echo $user['country']; ?>" />
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Update"/>
      </td>
    </tr>
  </table>
</form>
    <?php
    }
    
    
    
        public function DisplayUserBioForm($user) 
    {
    // this form will show the bio form with previous or null properties
    // <td><input type="text" name="title"  /></td>


    ?>
    <form method="post" action="umng.php?edbio=2">
  <table>
    <tr>
      <td>Bio: 
      </td>
      <td>
        <textarea rows="3" cols="50" name="bio"><?php echo $user['bio']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td>Games you play: 
      </td>
      <td>
        <textarea rows="3" cols="50" name="games"><?php echo $user['games']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td>Interested in playing: 
      </td>
      <td>
        <textarea rows="3" cols="50" name="interested"><?php echo $user['interested']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Update"/>
      </td>
    </tr>
  </table>
</form>
    <?php
    }
    
    
    
    public function DisplayReviewForm($tgt) 
    {
    // this form will show the bio form with previous or null properties
    // <td><input type="text" name="title"  /></td>

    ?>
    <form method="post" action="umng.php?vwrv=4&edrv=<?php echo $tgt; ?>">
  <table>
    <tr>
      <td>Your Review: 
      </td>
      <td>
        <textarea rows="3" cols="50" name="review"></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit"/>
      </td>
    </tr>
  </table>
</form>
    <?php
    }                
    
    
    
    public function DisplayReviewUpdateForm($review) 
    {
    // this form will show the bio form with previous or null properties
    // <td><input type="text" name="title"  /></td>

    ?>
    <form method="post" action="umng.php?vwrv=6&edrv=<?php echo $review['review_id']; ?>">
  <table>
    <tr>
      <td>Your Review: 
      </td>
      <td>
        <textarea rows="3" cols="50" name="review"><?php echo $review['review']; ?></textarea>
      </td>
      <td>
        <input type="checkbox" name="delete" value="delete">Delete?
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" value="Submit"/>
      </td>
    </tr>
  </table>
</form>
    <?php
    }   
    
    
    
    public function DisplayFileUpload() {
        ?>
        <form action="umng.php?upht=2" method="post" enctype="multipart/form-data" />
            <div>
                <input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
                <label for="userfile">Upload a profile picture:</label>
                <input type="file" name="userfile" id="userfile" />
                <input type="submit" value="upload" />
            </div>
        </form>
    <?php
    }
}




class AboutPage extends Page
{
    private $r2buttons = array(
        "FAQs &amp; Policies" => "faqs.php",
        "Contact Us" => "contact.php",
        "Partners" => "partners.php",
        "Our Mission" => "mission.php");
        
        public function DoHeader($title = "Tabletops United", $hvar = "0")
    {
        echo $this->html_header;
        $this->DisplayKeywords();
        $this->DisplayTitle($title);
        $this->DisplayStyles();
        echo "</head>\n<body>\n";
        $this->DisplayWebHeader($hvar);
        $this->DisplayMenu($this->buttons);
        $this->DisplayMenu($this->r2buttons);
    }
}


class UserPage extends Page
{
    private $r2buttons = array(
        "Your Orders" => "uorders.php",
        "Your Market" => "umkt.php",
        "Account Management" => "umng.php");
    
        public function DoHeader($title = "Tabletops United", $hvar = "0")
    {
        echo $this->html_header;
        $this->DisplayKeywords();
        $this->DisplayTitle($title);
        $this->DisplayStyles();
        echo "</head>\n<body>\n";
        $this->DisplayWebHeader($hvar);
        $this->DisplayMenu($this->buttons);
        $this->DisplayMenu($this->r2buttons);
    }
}



class MktPage extends Page
{
    private $r2buttons = array(
        "Meriksabers" => "mrksbr.php",
        "Our Showcase" => "ours.php",
        "User Showcase" => "ushow.php");
    
        public function DoHeader($title = "Tabletops United", $hvar = "0")
    {
        echo $this->html_header;
        $this->DisplayKeywords();
        $this->DisplayTitle($title);
        $this->DisplayStyles();
        echo "</head>\n<body>\n";
        $this->DisplayWebHeader($hvar);
        $this->DisplayMenu($this->buttons);
        $this->DisplayMenu($this->r2buttons);
    }
}

?>