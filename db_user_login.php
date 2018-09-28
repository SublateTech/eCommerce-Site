<?php 
include("classes/access_user_class.php"); 

$my_access = new Access_user;
$my_access->login_reader();

if (isset($_GET['activate']) && isset($_GET['ident'])) { // this two variables are required for activating/updating the account/password
	//$my_access->auto_activation = false; // use this (true/false) to stop the automatic activation
	$my_access->activate_account($_GET['activate'], $_GET['ident']); // the activation method 
}
if (isset($_GET['validate']) && isset($_GET['id'])) { // this two variables are required for activating/updating the new e-mail address
	$my_access->validate_email($_GET['validate'], $_GET['id']); // the validation method 
}
if (isset($_POST['Submit'])) {
	$my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; // use a cookie to remember the login
	$my_access->count_visit = true; // if this is true then the last visitdate is saved in the database
	$my_access->login_user($_POST['login'], $_POST['password']); // call the login method
} 
$error = $my_access->the_msg; 


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

$login    = (isset($_POST['login'])) ? $_POST['login'] : $my_access->user;
$password = (isset($_POST['password'])) ? $_POST['password'] : $my_access->user_pw;
$checked = ($my_access->is_cookie == true) ? " checked" : "";
?>

<h2>Login:</h2>
<p>Please enter your login and password.</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label for="login">Login:</label>
  <input type="text" name="login" size="20" value="<?php echo $login;  ?>"><br>
  <label for="password">Password:</label>
  <input type="password" name="password" size="8" value="<?php echo $password; ?>"><br>
  <label for="remember">Remember login?</label>
  <input type="checkbox" name="remember" value="yes"<?php echo $checked; ?>>
  <br>
  <input type="submit" name="Submit" value="Login">
</form>
<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p>Not registered yet? <a href="db_user_register.php">Click here.</a></p>
<p><a href="db_user_forgot_password.php">Forgot your password?</a></p>



<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
