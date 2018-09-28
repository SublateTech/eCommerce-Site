<?php
if (!session_id()) session_start();
	if (isset($_REQUEST['close']))
		{
			
			
			?>
			<table  height="400px" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<td valign="middle">
								<tr >
									<td align="center">
											<?php 	print "Thank you for using our Tell-a-friend service!!!"	?>
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
<title>Tell a friend form</title>
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
<table  width="330px"  border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#EEEEEE">
<tr valign="top">
<td valign="middle" align="center">&nbsp;
<?php 
	$refurl = $_SERVER['HTTP_REFERER']."&Brochure=".$_SESSION['brochure'];
/*
Complete the details below to send a link to the page:<br>
<? $refurl = $_SERVER['HTTP_REFERER']; ?> */
//print $refurl;?>


You can send this product by Email to three friends! 
<form name="tellafriend" action="db_cart_tellafriend.php?item=<?php echo $_SESSION['item']; ?>" method="post" onSubmit="return checkfields()">&nbsp;
<div align="center">
<center>
<table border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="215"> *Your name:</td>
<td width="184">
<input size="30" name="name" maxlength="45">
</td>
</tr>
<tr>
<td>*Your email:</td>
<td>
<input size="30" name="email" maxlength="45">
</td>
</tr>
<tr>
<td colspan="2"><p align="left">Your Friend's Email(s) :</td>
</tr>
<tr>
<td>*Email 1:</td>
<td>
<input size="30" name="fmail1" maxlength="50">
</td>
</tr>
<tr>
<td>Email 2:</td>
<td>
<input size="30" name="fmail2" maxlength="50">
</td>
</tr>
<tr>
<td>Email 3:</td>
<td>
<input size="30" name="fmail3" maxlength="50">
</td>
</tr>
<tr>
<td colspan="2">
<p align="center">
<?php /*The email that will be sent to will contain your name &amp; email address. <br> */ ?>
<br>
<input onClick="validate(); " name='button' type="button" value="click once to send">
<input type=hidden name=refurl value="<? print $refurl;?>"> 

</td>
</tr>
</table>
</center>
</div>
</form>
<br>
</td>
</tr>
</table>
</body>
</html>
<?php 
 /* <a href="path/to/recform.php" target="page" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=550,height=410,left=50,top=50,titlebar=yes')">Recommend this page</a>;
 */ ?>