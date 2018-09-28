<?php
//require_once("db_config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);
require_once("db_config.php");
class chair_class {
	var $error='';
	var $rep_id='';
	var $rep_name ='';
	
	
	// constructor ...
	function chair_class($rep_id='') {
		
		$conn = mysql_connect("207.104.236.2", "SigData", "SigData009");
		mysql_select_db("SigData", $conn);
		$this->error = "&nbsp;";
		//$this->get_magazine_by_order($order_id, $product_id);
	}	
	
	var $order_array = array();
	var $sales_array = array();
	var $detail_array = array();
	var $customers_array = array();

	
	
	// get all order rows from the DB and store them in to an array
	function show_sales_rows($rep_id=101) {
		
		$sql = sprintf("SELECT c.RepID,r.Name, CustomerID, c.Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone, c.PrizeID, p.Description as Prize_Description, c.BrochureID, b.Description, BrochureID_2, b1.Description as Description_2, SignedDate, StartDate, EndDate, PickUpDate, DeliveryDate, NoUnits, Signed , NoItems, NoSellers,Retail, Retail/NoSellers as Avg_Retail, NoItems/NoSellers as Av_Units  FROM Customer c LEFT JOIN Prizes p ON c.CompanyId=p.CompanyID and c.PrizeID=p.PrizeID LEFT JOIN Rep r ON c.CompanyId=r.CompanyID and  c.RepID=r.RepID LEFT JOIN Brochure b ON c.CompanyId=b.CompanyID and  c.BrochureID=b.BrochureID LEFT JOIN Brochure b1 ON c.CompanyId=b1.CompanyID and  c.BrochureID_2=b1.BrochureID Where c.CompanyID ='%s' And c.RepId='%d'ORDER BY c.CompanyID,c.RepID,c.CustomerID", "'".$_SESSION['Company']."'", $rep_id);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->sales_array[$counter][$key] = $val;
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

	

	function get_customers($company_id) {
		$sql = sprintf("SELECT CustomerID, Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone  FROM Customer c  Where c.CompanyID ='%s' ORDER BY Name",
		 $company_id);
		
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->customers_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = "ss";
				
			}
		} else {
			$this->error = "sss";
			
		}
	}

	function get_sales_companies($rep_id=101) {
	
		$sql = sprintf("SELECT distinct(c.CompanyID), co.Name FROM Customer c  LEFT JOIN Company co ON c.CompanyID=co.CompanyID Where RepID='%s'", $rep_id);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->companies_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}
function get_charges_companies($rep_id=101) {
	
		$sql = sprintf("SELECT distinct(c.CompanyID), co.Name FROM rep_charges c  LEFT JOIN Company co ON c.CompanyID=co.CompanyID Where RepID='%s'", $rep_id);
		//print $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->companies_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}


	function check_password($user,$password) {
		
		$user = str_replace(",", " ", $user);

		$words = preg_split('/\s+/',$user,-1,PREG_SPLIT_NO_EMPTY);
		

		if (count($words)==0)
			{
				return false;
			}
			
		if (count($words)==1 && $words[0]!='')
		{
		$sql = "select CompanyID, Name, Address, City, State, ZipCode, HeadPhone,PhoneNumber,eMail, ChairPerson  from Customer Where CustomerId='".$password."' And ChairPerson like '%".$words[0]."%' And CompanyID='".$_SESSION['Company']."'";
		}elseif (count($words)>1 && $words[0]!='' && $words[1]!='')
		{
		$sql = "select CompanyID, Name, Address, City, State, ZipCode, HeadPhone,PhoneNumber,eMail, ChairPerson  from Customer Where CustomerId='".$password."' And ChairPerson like '%".$words[0]."%' And ChairPerson like '%".$words[1]."%' And CompanyID='".$_SESSION['Company']."'";
		}
		else
		{
			return false;
		}
	
		
//		print $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) == 1) {
				$_SESSION['Customer'] = $password;
				$_SESSION['Company'] = mysql_result($result, 0, "CompanyID");
				$_SESSION['PhoneNumber'] = mysql_result($result, 0, "PhoneNumber");
				$_SESSION['Name'] = mysql_result($result, 0, "Name");
				$_SESSION['HeadPhone'] = mysql_result($result, 0, "HeadPhone");
				$_SESSION['eMail'] = mysql_result($result, 0, "eMail");
				$_SESSION['ChairPerson'] = mysql_result($result, 0, "ChairPerson");
				
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = "Customer doesn't exist";
			return false; 
		}
	}
	
	function get_order_header($teacher, $student) {
		$sql = sprintf("Select * from Orders  Where Teacher = \"%s\" And Student=\"%s\" and CompanyID=\"%s\"",  $teacher, $student,$_SESSION['Company']);
		//print $sql;
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
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}
	function get_order_header_by_id($order_id) {
		$sql = sprintf("Select * from Orders  Where ID = \"%s\"",  $order_id);
		//print $sql;
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
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}
	
	function get_order_detail($teacher, $student) {
		$sql = sprintf("Select p.Description, p.Price, d.ProductID, d.Quantity, p.Price*d.Quantity as Subtotal from OrderDetail d Left join Product p On p.ProductID=d.ProductID and p.CompanyID=\"%s\" Where Teacher = \"%s\" And Student=\"%s\"", $_SESSION['Company'], $teacher, $student);
		//print $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->detail_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}
	function get_order_detail_by_id($order_id) {
		$sql = sprintf("Select p.Description, p.Price, d.ProductID, d.Quantity, p.Price*d.Quantity as Subtotal from OrderDetail d Left join Product p On p.ProductID=d.ProductID and p.CompanyID=\"%s\" Where OrderID = \"%s\" ", $_SESSION['Company'], $order_id);
		//print $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->detail_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = "";
			}
		} else {
			$this->error = "";
		}
	}

	// Displays alternate table row colors 
function row_color($i)
{ 
    $bg1 = "#EEEEEE"; // color one     
    $bg2 = "#DDDDDD"; // color two 

    if ( $i%2 )  
        return $bg1; 
     else  
        return $bg2; 
    
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
	

}

?>