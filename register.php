<?php 
include 'dbc.php';

$err = array();
					 
if(isset($_POST['doRegister']))
{ 

foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


if(empty($data['fname']) || strlen($data['fname']) < 3)
{
$err[] = "ERROR - Invalid first name. Please enter atleast 3 or more characters for your first name";

}

if(empty($data['lname']) || strlen($data['lname']) < 3)
{
$err[] = "ERROR - Invalid last name. Please enter atleast 3 or more characters for your last name";

}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err[] = "ERROR - Invalid email address.";

}
// Check User Passwords
if (!checkPwd($data['pwd'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";


}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

$sha1pass = PwdHash($data['pwd']);

$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];


$rs_duplicate = mysql_query("select count(*) as total from users where email='$usr_email'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "ERROR - The email already exists. Please try again with different username and email.";
}

if(empty($err)) {

$sql_insert = "INSERT into `users`
  			(`fname`,`lname`,`email`,`password`,`date`,`user_ip`,`activation_code`)
		    VALUES
		    ('$data[fname]','$data[lname]','$usr_email','$sha1pass',now(),'$user_ip','$activ_code')
			";
			
mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where id='$user_id'");


if($user_registration)  {
$a_link = "
*****ACTIVATION LINK*****\n
http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code
"; 
} else {
$a_link = 
"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
";
}

$message = 
"Hello, \n
Here's your login info:\n

User ID: $user_name
Email: $usr_email \n 
Password: $data[pwd] \n

$a_link

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	mail($usr_email, "Login Details", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

  header("Location: thankyou.php");  
  exit();
	 
	 } 
 }					 

?>
<html>
<head>
<title>PHP Login :: Free Registration/Signup Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" style="vertical-align:top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" style="vertical-align:top"><p>
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>";
	 <?php exit();
	  }
	?></p>
      <h3 class="titlehdr">Free Registration / Signup</h3>
      <p>Please register your account. Fields marked <span class="required">*</span> 
        are required.</p>
	 <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?> 
	 
	  <br>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="22%">First Name <font color="#CC0000">*</font></span></td>
            <td width="78%"><input name="fname" type="text" id="fname" class="required"></td>
          </tr>
          <tr> 
            <td>Last Name <font color="#CC0000">*</font></span></td>
            <td><input name="lname" type="text" id="lname" class="required"></td>
          </tr>
          <tr> 
            <td>Your Email<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="usr_email3" class="required email"> 
              <span class="example">** Valid email please..</span></td>
          </tr>
          <tr> 
            <td>Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 chars minimum..</span></td>
          </tr>
          <tr>
            <td height="48">&nbsp;</td>
            <td style="vertical-align:bottom"><input name="doRegister" type="submit" id="doRegister" value="Register"></td>
          </tr>
        </table>
        <p align="center">&nbsp;</p>
      </form>
      <p align="right"><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP 
                  Login Script v2.0</a></span></p>
	   
      </td>
    <td width="196" style="vertical-align:top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
