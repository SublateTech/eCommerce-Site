<?php 
require("classes/access_user_class.php"); 

$update_member = new Access_user;

$page_protect->login_page = "db_user_login.php"; // change this only if your login is on another page
$update_member->access_page(); // protect this page too.
$update_member->get_user_info(); // call this method to get all other information

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$update_member->log_out(); // the method to log off
}

if (isset($_POST['Submit'])) {
	$update_member->update_user($_POST['password'], $_POST['confirm'], '', '', $_POST['email']); // the update method
} 
$error = $update_member->the_msg; // error message

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
$page_box->Header(); 
?>
<h2>Update user information:</h2>
<p>Use this form to modify the account information (fields with a * are required).</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="login">Login:</label>
  <b><?php echo $update_member->user; ?></b><br>
  <label for="password">Password:</label>
  <input name="password" type="password" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>" size="6">
  * (min. 4 chars.) <br>
  <label for="confirm">Confirm password:</label>
  <input name="confirm" type="password" value="<?php echo (isset($_POST['confirm'])) ? $_POST['confirm'] : ""; ?>" size="6">
  <br>
  <label for="email">E-mail:</label>
  <input name="email" type="text" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : $update_member->user_email; ?>" size="30">
  <br><br>
  <input type="submit" name="Submit" value="Update">
</form>
<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p><a href="<?php echo $update_member->main_page; ?>">Main</a></p>
<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=log_out">Click here to log out.</a></p>
<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
