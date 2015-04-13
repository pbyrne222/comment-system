<?php 
include 'dbc.php';



$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

if(isset($_POST['doLogin']))
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];

$user_cond = "email='$user_email'";
	
$result = mysql_query("SELECT id, fname, lname, email, password FROM users WHERE 
           $user_cond
			") or die (mysql_error()); 
$num = mysql_num_rows($result);

    if ( $num > 0 ) { 
	
	list($id,$fname,$lname,$email,$pwd) = mysql_fetch_row($result);
	 
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			

     // sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $fname;
		$_SESSION['user_email'] = $email;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set ctime='$stamp', ckey = '$ckey' where id='$id'") or die(mysql_error());
		
		//set a cookie
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   setcookie("user_email",$_SESSION['user_email'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: myaccount.php");
		 }
		}
		else
		{

		$err[] = "Invalid Login. Please try again with correct user email and password.";

		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }		
}
					 
					 

?>
<html>
<head>
<title>Members Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
<link href="styles.css" rel="stylesheet" type="text/css">

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3" align="right"><a href="register.php">Register</a></td>
  </tr>
</table>  
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
    <td width="732" style="vertical-align:top"><p>&nbsp;</p>
      <h3 class="titlehdr">Login Users 
      </h3>  
	  <p>
	  <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages 
	  **************************************************************************/
	  if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";	
	   }
	  /******************************* END ********************************/	  
	  ?></p>
      <form action="login.php" method="post" name="logForm" id="logForm" >
        <table width="65%" border="0" cellpadding="4" cellspacing="4" class="loginform">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="28%"> <b>Email</b></td>
            <td width="72%"><input name="usr_email" type="text" class="required" id="txtbox" size="25"></td>
          </tr>
          <tr> 
            <td><b>Password</b></td>
            <td><input name="pwd" type="password" class="required password" id="txtbox" size="25"></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center">
                <input name="remember" type="checkbox" id="remember" value="1">
                Remember me?</div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"> 
                <p> 
                  <input name="doLogin" type="submit" id="doLogin3" value="Login">
                </p>
                <p> 
                  </font> <a href="forgot.php"><font color="#FF0000">Forgot Password?</font></a> <font color="#FF6600"> 
                  </font></p>
              </div></td>
          </tr>
        </table>
        <div align="center"></div>
        <p align="center">&nbsp; </p>
      </form>
      <p>&nbsp;</p>
	   
      </td>
    <td width="196" style="vertical-align:top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
