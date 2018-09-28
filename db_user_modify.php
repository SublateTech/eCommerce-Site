<?php 
include("classes/access_user_class.php"); 

$page_protect = new Access_user;
$page_protect->login_page = "db_user_login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$page_protect->log_out(); // the method to log off
}

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

<h2><?php echo "Hello ".$hello_name." !"; ?></h2>
<p>You are currently logged in.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p><a href="db_user_update.php">Update user account</a></p>
<?php /* <p><a href="./update_user_profile.php">Update user PROFILE</a></p>
<p><a href="/classes/access_user/test_access_level.php">test access level </a></p> 
<?php if ($page_protect->access_level >= DEFAULT_ADMIN_LEVEL) { // this link is only visible for admin level user ?>
<p><a href="db_user_admin.php">Admin page (user / access level update) </a></p>
<?php } // end hide admin menu link ?> */ ?>

<p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=log_out">Click here to log out.</a></p>

<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
