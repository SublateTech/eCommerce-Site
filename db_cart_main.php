<?php 

if($_SERVER['HTTPS'] == "on")
	{header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);exit;}


require_once("db_cart_functions.php");
require_once("classes/SiteCookieClass.php");
require_once("db_cart_class.php");	
if (!session_id()) session_start();
/******************** Customer ID **********************************************/



if (!isset($_SESSION['cust_id'])) 
	{
		SiteCookie::extract("signature");
		if (isset($_COOKIE['cust_id']) && $_COOKIE['cust_id'] >0 )
			{
			
			$_SESSION['cust_id'] = $_COOKIE['cust_id'];
			}
		else
			{
			
			$_SESSION['cust_id'] = 0; //Find a Customer
			
			}
	}
else
	{

		if ($_SESSION['cust_id'] > 0)
			{
			// Create a local object
			$SiteCookie=new SiteCookie("signature");
		    // Clear all values
			$SiteCookie->clear();

    		// Set the cookie
			$SiteCookie->set();

			$SiteCookie->put("cust_id",$_SESSION['cust_id']);
    		// Set the cookie
			$SiteCookie->set();
			}else
			{
				
				$_SESSION['cust_id'] = 0; //Find a Customer
				
			}
		
		
}
	

/***** for scrolling purpouses *******************/
if (isset($_REQUEST['Home'])) 	{
		if (isset($_SESSION['brochure'])) 
			unset($_SESSION['brochure']);
	}
	
	


if (!isset($_SESSION['line'])) 
	{
	if 	(isset($_REQUEST['line']))
		 $_SESSION['line'] = $_REQUEST['line'];
	else $_SESSION['line'] = 6;
	}


if (!isset($_SESSION['cols'])) 
	{
	if (isset($_REQUEST['cols'])) $_SESSION['cols'] = $_REQUEST['cols'];
    	$_SESSION['cols'] = 3;
	}

if (isset($_REQUEST['page'])) 	{
		$page = $_REQUEST['page']; 
		}
elseif (isset($_SESSION['last_page_V1'])) 
		{$page = $_SESSION['last_page_V1']; }
else
		{
		$page    = 1; 
		}

if (isset($_REQUEST['category']) || isset($_REQUEST['range'])) 
	{
		
		$page = 1;
		
	}

if (isset($_REQUEST['view'])) $view = $_REQUEST['view'];
else 
	$view = 1;

/******************** end search process **************************************************************/

require_once("db_cart_init.php");
require_once("page.php");
require_once("db_cart_box.php");
require_once("db_cart_right_menu.php");


	
$page_cnt = new Content();

if ($view == 3 || $view == 2 )
	$page_cnt->rmenu = true;
$page_htm = new page();
$page_box = new boxstd();


/*************************************************  stating processing ***************************************/


$myCart = new db_cart($_SESSION['cust_id']);


if (isset($_POST['product']) ) 
{

	
	$old_amount = $myCart->get_amount_from_row($_POST['art_no']);
	
	//if ($old_amount <> $_POST['quantity']) 
	$old_amount += $_POST['quantity'];
	$myCart->handle_cart_row($_POST['art_no'], $_POST['product'], $old_amount, $_POST['price'], "yes");
	header("Location: ".CHECKOUT."?get_msg=11"); // the query string will create a message on the next page
	exit; 
}


$num_rows = $myCart->get_number_of_records();
// handle checkout link

if (isset($_GET['action']) && $_GET['action'] == "checkout") {
	if ($num_rows > 0) {
		header("Location: ".CHECKOUT); // change the file name if you need
		unset($_GET['action']);
		exit;
		
	} else {
		$myCart->error = "Your cart is currently empty!";
		//header("Location: ".PROD_IDX); // change the file name if you need
		//exit;
	}
}

?>

<?php
// /*********************************************   SHOW BROWSER *****************************************************/

require_once("db_cart_query.php");
$db_sql = new cart_query();
$sql =  $db_sql->get_query();





if ((isset($_REQUEST['img']) && $_REQUEST['img'] == "larger"))
	{
	$page_htm->set_title("View Larger Image");
	$page_htm->Show_General_Header();
	$menu1 = new cart_right_menu;
	$menu1->sql = $sql;
	$menu1->view = 4; 
	$menu1->ShowCenter($page);
	$page_htm->EndPage(); 
	?>
	<?PHP
	die();
	}
	
if ((isset($_REQUEST['img']) && $_REQUEST['img'] == "featured1"))
	{
	
	
	$page_htm->set_title("Feature Product");
	$page_htm->Show_General_Header();
	$menu1 = new cart_right_menu;
	$menu1->sql = $sql;
	$menu1->view = 5; 
	$menu1->ShowCenter($page);
	$page_htm->EndPage(); 
	?>
	<?PHP
	die();
	}


	/**********************************************************************************************************************/
?>



<?php $page_htm->ShowHeader(); ?>
<?php $page_cnt->Header(); ?>
<?php $page_cnt->Header_Center(); ?>
<?php $page_box->Header(); ?>
<?PHP 
if  ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.254.56')
	{
		$_SESSION['testing_mode'] = 'on';
		print "Working on development mode...";
	}

if (!isset($_SESSION['brochure']) && (isset($_REQUEST['view']) || isset($_REQUEST['item'])) || (isset($_POST['Search']) || isset($_POST['SearchString'])))
	$_SESSION['brochure'] = 4;



if (isset($_SESSION['brochure']))
{
//echo $sql;

?>


<?php  //echo "Customer ID: ".$_SESSION['cust_id'];?> 
	
		

<?php 	
		$_SESSION['myCart'] = $myCart; ?>
				
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a href='db_cart_checkout_modify.php'><img  style="margin:0; padding:0"src="images/cart.gif" /> <?php  echo "  (".$num_rows. ") items."; ?>   </a> 
				</div>
				<?php if ($view == 2 || $view == 3)
						{ ?>
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a  href="db_cart_tell_a_friend.php?item=<?php echo $_SESSION['item'];?>" target="page" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=330,height=430,left=50,top=50,titlebar=yes')"><img  style="margin:0; padding:0" src="images/faces_smile_1.GIF" /><font size="3">Tell a friend</font></a>
				</div>
				<?php } ?>
					
				<div id='main_title'>
	 			<?php 
				switch ($_SESSION['brochure'])
					{ 
					case '4':
						$_brochure = 'Spring 2009';
						break;
					case '11':
						$_brochure = 'Expressions Collection';	
						break;
					case '12':
						$_brochure = 'WEB Specials';	
						break;
					case '13':
						$_brochure = 'Magazines';	
						break;
					default:
						$_brochure = '';
						
					}
					//$_brochure .= ' Catalog';
				echo "<font size=\"+1\">".$_brochure."</font>";
				
				if (isset($_SESSION['category'])) {
					switch ($_SESSION['category'])
						{ 
						case '1':
							$_category = 'Home Decor';	
							break;
						case '2':
							$_category = 'Kitchen & Gadgets';	
							break;
						case '3':
							$_category = 'Bath & Body';	
							break;
						case '4':
							$_category = 'Specialty Items';	
							break;
						case '5':
							$_category = 'Candles & Fragancies';	
							break;
						case '6':
							$_category = 'Address Books & Organizers';	
							break;
						case '7':
							$_category = 'Gourmet Foods & Chocolates';	
							break;
						case '8':
							$_category = 'Gift Wrap and Accessories';
							break;
						case '9':
							$_category = 'Signature Chocolates';	
							break;

						default:
							$_category = 'All';		
					}
					$_category = "  (". $_category.")";
					echo "<font size=\"-2\">".$_category."</font>";
				}
					
				?>	
				
				</div>
				
				<?php /*<font id="db_cart_title_right">	There are currently <b><?php  echo $num_rows; ?> unique</b> products in your cart. </font> */ ?>
<?PHP if (strlen(trim($myCart->error)) > 6 )
		{ 
		
			//echo strlen(trim($myCart->error));
		?>
			 				<div id="error">
			 				<?php echo $myCart->error; ?>
			 				</div>
		<?php } ?>

<?php




// Center Column Display

$menu = new cart_right_menu;
$menu->sql = $sql;
$menu->view = $view; 
$menu->ShowCenter($page);



// Open and Close Right Column 

}
else
	{
		$browser = GetBrowser();
					if ( $browser [0] == 3 )
						$margin = 0;
					else
						$margin =10;
		

		?>
		<table  style=" background-image: url(images/front_ad_1.gif) ; margin-top:30px; margin-left:<?php print $margin;?>px; margin-right:0px; padding:0; " height="369px"  cellpadding="0"  cellspacing="0" >
			<tr>
				<td>
					<a href="db_cart_main.php?Brochure=4&category=5"> <img style=" margin-left:20px; margin-top:145px" src="images/front_ad_2.gif"> </a>
					<a href="db_cart_main.php?Brochure=4&category=4"><img src="images/front_ad_3.gif"></a>
					<a href="db_cart_main.php?Brochure=4&category=7"><img src="images/front_ad_4.gif"></a>
				</td>
			</tr>
			
			<tr>
				<td>
            <p align="left"><a href="db_main_tell_a_friend.php" target="page" class="style1"  style="text-decoration:none" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=630,height=600,left=50,top=50,titlebar=yes')"><font size="4"> &nbsp;&nbsp;&nbsp;Tell family & friends
                  about your fundraiser!</font></a></p>

				</td>
				
			</tr>
		</table>
		
		<?php
	}

/******************************	END MAIN PART ****************************************************************************************/
$page_box->Footer(); 


 if ($view==3 || $view==2)
	  {
	  //$menu->showMagazine_note();
	  $page_cnt->open_right_menu(); //Building Right Menu
	 // require("db_cart_right_menu.php");
	  $rmenu = new cart_right_menu;
	  //$rmenu->setitem($_SESSION['item']);	  
	  if ($view == 3) {
	  	  $rmenu->setitem($_SESSION['last_item']);	  	
	  	  $rmenu->Show($page); 
		  }
	   else 
	 	 {
	 	  $rmenu->setitem($_SESSION['item']);	  	
	 	  if (isset($_SESSION['last_page_V3']))
		  		  $rmenu->Show($_SESSION['last_page_V3']);	
		   else  $rmenu->Show(1);		
	  	}
	  $page_cnt->close_right_menu();
     } 
 else  
 	 {
	   $page_cnt->Footer_Center(); 
	 }


if ($view ==1) {
   		$_SESSION['last_page_V1'] = $page; 
   		$_SESSION['last_sql_V1'] = $sql; 
   		}
elseif($view == 2) {
	  $_SESSION['last_page_V2'] = $page; 
	  $_SESSION['last_sql_V2'] = $sql; 
	  $_SESSION['last_item'] = $_SESSION['item'];
	  }
else  {
	  $_SESSION['last_page_V3'] = $page; 	
	  $_SESSION['last_sql_V3'] = $sql; 
	  }	


$page_cnt->Footer(); 
$page_htm->EndPage(); 


//if (!isset($_REQUEST['img'])) 	{
/*
if (!isset($_SESSION['brochure']))
{
		echo '<script type="text/javascript">';
			echo "NewWindow('db_cart_main.php?img=featured&view=2&item=8851','',480,630,'')";
		echo '</script>';
}
*/
//}	
	  
	
?>
