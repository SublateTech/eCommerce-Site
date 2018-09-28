<?php
//require_once("db_config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);

class reps_class {
	var $error='';
	var $rep_id='';
	var $rep_name ='';
	var $view_brochures='';
	
	// constructor ...
	function reps_class($rep_id='') {
		$conn = mysql_connect("207.104.236.2", "SigData", "SigData009");
		mysql_select_db("SigData", $conn);
		$this->error = "&nbsp;";
		//$this->get_magazine_by_order($order_id, $product_id);
	}	
	
	
	var $sales_array = array();
	var $companies_array = array();
	var $customers_array = array();

	
	
			// get all order rows from the DB and store them in to an array
	function show_sales_rows($rep_id=101) {
		
		$sql = sprintf("SELECT c.RepID,r.Name, CustomerID, c.Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone, c.PrizeID, p.Description as Prize_Description, c.BrochureID, b.Description, BrochureID_2, b1.Description as Description_2, SignedDate, StartDate, EndDate, PickUpDate, DeliveryDate, NoUnits, Signed , NoItems, NoSellers,Retail, Retail/NoSellers as Avg_Retail, NoItems/NoSellers as Av_Units  FROM Customer c LEFT JOIN Prizes p ON c.CompanyId=p.CompanyID and c.PrizeID=p.PrizeID LEFT JOIN Rep r ON c.CompanyId=r.CompanyID and  c.RepID=r.RepID LEFT JOIN Brochure b ON c.CompanyId=b.CompanyID and  c.BrochureID=b.BrochureID LEFT JOIN Brochure b1 ON c.CompanyId=b1.CompanyID and  c.BrochureID_2=b1.BrochureID Where c.CompanyID ='%s' And c.RepId='%d'ORDER BY c.CompanyID,c.RepID,c.CustomerID", "F07", $rep_id);
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

	

	function get_customers($company_id,$rep_id) {
		$sql = sprintf("SELECT CustomerID, Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone  FROM Customer c  Where c.CompanyID ='%s' And c.Rep_Id='%s' ORDER BY Name",
		 $company_id, $rep_id);
		
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
	
		$sql = sprintf("SELECT distinct(c.CompanyID), co.Name FROM Customer c  LEFT JOIN Company co ON c.CompanyID=co.CompanyID Where Rep_ID='%s'", $rep_id);
//		print $sql;
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
//		$sql = sprintf("SELECT u.RepID, r.Name, count(*) AS test FROM user u LEFT JOIN Rep r ON r.RepId = u.RepID And CompanyID ='F07' WHERE  user = '%s' And  u.Password='%s' GROUP BY CompanyID, r.RepID",$user,$password);

				$sql = sprintf("SELECT r.ID as RepID, r.Name, r.ViewBrochures FROM user u LEFT JOIN Reps r ON r.ID = u.Rep_ID  WHERE  user = '%s' And  u.Password='%s'",$user,$password);
//		print $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) == 1) {
				$this->rep_name = mysql_result($result, 0, "Name");
				$this->rep_id = mysql_result($result, 0, "RepID");
				$this->view_brochures = mysql_result($result, 0, "ViewBrochures");
				
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = "";
			return false; 
		}
	}

}

?>