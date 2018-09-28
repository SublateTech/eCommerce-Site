<?php 
include("db_config.php"); 
include("classes/access_user_class.php"); 

$new_member = new Access_user;
// $new_member->language = "de"; // use this selector to get messages in other languages

if (isset($_POST['Submit'])) { // the confirm variable is new since ver. 1.84
	// if you don't like the confirm feature use a copy of the password variable
	if ($new_member->register_user($_POST['login'], $_POST['password'], $_POST['confirm'],  $_POST['firstname'], $_POST['lastname'], $_POST['email'])==13) // the register method
		{
		show_empty($new_member->the_msg);
		exit;
		}
		
} 
$error = $new_member->the_msg; // error message


require_once("db_cart_init.php");
require_once("page.php");
require_once("db_cart_box.php");


$page_htm = new page();
$page_cnt = new Content();
$page_box = new boxstd();

$page_htm->ShowHeader(); 
$page_cnt->menu = false;
$page_cnt->Header(); 
$page_cnt->Header_Center(); 
$page_box->Header();
?>

<table  align="center"  cellpadding="0"  cellspacing="0" align="left" border="0">
			<tr align="left">
						<td  colspan="2" align="left" >
	  						<div id='center_title'>
	 						<font size="+1">  REGISTER INFORMATION </font>
	 						<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
							</div>
						</td>
			</tr>	

			<tr align="left">
				<td  >
					<table  width="100%">
					<tr>
						<td width="40%">
				<h2>Please register:</h2>
				<p>Please fill in the following fields (fields with a * are required).</p>
				<br><br>
				<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				  <label for="login">Login:</label>
				  <input type="text" name="login" size="12" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : ""; ?>">
				  * (min. 6 chars.) <br><br>
				  <label for="password">Password:</label>
				  <input type="password" name="password" size="6" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>">
				  * (min. 4 chars.) <br><br>
				  <label for="confirm">Confirm password:</label>
				  <input type="password" name="confirm" size="6" value="<?php echo (isset($_POST['confirm'])) ? $_POST['confirm'] : ""; ?>">
				  <br>
				  <br>
				  <label for="email">E-mail:</label>
				  <input  type="text" name="email" size="30" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>">
				  * 
				  <br><br>
				  <label for="firstname">First Name:</label>
				  <input  type="text" name="firstname" size="30" value="<?php echo (isset($_POST['firstname'])) ? $_POST['firstname'] : ""; ?>">
				  <br><br>
  				  <label for="lastname">Last Name:</label>
				  <input  type="text" name="lastname" size="30" value="<?php echo (isset($_POST['lastname'])) ? $_POST['lastname'] : ""; ?>">
				  <br><br>

				  
				  <br>
				  <input type="submit" name="Submit" value="Submit">
				  
				  
			</form>
			<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
			<p>&nbsp;</p>
			<!-- Notice! you have to change this links here, if the files are not in the same folder -->
			
					</td>
				</tr>
				</table>
				   
			</td>
			</tr>
</table>	
<table  width="100%" align="left">
	<tr>
		<td>
				<p><a style="padding-left:10px; " href="<?php echo $new_member->login_page; ?>"> &laquo;Back</a></p>
		</td>
	</tr>

</table>
<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
<?php 

	function show_empty($the_msg)
		{
			require_once("db_cart_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();

			
			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	false;
			$page_cnt->s_bar 	=	false;
			$page_cnt->t_menu 	=	false;
			$page_cnt->Header(); 
			$page_cnt->Header_Center(); 
			$page_box->Header();
			?>  <table height="300px" width="100%"> 
					<tr valign="middle">
						<td align="center" valign="middle">
							<?php echo "Thank you for creating you Signature Fundraising Account. <br><br>"; ?>
							<?php echo  "<font color=\"#FF0000\">".$the_msg."<br><br><br>"."</font>"; ?>
								
								<form action="#">
									<div>
										<input style="height:20px;" type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
									</div>
								</form>
							</TD>
					</TR>
				</table>
			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		
		}