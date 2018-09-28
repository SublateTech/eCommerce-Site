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
<title>Tell a friend form</title>
<script language="javascript">
<!--

function reset() {
document.tellafriend.name.value="";
document.tellafriend.SchoolName.value="";
document.tellafriend.SchoolCity.value="";
document.tellafriend.SchoolState.value="";
document.tellafriend.email.value="";
document.tellafriend.fmail1.value="";
document.tellafriend.fmail2.value="";
document.tellafriend.fmail3.value="";
document.tellafriend.email4.value="";
document.tellafriend.fmail5.value="";
document.tellafriend.fmail6.value="";
document.tellafriend.fmail7.value="";
document.tellafriend.fmail8.value="";
document.tellafriend.email9.value="";
document.tellafriend.fmail10.value="";


}

function message()
{
	alert("Your is being processed, please wait...");
	return true;	
}

function validate() {

if (document.tellafriend.name.value.length==0) {
alert("You forgot to enter Student's Name");
return false; }

if (document.tellafriend.SchoolName.value.length==0) {
alert("You forgot to enter School's Name");
return false; }

if (document.tellafriend.SchoolCity.value.length==0) {
alert("You forgot to enter School's City");
return false; }

if (document.tellafriend.SchoolState.value.length==0) {
alert("You forgot to enter School's State");
return false; }


if (document.tellafriend.email.value.length==0) {
alert("You forget to enter your email address");
return false; }

if (document.tellafriend.fmail1.value.length==0) {
alert("You'll need to enter at least one friend's email address");
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
<table width="630px"  height="550px" border="1" cellpadding="0" cellspacing="0" align="left" bgcolor="#EEEEEE">
	<tr valign="top">
		<td valign="middle" align="center">&nbsp;
			<?php 
			$refurl = $_SERVER['HTTP_REFERER'];
			/*
				Complete the details below to send a link to the page:<br>
				<? $refurl = $_SERVER['HTTP_REFERER']; ?> */
			//print $refurl;?>


			Now!, you can tell up to 10 family members and friends about your fundraiser! <br><br>Simply fill out the correct information below. 
			<form name="tellafriend" action="db_main_tellafriend.php" method="post" onSubmit="return checkfields()">&nbsp;
			<div align="center">
			<center>
			<table border="0" cellpadding="10" cellspacing="0">
				<tr>
					<td width="215"> *Student's name:</td>
					<td width="184">
					<input size="40" name="name" maxlength="45">
					</td>
				</tr>
				<tr>
					<td width="215"> *Student's School Name:</td>
					<td width="184">
						<input size="40" name="SchoolName" maxlength="45">
					</td>
				</tr>
				<tr>
					<td width="215"> *Student's School City:</td>
					<td width="184">
						<input size="40" name="SchoolCity" maxlength="45">
					</td>
				</tr>
				<tr>
					<td width="215"> *Student's School State:</td>
					<td width="184">
						<input size="2" name="SchoolState" maxlength="45">
					</td>
				</tr>

				<tr>
					<td>*Your email:</td>
					<td>
						<input size="40" name="email" maxlength="45">
					</td>
				</tr>
				<tr>
					<td colspan="2"><p align="left">Your Friend's Email(s) :</td>
				</tr>
				<tr>
					
					<td>
					<table border="0" width="100%">
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
							<td>Email 4:</td>
							<td>
								<input size="30" name="fmail4" maxlength="50">
							</td>
						</tr>
						<tr>
							<td>Email 5:</td>
							<td>
								<input size="30" name="fmail5" maxlength="50">
							</td>
						</tr>
					</table>
					</td>
										<td>
					<table border="0" width="100%">
						<tr>
							<td>Email 6:</td>
							<td>
								<input size="30" name="fmail6" maxlength="50">
							</td>
						</tr>
						<tr>
							<td>Email 7:</td>
							<td>
								<input size="30" name="fmail7" maxlength="50">
							</td>
						</tr>
						<tr>
							<td>Email 8:</td>
							<td>
								<input size="30" name="fmail8" maxlength="50">
							</td>
						</tr>
						<tr>
							<td>Email 9:</td>
							<td>
								<input size="30" name="fmail9" maxlength="50">
							</td>
						</tr>
						<tr>
							<td>Email 10:</td>
							<td>
								<input size="30" name="fmail10" maxlength="50">
							</td>
						</tr>
					</table>
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