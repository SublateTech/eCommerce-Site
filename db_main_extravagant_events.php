<?php
if (!session_id()) session_start();
	if (isset($_REQUEST['close']))
		{
			
			
			?>
			<table  height="400px" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<td valign="middle">
								<tr >
									<td align="center">
											<?php 	print "Thank you for using our Tell family & friends service!!!"	?>
								 	</td>
								</tr>
								 <tr >
								 	
										
												<TD align="center">
												<br />
												<form action="#">
												<div>
												<input type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
												</div>
												</form>
												</TD>
										
										 </tr>
								</td>	
							 </table>
			
			
			
			<?php 
				exit;
					/*
			<script language="javascript">
				this.close();
					
					
			</script> */?>
					
		<?php } ?>


<html>
<head>
<title>Signature Extravagant Events</title>
<script language="javascript">
<!--

function reset() {
document.tellafriend.name.value="";
document.tellafriend.email.value="";
document.tellafriend.fmail1.value="";
document.tellafriend.fmail2.value="";
document.tellafriend.fmail3.value="";
}

function message()
{
	alert("Your is being processed, please wait...");
	return true;	
}

function validate() {

if (document.tellafriend.fmail1.value.length==0) {
alert("You'll need to enter a friend's email address");
return false;
}

if (document.tellafriend.email.value.length==0) {
alert("You forget to enter your email address");
return false;
}
if (document.tellafriend.name.value.length==0) {
alert("You forgot to enter your name");
return false;
}

document.tellafriend.submit()

//wait_mess();
document.tellafriend.button.value = "Please wait a few seconds...";
return true;
}

//-->
</script>
</head>
<body onLoad="reset()" topmargin="0" leftmargin="0"> 
<p> 
<center>
</center>
<table width="467"  border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#EEEEEE">
<!--DWLayoutTable-->
<tr valign="top">
<td width="467" height="39" valign="top">&nbsp;
  <?php 
	$refurl = $_SERVER['HTTP_REFERER']."&Brochure=".$_SESSION['brochure'];
/*
Complete the details below to send a link to the page:<br>
<? $refurl = $_SERVER['HTTP_REFERER']; ?> */
//print $refurl;?>


<br>
&nbsp; For your next School or Corporate Event call 1.800.645.3863<br></td>
</tr>
<tr valign="top">
  <td height="300" align="center" valign="middle"><embed src="images/X-Bash_web.wmv" width="400" height="250"><!--DWLayoutEmptyCell-->
  &nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php 
 /* <a href="path/to/recform.php" target="page" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=550,height=410,left=50,top=50,titlebar=yes')">Recommend this page</a>;
 */ ?>