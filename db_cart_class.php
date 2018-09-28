<?php
/************************************************************************
db_cart Class ver 1.13 -
This universal shopping cart script is powered by MySQL and works with external customer and product related data.

Copyright (c) 2005 - 2006, Olaf Lederer
Modified by: Alvaro Medina Signature Fundraising inc. 2007
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * Neither the name of the finalwebsites.com nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

_________________________________________________________________________
available at https://www.finalwebsites.com 
Comments & suggestions: http://www.webdigity.com/index.php/board,76.0.html,ref.olaf

*************************************************************************/
require_once("db_config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);
class db_cart {
	
	var $error='';
	var $customer;
	var $curr_product;
	
	var $ship_id;
	var $ship_name;
	var $ship_name2;
	var $ship_address;
	var $ship_address2;
	var $ship_zipcode;
	var $ship_city;
	var $ship_state; 
	var $ship_msg;
	var $ship_phone;
	
	
	var $language = "en";
	
	var $order_array = array();
	var $orders_array = array();
	var $open = "y";
	var $processed_on="";
	
	// Customer Information
	var $cust_firstname="";
	var $cust_lastname="";
	var $cust_address="";
	var $cust_address2="";
	var $cust_city="";
	var $cust_zipcode;
	var $cust_state="";
	var $cust_phone;
	var $cust_email="";
	var $cust_password="";
	var $cust_user="";
		
	var $cc_number;
	var $cc_CVN;
	var $cc_date_month;
	var $cc_date_year;
	var $cc_holder;
	var $cc_type = "";
	var $cc_aproval="";
	
	var $ship_price = 7.00;	
	var $discount = 0.00;
	var $subtotal = 0.00;
	

	
		
	// constructor ...
	function db_cart($customer_no = 0, $order_id='') {
		$conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME, $conn);
		$this->error = "&nbsp;";
		$this->get_customer($customer_no);
		$customer_no = $_SESSION['cust_id']; 
		if ($order_id=='')
			$this->get_order($customer_no);
		else
			$_SESSION['order_id']=$order_id;
					
		if (!isset($_SESSION['order_id']))
		   {
				$this->remove_old_orders(0,false); // use false if everyting older 1 day should be removed
			} 
				
	}
	
	
	// get all messages from here (add your own language here)
	function messages($number) {
		$msg = array();

			// general error messages
			$msg[1] = "Unknown database error, please try it again.";
			$msg[2] = "Unknown application error, please contact the system administrator.";
			// messages related to cart activity
			$msg[11] = "Added the product to your cart.";
			$msg[12] = "Updated the order row in your cart.";
			$msg[13] = "Can't add/update the product, please try it again.";
			$msg[14] = "Add some products to the cart...";
			$msg[15] = "Removed the order row from your cart.";
			$msg[16] = "The shopping cart is emtpy!";
			// checkout related messages
			$msg[21] = "Shipment address is successfully modified.";
			$msg[22] = "Your order is processed and a copy will be sent to you by e-mail. \n\r\n\rThank you for shopping with Signature Fundraising.";		
			//$msg[23] = "Your order passed through however our shopping cart could not send a confirmation e-mail to you. \n\r\n\rThank you for shopping with Signature Fundraising.";		
			// labels product data
			$msg[23] = "Your order is processed and a copy will be sent to you by e-mail (within 24 hours). \n\r\n\rThank you for shopping with Signature Fundraising.";
			$msg[31] = "Amount";
			$msg[32] = "Description";
			$msg[33] = "Item #";
			$msg[34] = "Price";
			// messages used inside the mail
			$msg[51] = " posted via ".$_SERVER['HTTP_HOST']." on ".date(DATE_FORMAT);
			$msg[52] = "incl. TAX";
			$msg[53] = "n/a";
			
			//Credit card messages
			$msg[54] = "Removed credit card information from your cart.";
			$msg[55] = "Updated credit card information from your cart.";
			$msg[56] = "Customer Information is successfully updated.";
			$msg[57] = "No orders for this customer.";
		
		return $msg[$number];
	}
	// mail message to send critical error's to the admin
	function send_admin_mail() {
	    // mail to admin (comes with the next version)
	}
	// function to handle old orders
	// a method to clean up old orders, $remove_only_zeros is an option to handle records for records with a customer number
	function remove_old_orders($customer, $remove_only_zeros = true) {
		if (RECOVER_ORDER && $customer > 0) {
			$sql = sprintf("DELETE FROM %s WHERE open = 'y' AND customer = %d AND order_date < (NOW() - %d)", ORDERS, $customer, VALID_UNTIL * 86400);
		} else {
			$sql = sprintf("DELETE FROM %s WHERE open = 'y' AND order_date < (NOW() - %d)", ORDERS, VALID_UNTIL * 86400);
		}
		$sql .= ($remove_only_zeros) ? " AND customer = 0" : "";
		mysql_query($sql);
	}
	// get an existing order for a customer, or insert a new one id none exist
	function get_order($customer) {
		$sql_check = sprintf("SELECT id FROM %s WHERE customer = %d AND open = 'y'", ORDERS, $customer);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $customer != 0) {
				$_SESSION['order_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (customer, order_date) VALUES (%d, NOW())", ORDERS, $customer);
				if (mysql_query($sql_new)) {
					$_SESSION['order_id'] = mysql_insert_id();
				} else {
					$this->error = $this->messages(1);
				}
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
		// get an existing order for a customer, or insert a new one id none exist
	function get_closed_order($customer,$order_num=0) {
		$sql_check = sprintf("SELECT id FROM %s WHERE customer = %d AND open = 'n'", ORDERS, $customer);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $customer != 0) {
				if (mysql_num_rows($res_check) >=$order_num)
					$_SESSION['order_id'] = mysql_result($res_check, $order_num, "id");
				else
					{
					$_SESSION['order_id'] = mysql_result($res_check, 0, "id");
					$this->error = "There is just one order";
					}
				
			} else {
				unset($_SESSION['order_id']); 
			}
		} else {
			$this->error = $this->messages(1);
		}
	}

			// get an existing order for a customer, or insert a new one id none exist
	function get_order_by_number($order_id) {
		$sql_check = sprintf("SELECT id,customer,open, processed_on FROM %s WHERE id = %d", ORDERS, $order_id);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0) {
				$_SESSION['order_id'] = mysql_result($res_check, 0, "id");
				$_SESSION['cust_id'] = mysql_result($res_check, 0, "customer");
				$this->open = mysql_result($res_check, 0, "open");
				$this->processed_on = mysql_result($res_check, 0, "processed_on");
				return true;
				
			} else {
				unset($_SESSION['cust_id']); 
				unset($_SESSION['order_id']); 
				return false;
			}
		} else {
			$this->error = $this->messages(1);
			return false;
		}
	}

	function get_number_of_orders($cust_id) {
		$sql_check = sprintf("SELECT Count(*) as num FROM %s WHERE customer = %d And open='n'", ORDERS, $cust_id);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0) {
				return mysql_result($res_check, 0, "num");
				
			} else {
				return 0;
			}
		} else {
			$this->error = $this->messages(1);
			return 0;
		}
	}

	
	function swicth_order_cust($new_cust)
	{
		$sql = sprintf("UPDATE %s SET customer = %s WHERE id = %d", ORDERS, $new_cust,  $_SESSION['order_id']);
		if (mysql_query($sql)) {
				$this->error = $this->messages(12);
			} else {
				$this->error = $this->messages(1);
		}
	}
		// get an existing order for a customer, or insert a new one id none exist
	function get_customer($customer) {
		$sql_check = sprintf("SELECT id FROM %s WHERE id = '%d'", CUSTOMERS, $customer);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $customer != 0) {
				$_SESSION['cust_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (user, StartDate) VALUES ('', NOW())", CUSTOMERS);
				if (mysql_query($sql_new)) {
					$_SESSION['cust_id'] = mysql_insert_id();

				} else {
					$this->error = $this->messages(1);
				}
			}
		} else {
			$this->error = $this->messages(1);
		}
	}

		
	function get_customer_by_user($user) {
		$sql_check = sprintf("SELECT id FROM %s WHERE user = %d LIMIT 1", CUSTOMERS, $user);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $user != '') {
				$_SESSION['cust_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (user, StartDate) VALUES (%s, NOW())", CUSTOMERS, $user);
				if (mysql_query($sql_new)) {
					$_SESSION['cust_id'] = mysql_insert_id();
				} else 
					$this->error = $this->messages(1);
				
			}
		} else 
			$this->error = $this->messages(1);
		
	}
	
	function find_customer_by_user($user) {
		$sql_check = sprintf("SELECT id FROM %s WHERE user = '%s' LIMIT 1", CUSTOMERS, $user);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $user != '') 
				{
					$_SESSION['cust_id'] = mysql_result($res_check, 0, "id");
					return true;
				}
				 else
					return false;
			}
			 
		else 
			$this->error = $this->messages(1);
		
	}
	
	function get_customer_by_names($fname, $lastname) {
		$sql_check = sprintf("SELECT id FROM %s WHERE FirstName = '%s'  And  LastName= '%s'", CUSTOMERS, $fname,$lastname);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $fname != '') 
				{
					$_SESSION['cust_id'] = mysql_result($res_check, 0, "id");
					return true;
				}
				 else
					return false;
			}
			 
		else 
			$this->error = $this->messages(1);
		
		}
		
	function get_customer_by_email($email) {
		$sql_check = sprintf("SELECT id FROM %s WHERE eMail = '%s' ", CUSTOMERS, $email);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $email != '') 
				{
					$_SESSION['cust_id'] = mysql_result($res_check, 0, "id");
					return mysql_num_rows($res_check);
				}
				 else
					return 0;
			}
			 
		else 
			$this->error = $this->messages(1);
		return -1;
	}


	
	// this method will chek if a order row for this product already exist
	function check_existing_row($product) {
		//print $_SESSION['order_id'];
		$sql = sprintf("SELECT id FROM %s WHERE order_id = %d AND product_id = '%s'", ORDER_ROWS, $_SESSION['order_id'], $product);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) == 1) {
				$this->curr_product = mysql_result($result, 0, "id");
				return "old";
			} else {
				return "new";
			}
		} else {
			return "error";
		}	
	}
	// insert a not existing row to the current order
	function insert_row($prod_id, $prod_name, $quantity, $price, $vat_amount = VAT_VALUE) {
		$sql = sprintf("INSERT INTO %s (order_id, product_id, product_name, price, vat_perc, quantity) VALUES (%d, '%s', '%s', %f, %f, %d)", ORDER_ROWS, $_SESSION['order_id'], $prod_id, $prod_name, $price, $vat_amount, $quantity);
		if (mysql_query($sql)) {
			$this->error = $this->messages(11);
		} else {
			$this->error = $this->messages(1);
		}	
	}
	// update/replace a single order row with the new quantity
	function update_row($row_id, $quantity, $replace = "yes") {
		if ($quantity == 0) {
			$this->delete_row($row_id);
		} else {
			$new_quant = ($replace == "no") ? "quantity + ".$quantity : $quantity;
			$sql = sprintf("UPDATE %s SET quantity = %s WHERE id = %d AND order_id = %d", ORDER_ROWS, $new_quant, $row_id, $_SESSION['order_id']);
			if (mysql_query($sql)) {
				$this->error = $this->messages(12);
			} else {
				$this->error = $this->messages(1);
			}
		}
	}
	// function to delete a single row
	function delete_row($row_id) {
		$sql = sprintf("DELETE FROM %s WHERE id = %d AND order_id = %d", ORDER_ROWS, $row_id, $_SESSION['order_id']);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}
	// handle a order row while using the methodes above
	function handle_cart_row($prod_id, $prod_name, $quantity, $price, $replace = "no", $vat_amount = VAT_VALUE) {
		$check_row = $this->check_existing_row($prod_id);
		if ($check_row == "old") {
			$this->update_row($this->curr_product, $quantity, $replace);
		} elseif ($check_row == "new") {
			$this->insert_row($prod_id, $prod_name, $quantity, $price, $vat_amount);
		} else {
			$this->error = $this->messages(13);
		}
	}
	// new method to get the old amount from a single order row (NEW in 1.12)
	function get_amount_from_row($product) {
		$sql = sprintf("SELECT quantity FROM %s WHERE order_id = %d AND product_id = '%s'", ORDER_ROWS, $_SESSION['order_id'], $product);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) == 1) {
				return mysql_result($result, 0, "quantity");
			} else {
				return 0;
			}
		} else {
			return 0;
		}	
	}
	// get the number of ordered rows which belong to this customer
	function get_number_of_records($order_id='') {
		$open = ($order_id=='' ? 'y' : 'n' ); 
		$order_id = ($order_id=='' ? $_SESSION['order_id'] : $order_id ); 
		$sql = sprintf("SELECT COUNT(*) AS num FROM %s AS r, %s AS ord WHERE ord.id = r.order_id AND ord.id = %d AND ord.open = '%s'", ORDER_ROWS, ORDERS, $order_id, $open);
		if ($result = mysql_query($sql)) {
			return mysql_result($result, 0, "num");
		} else {
			$this->error = $this->messages(1);
			return;
		}
	}
	// get all order rows from the DB and store them in to an array
	function show_ordered_rows($order_id='') {
		$open = ($order_id=='' ? 'y' : 'n' ); 
		$order_id = ($order_id=='' ? $_SESSION['order_id'] : $order_id ); 
		$sql = sprintf("SELECT r.id, r.product_id, r.product_name, r.price, r.vat_perc, r.quantity FROM %s AS r, %s AS ord WHERE ord.id = r.order_id AND ord.id = %d AND ord.open = '%s'", ORDER_ROWS, ORDERS, $order_id, $open);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->order_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
		// get all order rows from the DB and store them in to an array
	function get_customer_orders($cust_id='') {
		$cust_id = ($cust_id==''? $_SESSION['cust_id'] : $cust_id ); 
		$sql = sprintf("SELECT r.id, r.customer, r.order_date, r.processed_on, r.subtotal, r.discount, r.shipping, r.total FROM %s AS r  WHERE  r.customer = %d AND r.open = 'n'", 
		ORDERS, 
		$cust_id);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->orders_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
	}


		// show total value of the current cart
	function show_total_shipping($order_id = 0) {
		//$sql = sprintf("SELECT SUM(cart_products.price) AS total FROM %s, %s WHERE order_id = %d", ORDER_ROWS, PRODUCTS, $_SESSION['order_id']);
		//SELECT SUM(cart_products) AS Total FROM 
		//select p.Name_Eng, p.ProductID,  o.price, o.quantity FROM cart_rows o, cart_products p  where o.product_id = p.ProductID And p.shipping > 0.00 And o.order_id = 251
		//$sql = sprintf("SELECT SUM(o.price * o.quantity) as total FROM %s as o, %s as p  where o.product_id = p.ProductID And p.shipping > 0.00 And o.order_id = %d",ORDER_ROWS,PRODUCTS,$_SESSION['order_id']);
		//$sql = sprintf("SELECT SUM(o.price * o.quantity) as total FROM %s as o, %s as p  where o.product_id = p.ProductID  And o.order_id = %d",ORDER_ROWS,PRODUCTS,$_SESSION['order_id']);
		$sql = sprintf("SELECT SUM(o.price * o.quantity) as total FROM %s as o where o.order_id = %d",ORDER_ROWS,$_SESSION['order_id']);
	//echo $sql;
		
		if (!$result = mysql_query($sql)) {
			$this->error = $this->messages(1);
			return;
		} else {
			$total_amount = mysql_result($result, 0, "total");
			
	//	print $total_amount;
		
		mysql_free_result($result);
		if ($this->is_only_magazines())
			{
				$this->ship_price = 0.00;
			}
			else
			{
			if ($total_amount > 0.00 )
				if ($total_amount >= 40.00 )
					$this->ship_price = 0.00;
				else
					$this->ship_price = 7.00;
			else
				$this->ship_price = 0.00;
			}	
			//return $total_amount;
			return $this->ship_price;
		}
	}

	
	function is_only_magazines()
	{
		$sql = sprintf("SELECT count(*) AS total FROM %s WHERE order_id = %d And LEFT(product_id,1) <> 'G'"  , ORDER_ROWS, $_SESSION['order_id']);
				//$sql = sprintf("SELECT SUM(o.price * o.quantity) as total FROM %s as o, %s as p  where o.product_id = p.ProductID And p.shipping > 0.00 And o.order_id = %d",ORDER_ROWS,PRODUCTS,$_SESSION['order_id']);
		//echo $sql;
		if (!$result = mysql_query($sql)) {
			$this->error = $this->messages(1);
			return false;
		} else 
		{
			$_total = mysql_result($result, 0, "total");
			mysql_free_result($result);
			if ($_total == 0 )
				return true;
			else
				return false;
				
		}
	
	
	}
	
	// show total value of the current cart
	function show_total_value() {
		$sql = sprintf("SELECT SUM(quantity * price) AS total FROM %s WHERE order_id = %d", ORDER_ROWS, $_SESSION['order_id']);
		if (!$result = mysql_query($sql)) {
			$this->error = $this->messages(1);
			return;
		} else {
			$total_amount = mysql_result($result, 0, "total");
			mysql_free_result($result);
			
			$this->subtotal = $total_amount;
						
			return $total_amount;
		}
	}
	function show_discount_value()
		{
			if (isset($_SESSION['discount']))
				$this->discount = $_SESSION['discount'];
			return $this->discount;
		}
	function show_invoice_value()
		{
			$this->total = $this->show_total_value() -  $this->show_discount_value() + $this->show_total_shipping();
			return $this->total;
		}
		
	// calculate VAT, switch between true and false to handle netto or brutto prices
	function create_total_VAT() {
		$sql = sprintf("SELECT price, vat_perc, quantity FROM %s WHERE order_id = %d", ORDER_ROWS, $_SESSION['order_id']);
		if (!$result = mysql_query($sql)) {
			$this->error = $this->messages(1);
		} else {
			$vat = 0;
			if (mysql_num_rows($result) > 0) {
				while ($obj = mysql_fetch_object($result)) {
					$vat_dec = $obj->vat_perc / 100;
					if (INCL_VAT) {
						$vat = $vat + ($obj->price * $obj->quantity) / (1 + $vat_dec) * $vat_dec;
					} else {
						$vat = $vat + ($obj->price * $obj->quantity) * $vat_dec;
					}
				}
			}
		}
		mysql_free_result($result);
		return $vat;
	}
	// check if already an shipment record exist, if yes return the data
	function check_return_shipment() {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			if (mysql_result($result, 0, "test") == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = $this->messages(1);
			return false; 
		}
	}
	
		// check if already an shipment record exist, if yes return the data
	function check_return_customer() {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE id = %d", CUSTOMERS, $_SESSION['cust_id']);
		if ($result = mysql_query($sql)) {
			if (mysql_result($result, 0, "test") == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = $this->messages(1);
			return false; 
		}
	}

	 // read the current shipment data and set the variabels
	function set_shipment_data() {
		if (!$this->check_return_shipment()) { // create an empty record if there is no shipment data
			$this->insert_new_shipment();
		}
		$sql = sprintf("SELECT * FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$obj = mysql_fetch_object($result);
			$this->ship_name = $obj->FirstName;
			$this->ship_name2 = $obj->LastName;
			$this->ship_address = $obj->address;
			$this->ship_address2 = $obj->address2;
			$this->ship_zipcode = $obj->ZipCode;
			$this->ship_city = $obj->City;
			$this->ship_state = $obj->State;
			$this->ship_phone = $obj->phone;
			$this->ship_msg = $obj->message;
		} else {
			$this->error = $this->messages(1);
		}
	}

	function set_customer_ship() {
		if (!$this->check_return_shipment()) { // create an empty record if there is no shipment data
			$this->set_customer_data();
			$this->ship_name = $this->cust_firstname. " ". $this->cust_lastname;
	 		$this->ship_name2 = ""; 
	 		$this->ship_address = $this->cust_address;
	 		$this->ship_address2 = $this->cust_address2;
	 		$this->ship_zipcode = $this->cust_zipcode;
	 		$this->ship_city = $this->cust_city;
	 		$this->ship_state =  $this->cust_state;
			$this->ship_phone =  $this->cust_phone;
	 		$this->ship_msg = "";
			$this->insert_new_shipment();
			return true;
		} else
			return false;
	}
	

	// read the current shipment data and set the variabels
	function set_customer_creditcard_data() {
		if ($this->check_return_creditcard()) { // create an empty record if there is no shipment data

		$sql = sprintf("SELECT * FROM %s WHERE cust_id=%d And order_id=%d", CREDIT_CARD, $_SESSION['cust_id'], $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$obj = mysql_fetch_object($result);
				$this->cc_number 		= $obj->number;
				$this->cc_date_month 	= $obj->exp_month;
				$this->cc_date_year 	= $obj->exp_year;
				$this->cc_holder 		= $obj->holder;
				$this->cc_CVN 			= $obj->CVN;
				$this->cc_type 			= $obj->type;
				
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}

			// get an existing order for a customer, or insert a new one id none exist
	function get_creditcard() {
		$customer = $_SESSION['cust_id'];
		$sql_check = sprintf("SELECT id FROM %s WHERE cust_id = %d And order_id = %d", CREDIT_CARD, $customer, $_SESSION['order_id']);

		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $customer != 0) {
				$_SESSION['cc_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (cust_id,order_id) VALUES (%d,%d)", CREDIT_CARD, $customer,$_SESSION['order_id']);
				if (mysql_query($sql_new)) {
					$_SESSION['cc_id'] = mysql_insert_id();
				} else {
					$this->error = $this->messages(1);
				}
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	// insert/update the shipment address vor the current order
	function update_creditcard($number, $exp_month, $exp_year, $holder, $CVN, $type) {
		if ($this->check_return_creditcard()) {
			$sql = sprintf("UPDATE %s SET number = %s, exp_month = %s, exp_year = %s, holder = %s, CVN = %s, type = %s WHERE cust_id=%d And order_id=%d", 
				CREDIT_CARD, 
				$this->prepare_string_value($number), 
				$this->prepare_string_value($exp_month), 
				$this->prepare_string_value($exp_year), 
				$this->prepare_string_value($holder), 
				$this->prepare_string_value($CVN), 
				$this->prepare_string_value($type), 
				$_SESSION['cust_id'],
				$_SESSION['order_id']);
				if (mysql_query($sql)) {
					$this->error = $this->messages(55);
					return true;
					} else {
				//echo $sql;
				$this->error = $this->messages(1);
				return false;
			}
		}	
	}


		// check if already an shipment record exist, if yes return the data
	function check_return_creditcard() {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE cust_id = %d And order_id=%d", CREDIT_CARD, $_SESSION['cust_id'],$_SESSION['order_id']);
		
		if ($result = mysql_query($sql)) {
			if (mysql_result($result, 0, "test") == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			echo $sql;
			$this->error = $this->messages(1);
			return false; 
		}
	}

	function delete_creditcard() {
		$sql = sprintf("DELETE FROM %s WHERE cust_id = %d", CREDIT_CARD, $_SESSION['cust_id']);
		if (mysql_query($sql)) {
			$this->error = $this->messages(54);
		} else {
			$this->error = $this->messages(1);
		}	
	}
		
	// read the current shipment data and set the variabels
	function set_customer_data() {
		if ($this->check_return_customer()) { // create an empty record if there is no shipment data

		$sql = sprintf("SELECT * FROM %s WHERE id = %d", CUSTOMERS, $_SESSION['cust_id']);
		if ($result = mysql_query($sql)) {
			$cust_obj = mysql_fetch_object($result);
				$this->cust_firstname = $cust_obj->FirstName;
				$this->cust_lastname = $cust_obj->LastName;
				$this->cust_address = $cust_obj->address;
				$this->cust_address2 = $cust_obj->address2;
				$this->cust_zipcode = $cust_obj->ZipCode;
				$this->cust_city = $cust_obj->City;
				$this->cust_state = $cust_obj->State;
				$this->cust_phone = $cust_obj->Phone;
				$this->cust_email = $cust_obj->email;
				$this->cust_user = $cust_obj->user;
				//$this->cust_password = $cust_obj->password;
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}

	// function to insert a new shipment record
	function insert_new_shipment() {
		$sql = sprintf("INSERT INTO %s (order_id, FirstName, LastName, address, address2, ZipCode, City, State) VALUES (%d, %s, %s, %s, %s, %s, %s, %s)",
			SHIP_ADDRESS, 
			$_SESSION['order_id'],
			$this->prepare_string_value($this->ship_name), 
			$this->prepare_string_value($this->ship_name2), 
			$this->prepare_string_value($this->ship_address), 
			$this->prepare_string_value($this->ship_address2), 
			$this->prepare_string_value($this->ship_zipcode), 
			$this->prepare_string_value($this->ship_city), 
			$this->prepare_string_value($this->ship_state));
		if (!mysql_query($sql)) {
			$this->error = $this->messages(1);
		}
	}
	
	function delete_customer($cust_id) {
		$sql = sprintf("DELETE FROM %s WHERE id = %d", CUSTOMERS, $cust_id);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}
	
		// function to insert a new shipment record
	function insert_new_customer() {
		$sql = sprintf("INSERT INTO %s (user_id, FirstName, LastName, address, address2, ZipCode, City, State, eMail, Password, Phone) VALUES (%d, %s, %s, %s, %s, %s, %s, %s)",
			CUSTOMERS, 
			$_SESSION['cust_id'],
			$this->prepare_string_value($this->cust_user), 
			$this->prepare_string_value($this->cust_firstname), 
			$this->prepare_string_value($this->cust_lastname), 
			$this->prepare_string_value($this->cust_address), 
			$this->prepare_string_value($this->cust_address2), 
			$this->prepare_string_value($this->cust_zipcode), 
			$this->prepare_string_value($this->cust_city), 
			$this->prepare_string_value($this->cust_state),
			$this->prepare_string_value($this->cust_email),
			$this->prepare_string_value($this->cust_password),
			$this->prepare_string_value($this->cust_phone));
						
		if (!mysql_query($sql)) {
			$this->error = $this->messages(1);
		}
	}

	// insert/update the shipment address vor the current order
	function update_shipment($name, $name2 = "", $address, $address2 = "", $zipcode, $city, $state, $phone, $msg) {
		if ($this->check_return_shipment()) {
			$sql = sprintf("UPDATE %s SET FirstName = %s, LastName = %s, address = %s, address2 = %s, ZipCode = %s, City = %s, State = %s, message = %s, phone = %s WHERE order_id = %d", 
				SHIP_ADDRESS, 
				$this->prepare_string_value($name), 
				$this->prepare_string_value($name2), 
				$this->prepare_string_value($address), 
				$this->prepare_string_value($address2), 
				$this->prepare_string_value($zipcode), 
				$this->prepare_string_value($city), 
				$this->prepare_string_value($state),
				$this->prepare_string_value($msg),
				$this->prepare_string_value($phone),
				$_SESSION['order_id']);
			if (mysql_query($sql)) {
				$this->error = $this->messages(21);
			} else {
				$this->error = $this->messages(1);
			}
		}	
	}
	
	function update_customer($firstname, $lastname = "", $address, $address2 = "", $zipcode, $city, $state, $email, $password, $phone, $user) {
	$sql = sprintf("UPDATE %s SET FirstName = %s, LastName = %s, address = %s, address2 = %s, ZipCode = %s, City = %s, State = %s, email = %s, phone = %s, user	 = %s WHERE id = %d", 
				CUSTOMERS, 
				$this->prepare_string_value($firstname), 
				$this->prepare_string_value($lastname), 
				$this->prepare_string_value($address), 
				$this->prepare_string_value($address2), 
				$this->prepare_string_value($zipcode), 
				$this->prepare_string_value($city), 
				$this->prepare_string_value($state),
				$this->prepare_string_value($email),
				$this->prepare_string_value($phone),
				$this->prepare_string_value($user),
				$_SESSION['cust_id']);
				if (mysql_query($sql)) {
					$this->error = $this->messages(56);
				} else {
					$this->error = $this->messages(1);
						}
			
	}
	
	function update_customer_from_vars() {
	$sql = sprintf("UPDATE %s SET FirstName = %s, LastName = %s, address = %s, address2 = %s, ZipCode = %s, City = %s, State = %s, email = %s, phone = %s, user	 = %s WHERE id = %d", 
				CUSTOMERS, 
				$this->prepare_string_value($this->cust_firstname), 
				$this->prepare_string_value($this->cust_lastname), 
				$this->prepare_string_value($this->cust_address), 
				$this->prepare_string_value($this->cust_address2), 
				$this->prepare_string_value($this->cust_zipcode), 
				$this->prepare_string_value($this->cust_city), 
				$this->prepare_string_value($this->cust_state),
				$this->prepare_string_value($this->cust_email),
				$this->prepare_string_value($this->cust_phone),
				$this->prepare_string_value($this->cust_user),
				$_SESSION['cust_id']);
				if (mysql_query($sql)) {
					$this->error = $this->messages(56);
				} else {
					$this->error = $this->messages(1);
						}
			
	}

	function update_order_totals($subtotal, $discount, $shipping, $total) {
	$sql = sprintf("UPDATE %s SET subtotal = %001.3f, discount = %001.3f, shipping = %001.3f, total = %001.3f WHERE id = %d", 
				ORDERS, 
				$subtotal, 
				$discount, 
				$shipping, 
				$total, 
				$_SESSION['order_id']);
				if (mysql_query($sql)) {
					$this->error = $this->messages(12);
				} else {
					$this->error = $this->messages(1);
						}
			
	}

	// this method will delete all records for the current order and the visitor is redirect to the main page
	function cancel_order() {
		$err_level = 0;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE order_id = %d", SHIP_ADDRESS, $_SESSION['order_id']))) $err_level++;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE order_id = %d", ORDER_ROWS, $_SESSION['order_id']))) $err_level++;
		if (!mysql_query(sprintf("DELETE FROM %s WHERE id = %d", ORDERS, $_SESSION['order_id']))) $err_level++;
		if ($err_level > 0) {
			$this->error = $this->messages(1);
		} else {
			unset($_SESSION['order_id']);
			header("Location: ".PROD_IDX);
		}	
	}
	// use the property $show_address to show/hide the shipment in the confirmation mail
	function check_out($mailto, $show_address = true) {
		/*$this->set_shipment_data();
		$this->set_customer_data();
		$this->set_customer_creditcard_data();*/
		
		if ($this->mail_order($mailto, $show_address)) {
			$this->error = $this->messages(22);
			return true;
		} else {
			$this->error = $this->messages(23);
			return false;
		}
	}
	
	
	function parse_mail_template($tags, $template) {
		$tpl_str = file_get_contents($template);
		foreach ($tags as $tag => $val) {
			$tpl_str = str_replace("{".$tag."}", $val, $tpl_str);
		}
		return $tpl_str;
	}
	
	function mail_order($to, $show_shipment) {
		$tags = array();
		//$tags['order_head'] = sprintf("\t%-10s  %-30s  %-20s  %-10s\r\n", $this->messages(31), $this->messages(32), $this->messages(33), $this->messages(34));
		$tags['order_head'] = sprintf("\t%-10s  %-40s  %-10s  %-10s\r\n", "Item #","Product","Quantity","Price");
		$this->show_ordered_rows($_SESSION['order_id']); // rows in the order_array
		$rows = "";
		foreach ($this->order_array as $val) {
			$rows .= sprintf("\t%-10s  %-40s  %-10s  %-10s\r\n", $val['product_id'], substr(str_pad($val['product_name'],40,' '),0,40), trim($val['quantity']),  trim($this->format_value($val['price'], false)));
		}																			
		
		$tags['order_rows'] = $rows;
		$tags['total_amount'] = $this->format_value($this->show_invoice_value(), false);
		$tags['shipping'] = $this->format_value($this->show_total_shipping(), false);
		$tags['discount'] = $this->format_value($this->show_discount_value(), false);
		$tags['subtotal'] = $this->format_value($this->show_total_value(), false);
		$tags['message'] = $this->ship_msg; 
		if ($show_shipment) {
			// start building shipment
			$ship_to_str = $this->ship_name;
			if (!empty($this->ship_name2)) $ship_to_str .= "\r\n".$this->ship_name2;
			$ship_to_str .= "\r\n".$this->ship_address;
			if (!empty($this->ship_address2)) $ship_to_str .= "\r\n".$this->ship_address2;
			$ship_to_str .= sprintf("\r\n%s %s\r\n%s", $this->ship_zipcode, $this->ship_city, $this->ship_state);
			$ship_to_str .= "\r\n".$this->ship_phone;
			// shipment
		} else {
			$ship_to_str = $this->messages(53);
		}
		$tags['ship_to'] = $ship_to_str;
		$tags['kr_name'] = SITE_MASTER;
		$tags['afiliate'] = '';
		
		require("db_cart_student.php");
		$student = new cart_student();
		if ($student->check_return_student()) {
			$student->set_student_data();
			$tags['afiliate'] = "\r\nAfiliate : ";
			$tags['afiliate'] .= "\r\n".$student->student_name;
			$tags['afiliate'] .= "\r\n".$student->school_name;
			$tags['afiliate'] .= "\r\n".$student->school_city;
			}
		
		/*
		$tags['cc_number'] = $this->cc_number;
		$tags['cc_date_month'] = $this->cc_date_month;
		$tags['cc_date_year'] = $this->cc_date_year;
		$tags['cc_holder'] = $this->cc_holder;
		$tags['cc_type'] = $this->cc_type;
		$tags['cc_CVN'] = $this->cc_CVN;
		
		
		//$body = $this->parse_mail_template($tags, $_SERVER['DOCUMENT_ROOT'].CART_CLASS_PATH.$this->language."/".ORDER_CREDITCARD_TMPL);
		//echo $body;		
		//$this->send_mail_creditcard(WEBMASTER_MAIL, $body, "Order (Credit Card Information): ".date(DATE_FORMAT)); 
		*/
	
		$body = $this->parse_mail_template($tags, $_SERVER['DOCUMENT_ROOT'].CART_CLASS_PATH.$this->language."/".ORDER_TMPL);
		//echo $body;		
		if ($this->send_mail($to, $body, "Confirmation Order Number: ".$_SESSION['order_id'].$this->messages(51))) {
			return true;
		} else {
			//$this->insert_error($to."\r\n"."Confirmation Order Number: ".$_SESSION['order_id'].$this->messages(51)."\r\n".$body);
			$this->insert_error($to."\r\n"." Order Number: ".$_SESSION['order_id']."\r\n");
			return false;
		}
		
	}

	function insert_error($error) {
		$sql = sprintf("INSERT INTO %s (description) VALUES (\"%s\")", "cart_error",  $error);
		mysql_query($sql);
	}

	
	function send_mail_creditcard($to, $body, $subject) { 
		$header = "From: \"".WEBMASTER_NAME."\" <".WEBMASTER_MAIL.">\r\n";
		//$header .= "Cc: ".WEBMASTER_MAIL."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/plain; charset=\"".MAIL_ENCODING."\"\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n";
		//echo SITE_MASTER_MAIL;
		//echo $header;
		if (mail($to, $subject, $body, $header)) {
			return true;
		} else {
			return false;
		}
	}

	
	function send_mail($to, $body, $subject) { 
		$header = "From: \"".WEBMASTER_NAME."\" <".WEBMASTER_MAIL.">\r\n";
		$header .= "Cc: ".SITE_MASTER_MAIL."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/plain; charset=\"".MAIL_ENCODING."\"\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n";
		//echo SITE_MASTER_MAIL;
		//echo $header;
		if (mail($to, $subject, $body, $header)) {
			return true;
		} else {
			return false;
		}
	}
	function close_order() {
		$sql = sprintf("UPDATE %s SET processed_on = NOW(), open = 'n' WHERE id = %d", ORDERS, $_SESSION['order_id']);
		if (mysql_query($sql)) {
			$this->error = $this->messages(22);
			//$this->send_ftp_magazines($_SESSION['order_id']);
			//$this->delete_creditcard();
			//unset($_SESSION['order_id']);			
		} else {
			$this->error = $this->messages(1);
		}
	}
	
	// format a decimal number into an euro amount 
	// $encoding is used for the browser and 
	function format_value($value, $encoding = true) {
		if ($encoding) {
			$curr = (ord(CURRENCY) == "128") ? "&#8364;" : htmlentities(CURRENCY);
		} else {
			$curr= CURRENCY;
		}
		$formatted = $curr."".number_format($value, 2, ".", ",");
		return $formatted;
	}
	// simple string preperation to prepend SQL injections
	function prepare_string_value($value) {
		$new_value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
		$new_value = ($value != "") ? "'".trim($value)."'" : "''";
		return $new_value;
	}
	
	function send_ftp_magazines()
		{
			//require_once("db_cart_magazines.php");
			
			
		}
		
	function get_aproval_code() {
		//SELECT COUNT(*) AS num FROM cart_orders WHERE id = 751 AND (aproval_code <> '' And aproval_code is not null)
		$sql = sprintf("SELECT COUNT(*) AS num FROM %s WHERE id = %d And (aproval_code <> '' And aproval_code is not null)", ORDERS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			return mysql_result($result, 0, "num");
		} else {
			//$this->error = $this->messages(1);
			return 0;
		}
	}
	
	function get_aproval() {
		//SELECT COUNT(*) AS num FROM cart_orders WHERE id = 751 AND (aproval_code <> '' And aproval_code is not null)
		$sql = sprintf("SELECT  aproval_code FROM %s WHERE id = %d ", ORDERS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$this->cc_aproval = mysql_result($result, 0, "aproval_code");
			return trim(mysql_result($result, 0, "aproval_code"));
		} else {
			return "";
		}
	}
	
		
	function aproved_creditcard()
		{
		
		if ($this->get_aproval_code() > 0)
			{
				return true;
				
			}
			
		if (isset($_SESSION['testing_mode']) && $_SESSION['testing_mode'] == 'on')
			{
				$this->update_order_aproval("XXXXXX");
				return true;
			}

		
		//require ("_class_processcard.php");
		include("classes/_class_processcard.php"); 
		$bibEC_ccp = new bibEC_processCard('authorize_net');
		$file = "cred_card_trans.log";
	
		
		$bibEC_ccp->save_log($file);	// the name of a LOG FILE
		$cc_user 		= "4336QdFuwLR";
		$cc_password 	= "";
		$cc_key 		= "8r9E9v7HEDc3S22J";
		$admin_email 	= "scott@sigfund.com";
		$bibEC_ccp->set_user($cc_user, $cc_password, $cc_key, $admin_email);

		$this->set_customer_data();
		$this->set_customer_creditcard_data();
		$this->set_shipment_data();

		//Customer Billing & Shipping Information

		$fname 		= $this->cust_firstname;
		$lname 		= $this->cust_lastname;
		$address 	= $this->cust_address; 
		$city 		= $this->cust_city;
		$state 		= substr($this->cust_state,0,2);
		$zip 		= $this->cust_zipcode;
		$country 	= "United States";
		$phone		= $this->cust_phone;
		$fax		= "";
		$email		= $this->cust_email;


		$bibEC_ccp->set_customer($fname, $lname, $address, $city, $state, $zip, $country, $phone, $fax, $email);//can be passed the IP as last field, optional
		
		$fname 		= $this->ship_name;
		$lname 		= $this->ship_name2;
		$address 	= $this->cust_address; 
		$city 		= $this->ship_city;
		$state 		= substr($this->ship_state,0,2);
		$zip 		= $this->ship_zipcode;
		$country 	= "United States";
		$phone		= $this->ship_phone;
		$fax		= "";

		
		$bibEC_ccp->set_ship_to($fname, $lname, $address, $city, $state, $zip, $country, $phone, $fax);

		//Customer Credit Card Information
		
		$name_on_card 	= $this->cc_holder; 
		$type			= substr($this->cc_type,0,1);
		$number			= $this->cc_number;
		$expmm			= $this->cc_date_month;
		$expyy			= $this->cc_date_year;
		$cvv			= $this->cc_CVN; //782

		$bibEC_ccp->set_ccard($name_on_card, $type, $number, $expmm, $expyy, $cvv);
		$bibEC_ccp->set_valuta('USD', '$');

		// Setting Total Cart

		$total_cart		= $this->show_invoice_value();
		$order_number	= $_SESSION['order_id'];
		$description	= "Signature Fundraising Shopping Cart";

		$bibEC_ccp->set_order($total_cart, $order_number, $description, 'auth_capture', NULL, NULL, NULL);	//the last 5 fields are:
																							//	mode
																							//	authcode
																							//	transnum
																							//  currency code
																							//  currency simbol

		//I am going to set extra fields if the gateway needs them

		//$extra['ipaddress']	= $_SERVER['REMOTE_ADDR'];	//not necessary anymore from version 1.2.4
		$extra['app-level']		= 0;		// ONLY FOR PLUG_N_PAY
									// 0 Anything Goes. No transaction is rejected based on AVS 
									// 1 Requires a match of Zip Code or Street Address, but will allow cards where the address information is not available. (Only 'N' responses will be voided) 
									// 2 Reserved For Special Requests 
									// 3 Requires match of Zip Code or Street Address. All other transactions voided; including those where the address information is not available. 
									// 4 Requires match of Street Address or a exact match (Zip Code and Street Address). All other transactions voided; including those where the address information is not available. 
									// 5 Requires exact match of Zip Code and Street Address.  All other transactions voided; including those where the address information is not available. 
									// 6 Requires exact match of Zip Code and Street Address, but will allows cards where the address information is not available. 
		$bibEC_ccp->set_extra($extra);	//I need to pass an array


		if(!$bibEC_ccp->process()){
			//print_r($bibEC_ccp->get_error());
			//print $bibEC_ccp->error['text'];
			$this->error = $bibEC_ccp->error['text'];
			return false;
		} else {
			//save the order!!!!
			//printing the authorization code
			//echo $bibEC_ccp->get_authorization();
			
			
			$aproval_code = $bibEC_ccp->get_authorization(); 
			$this->cc_aproval = $aproval_code;
			$this->update_order_aproval($aproval_code);
			$this->error = $aproval_code;
			
			//$this->error = $bibEC_ccp->error['text'];
			return true;
			
		}
		//if I want, I can print what I retrieve from the gateway

		print_r($bibEC_ccp->get_answer());
		//echo "<br>";
		//print_r($bibEC_ccp->get_log());
		//echo "<br>";
		//if I have a file with the LOG I can retrieve all the log with this :
		//print_r($bibEC_ccp->get_log_all());
		//echo "<br>";
		return false;
	
		}
		
		function update_order_aproval($aprov_code) {
			$sql = sprintf("UPDATE %s SET aproval_code = '%s' WHERE id = %d", 
				ORDERS, 
				$aprov_code, 
				$_SESSION['order_id']);
				if (mysql_query($sql)) {
					$this->error = $this->messages(12);
				} else {
					$this->error = $this->messages(1);
						}
	}

}
?>