<?php 
include("classes/access_user_class.php"); 

$act_password = new Access_user;

if (isset($_GET['activate']) && isset($_GET['id'])) { // this two variables are required for activating/updating the account/password
	if ($act_password->check_activation_password($_GET['activate'], $_GET['id'])) { // the activation/validation method 
		$_SESSION['activation'] = $_GET['activate']; // put the activation string into a session or into a hdden field
		$_SESSION['id'] = $_GET['id']; // this id is the key where the record have to be updated with new pw
	} 
}
if (isset($_POST['Submit'])) {
	if ($act_password->activate_new_password($_POST['password'], $_POST['confirm'], $_SESSION['activation'], $_SESSION['id'])) { // this will change the password
		unset($_SESSION['activation']);
		unset($_SESSION['id']); // inserts new password only ones!
	}
	$act_password->user = $_POST['user']; // to hold the user name in this screen (new in version > 1.77)
} 
$error = $act_password->the_msg;

require("db_cart_init.php");
require("page.php");
require("db_cart_box.php");


$page_htm = new page();
$page_cnt = new Content();
$page_box = new boxstd();

$page_htm->ShowHeader(); 
$page_cnt->menu = false;
$page_cnt->Header(); 
$page_cnt->Header_Center(); 
$page_box->Header(); ?>

<?php if (isset($_SESSION['activation'])) { ?>
<h2>Enter your new password:</h2>
<p>Enter here your new password, (login: <b><?php echo $act_password->user; ?></b>).</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="password"><b>(new)</b> Password:</label>
  <input type="password" name="password" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>">
  <label for="confirm">Confirm password:</label>
  <input type="password" name="confirm" value="<?php echo (isset($_POST['confirm'])) ? $_POST['confirm'] : ""; ?>">
  <input type="hidden" name="user" value="<?php echo $act_password->user; ?>">
  <input type="submit" name="Submit">
</form>
<?php } else { ?>
<h2>Att. !</h2>
<?php } ?>
<p style="color:#FF0000;"><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p><a href="<?php echo $act_password->login_page; ?>">Login</a></p>

<?php 	$page_box->Footer(); 
 		$page_cnt->Footer_Center(); 
 		$page_cnt->Footer(); 
		$page_htm->EndPage(); ?>
