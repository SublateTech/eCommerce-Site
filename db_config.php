<?php 
// db connection
if (!session_id()) session_start();


//$_SERVER['HTTP_HOST'] = "192.168.254.56/";
//$_SERVER['HTTP_HOST'] = "www.signaturefundraising.com/";

//$_SERVER['HTTP_HOST'] .= "/"; 

define("DB_SERVER", "localhost");
define("DB_NAME", "signatv9_SigWeb");
define("DB_USER", "signatv9_sa");
define("DB_PASSWORD", "sa");


// db tables (change the names if you need)
define("PRODUCTS", "cart_products");
define("ORDERS", "cart_orders");
define("ORDER_ROWS", "cart_rows");
define("SHIP_ADDRESS", "cart_shipment");
define("CUSTOMERS", "cart_customer");
define("STUDENTS", "cart_students");
define("CREDIT_CARD", "cart_creditcard");
define("MAGAZINES_EXPORT", "cart_magazines_export");
define("MAGAZINES_EXPORT_FILE", "cart_magazines_export_file");


// cart "globals"
define("CURRENCY", "$"); 				// use "€", "$", "£" or "¥"
define("INCL_VAT", true);
define("VAT_VALUE", 8.5); 				// the standard VAT is used by methods if the vat value is not filled
define("SITE_MASTER", "Signature Fundraising Shopping Cart"); // the contact information for the order confirmation
if (isset($_SESSION['testing_mode']) && $_SESSION['testing_mode'] == 'on')
	{ define("SITE_MASTER_MAIL", "alvaro@sigfund.com"); }
 else
	{ define("SITE_MASTER_MAIL", "scott@sigfund.com;daisy@sigfund.com;april@sigfund.com");}


define("MAIL_ENCODING", "iso-8859-1"); 	// change is if you need...
define("DATE_FORMAT", "d-m-Y");
define("RECOVER_ORDER", true); 			// if this value is true an old order is available for old orders from customers, use "false" to remove the old order while the next access
define("VALID_UNTIL", 7 ); 		// the value of seconds how long an old order is valid (default 7 days) and will be recoverd
define("SHOW_CONTINUE", true); 			// set this variable on true to show a continue page after the item is added to the cart (continue shopping or checkout)

define("CART_CLASS_PATH", "/");

///Browsing Products
define("LINES", 1);
define("COLS", 9);
define("DEFAULT_CUST", 1);
define("ITEM_NUMBER", "");
define("PAGE", 1);



// some filename constants, you have to change this!
// use different names for the stock examples
$use_stock = false; // switch between true and false to use the variabels for the stock examples or not
if ($use_stock) {
	$catalog = "db_cart_stock_example.php";
	$checkput = "db_cart_checkout_stock_example.php";
	$confirm = "db_cart_stock_confirm.php";
	$continue = "db_cart_stock_continue.php";
} else {
	$catalog = "db_cart_main.php";
	$checkput = "db_cart_checkout_modify.php";
	$register = "db_cart_checkout_register.php";
	$confirm = "db_cart_confirm.php";
	$continue = "db_cart_add_item.php";
	$login = "db_cart_login.php";
	$shipping = "db_cart_checkout_shipping.php";
	$creditcard = "db_cart_checkout_credit_card.php";
	
}
define("PROD_IDX", $catalog); 
define("CHECKOUT", $checkput);
define("CONFIRM", $confirm); 
define("CONTINUE_SCRIPT", $continue);
define("LOGIN", $login);
define("REGISTER", $register);
define("SHIPPING", $shipping);
define("CREDITCARD", $creditcard);

// template names
define("ORDER_TMPL", "order_tpl.php");
define("ORDER_CREDITCARD_TMPL", "order_creditcard_tpl.php");
define("SQL", "Select * from cart_products Where ProductID != '' "); // Where Name_Eng <> ''" );

require_once("db_user_config.php");
set_time_limit ( 100);


?>