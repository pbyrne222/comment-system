<?php 
include 'dbc.php';
page_protect();


if(isset($_GET['cid']))
{
	$commentid = $_GET['cid'];
	$delquery = mysql_query("DELETE FROM othercomments WHERE id='$commentid'");
	header("Location: myaccount.php");
}
else
{
	header("Location: myaccount.php");
}

?>
