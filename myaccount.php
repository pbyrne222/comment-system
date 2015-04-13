<?php 
include 'dbc.php';
page_protect();
?>

<html>
<head>
<title>My Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3" align="right"><a href="logout.php">Logout </a></td>
  </tr>
  <tr> 
    <td width="160" style="vertical-align:top">

<?php 

if (isset($_SESSION['user_id'])) {?>


      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" style="vertical-align:top">
      <h3 class="titlehdr">Welcome, <?php echo $_SESSION['user_name'];?>!</h3>  
	  <?php	
      if (isset($_GET['msg'])) {
	  echo "<div class=\"error\">$_GET[msg]</div>";
	  }
	  
	  $user_id = $_SESSION['user_id'];
	  
	  if(isset($_REQUEST['sayit']))
	  {
		  $maincomment = mysql_real_escape_string($_REQUEST['maincomment']);
		  
		  
		  $mainquery = "INSERT INTO maincomments (userid, comment) VALUES ('$user_id', '$maincomment')";
		  $mainrs = mysql_query($mainquery, $link) or die("Error: " . mysql_error());
		  echo "Posted";
		  
	  }
	  
	  	  
	  ?>
      <div>
          <form name="maincommentform" action="" method="post">
              <table cellpadding="4" cellspacing="0" border="0" style="background-color: #9CF; padding:3px;">
                <tr>
                    <td><input type="text" placeholder="say something" class="maincomment-input" name="maincomment" size="110" required />
                        <input type="submit" class="sayitbutton" name="sayit" value="say it" />
                    </td>
                </tr>
              </table>
          </form>
     	 <br>
         
         <?php
		 $i = 0;
		  $maincommentquery = "SELECT * FROM maincomments";
		  $maincommentrs = mysql_query($maincommentquery, $link) or die("Error: " . mysql_error());
		  while($row = mysql_fetch_array($maincommentrs))
		  {
			  $i++;
		 	$userid = $row['userid'];
			$commentid = $row['id'];
			$maincmnt = $row['comment'];
			
			$subquery = "SELECT fname, lname FROM users WHERE id='$userid'";
			$subrs = mysql_query($subquery) or die("Error: " . mysql_error());
			$subrow = mysql_fetch_array($subrs);
			
			$fname = $subrow['fname'];
			$lname = $subrow['lname'];
			$fullname = $fname . " " . $lname;
		 ?>
      
           <div style="border: 1px solid #69C; padding: 8px;">
           		<strong><u><?php echo $fullname; ?></u></strong>
                
                <?php
					if($user_id == $userid)
					{
				?>
                        <span style="float: right" title="Delete Comment">
                            <a href="deletecomment.php?cid=<?php echo $commentid; ?>"><font size="-1" color="FF0000">Delete</font></a>
                        </span><br />
                <?php
					}
				?>
                
                <p style="margin-top: 0px;"><?php echo $maincmnt; ?></p>
                
                <?php
					
					if(isset($_REQUEST[$i]))
				  	{
						$c = mysql_real_escape_string($_POST['subcomment']);
						$q = mysql_query("INSERT INTO othercomments SET comment='$c', commentid='$commentid', userid='$user_id'") or die(mysql_error());
				 	}
					
				?>
                
                <table border="0" width="95%">
                	<tr>
                    	<td>
                            <form name="<?php echo $i; ?>" method="post" action="">
                                <input type="text" size="60" name="subcomment" placeholder="comment here" />
                                <input type="submit" value="enter" name="<?php echo $i; ?>" />
                            </form>
                        </td>
                    </tr>
                    
                    <?php
					
					$subcommentquery = "SELECT * FROM othercomments WHERE commentid='$commentid'";
					$subcommentrs = mysql_query($subcommentquery) or die("Error: " . mysql_error());
					while($commentrow = mysql_fetch_array($subcommentrs))
					{
						$subcommentuserid = $commentrow['userid'];
						$subcommentid = $commentrow['id'];
						$subcommenttext = $commentrow['comment'];
						
						$subsubquery = "SELECT fname, lname FROM users WHERE id='$subcommentuserid'";
						$subsubrs = mysql_query($subsubquery) or die("Error: " . mysql_error());
						$subsubrow = mysql_fetch_array($subsubrs);
						
						$cmntfname = $subsubrow['fname'];
						$cmntlname = $subsubrow['lname'];
						$cmntfullname = $cmntfname . " " . $cmntlname;
					?>
                    <tr style="background-color: #9FC; padding: 3px;">
                    	<td width="95%"><strong><u><?php echo $cmntfullname; ?></u></strong>
                        	<?php echo $subcommenttext; ?>
                            
                            <?php
							if($user_id == $subcommentuserid)
							{
							?>
                                <span style="float: right;" title="Delete Comment">
                                    <a href="deletesubcomment.php?cid=<?php echo $subcommentid; ?>"><font color="#FF0000">x</font></a>
                                </span>
                            <?php
							}
							?>
                            
                        </td>
                    </tr>
                    
                    <?php
					}
					?>
                    
                </table>
                
           </div>
      	  <?php
		  }
		  ?>
	  </div>
	 <?php } ?>
      </td>
    <td width="196" style="vertical-align:top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
