<?php 
	//if($_SERVER['HTTPS'] != "on")
	//{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);exit;}
	if (!session_id()) session_start();
	$rep_sales = new chair_tickets_class();
	$rep_sales->Start();
	
	
	class chair_tickets_class { 
	
	var $rep_id='';
	var $rep_name='';
	
	
	function chair_tickets_class()
	{
			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

	}
	
	
	function Start()
	{

	if (isset($_REQUEST['logout']))
		{
		unset($_SESSION['Customer']);
		unset($_SESSION['company_id']);
		}
	
	
	if (!isset($_SESSION['last_sql']))
		$_SESSION['last_sql'] = '';

			
		 //	$_SESSION['sql'] = sprintf("SELECT distinct  o.Student, SUM(d.Quantity) as NoItems, o.retail, o.Teacher FROM Orders o, OrderDetail d Where  d.CompanyID='%s' And  o.CustomerID='%s'  And  o.Student = d.Student Group by d.Student Having NoItems>'%d' ORDER BY NoItems", $_POST['Company'], $_POST['Customer'], $_POST['NoItems']);
			$_SESSION['sql'] = sprintf("SELECT   o.Student, Nro_Items as NoItems, o.Retail, o.Teacher, c.City FROM Orders o Left Join Customer c On o.CompanyID=c.CompanyID And o.CustomerID=c.CustomerID  Where  o.CompanyID='%s' And o.CustomerID='%s' And Nro_Items>='%d' ", $_SESSION['Company'], $_SESSION['Customer'], 0);
			$_SESSION['last_sql'] = $_SESSION['sql'];
			//print $_SESSION['sql'];

			

	
	if (!isset($_SESSION['Customer']))
		{
		header("Location: db_chair_main.php");
		exit;
	
		
		}
		
			
			if (isset($_REQUEST['page']))
				$page = $_REQUEST['page'];
			else
				$page=1;
			

			
			if (isset($_REQUEST['Sort']))
				{
				
			if ($_SESSION['Sort'] == $_REQUEST['Sort'])
					if ($_SESSION['Order'] == "ASC")
						$_SESSION['Order'] = "DESC";
					else
						$_SESSION['Order'] = "ASC";
				
				$_SESSION['Sort'] = $_REQUEST['Sort'];
				$_SESSION['sql'] .= "ORDER BY ".$_SESSION['Sort'];
				$_SESSION['sql'] .= " ".$_SESSION['Order'];
				}
			else
				{
				$_SESSION['Sort'] = 'Nro_Items';
				$_SESSION['Order'] = "DESC";
				$_SESSION['sql'] .= "ORDER BY Nro_Items DESC";
				
				}

			
			if (isset($_REQUEST['range']) && $_REQUEST['range']=="All")
				$_SESSION['line'] = 1000;
			else
				$_SESSION['line'] = 1000;
				
			$_SESSION['fieldRequire'] = true;

			$sql = $_SESSION['sql'];
			//print $sql;
			
			include("db_reps_viewer.php");
			if (!$_SESSION['line'])
    			$line = 1000;
			else
		    	$line = $_SESSION['line'];
			if (!$sql) {
		    	$sql = $conn->sql;
					} 


			//require("db_cart_form_class.php");
			//$frobj = new db_cart_form_class(); 
			

			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();
			
			
		//	$page_htm->AddScript('<script src="db_ajax.class.php?jsphp=db_ajax.class.php" language="JavaScript"></script>');
			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	false;
			$page_cnt->s_bar 	=	false;
			
			
			//$page_cnt->t_menu 	=	false;
			$page_cnt->Header(); 
			$page_cnt->Header_Center(); 
			$page_box->Header();
			
			$this->pattern_top();
							
			
			$conn = new Conn;
			$conn->_server = "207.104.236.2";
			$conn->_user = "SigData";
			$conn->_pwd = "SigData009";
			$conn->_db = "SigData";

			
			$connDB = $conn->connect($sql, $line); //create an object of split  pass the sql and total no of rows to be displayed in a page
			//if ($conn->errMsg != "") {
				// die($conn->errMsg);
				//} 
			$rows = $conn->getQuery($page);
			
			
			$conn->showTable_chair_tickets($rows);
			$conn->pageFooter($page,"db_chair_tickets.php");
			
						
			$this->pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
	}

			function pattern_top($Title="Student Item Report")
				{
				?>
					<table style="margin-top:30px"  cellpadding="0"  cellspacing="0" border="0"	 width="100%" bgcolor="#FFFFFF"> 
								
				
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a href='db_chair_main.php' > &laquo; Back </a> 
					|
					<a href='db_chair_main.php?logout'> <?php echo "Logout"; ?>   </a> 
				</div>
			

					<tr>
					<td height="41"  colspan="3">
					<div id='center_title'>
					<font size="+1">  <?php print $Title ?> </font>
					</div>
					<a name="top"></a>
				  	</td>
					</tr>	
					<tr valign="top">
					  <td width="2%"  rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td height="0"  align = "left"  valign="middle"><br></td>
                      <td width="2%" rowspan="3"> </td>
  					</tr>
				    <tr valign="top">
				      <td width="88%"  align = "right"  valign="top">
					
				<?
				}
				
			function pattern_bottom()
				{
				?>
				  </td>
  					</tr>
			    <tr valign="bottom">
					  <td height="5"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
				</table>
				<?
				}
				
			
		
	}	

				
				
				
		
?>