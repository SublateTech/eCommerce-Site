<?php 
include("classes/access_user_class.php"); 

$renew_password = new Access_user;

if (isset($_POST['Submit'])) {
	$renew_password->forgot_password($_POST['email']);
} 
$error = $renew_password->the_msg;


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

<h2>Forgot your password/login?</h2>
<p>Please enter the e-mail address what you have used during registration.</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="email">E-mail:</label>
  <input type="text" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>">
  <input type="submit" name="Submit" value="Submit">
</form>
<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p><a href="<?php echo $renew_password->login_page; ?>">Back</a></p>

<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
