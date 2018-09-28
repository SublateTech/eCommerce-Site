<?php 
	//if($_SERVER['HTTPS'] != "on")
	//{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);exit;}
	if (!session_id()) session_start();
	$rep_sales = new reps_ranking_class();
	$rep_sales->Start();
	
	
	class reps_ranking_class { 
	
	var $rep_id='';
	var $rep_name='';
	
	
	function reps_ranking_class()
	{
			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

	}
	
	
	function Start()
	{

	if (isset($_REQUEST['logout']))
		{
		unset($_SESSION['rep_id']);
		unset($_SESSION['company_id']);
		}
	
	require_once("db_reps_class.php");
	$myReps = new reps_class();
	
	if (!isset($_SESSION['last_sql']))
		$_SESSION['last_sql'] = '';

	if ($_POST)	
		{
			
		 //	$_SESSION['sql'] = sprintf("SELECT distinct  o.Student, SUM(d.Quantity) as NoItems, o.retail, o.Teacher FROM Orders o, OrderDetail d Where  d.CompanyID='%s' And  o.CustomerID='%s'  And  o.Student = d.Student Group by d.Student Having NoItems>'%d' ORDER BY NoItems", $_POST['Company'], $_POST['Customer'], $_POST['NoItems']);
			$_SESSION['sql'] = sprintf("SELECT   o.Student, sum(Nro_Items) as Nro_Items, o.Retail, o.Teacher FROM Orders o Where  o.CompanyID='%s' And o.CustomerID='%s'  Group by o.Teacher ", $_POST['Company'], $_POST['Customer']);
			//print $_SESSION['sql'];
			$_SESSION['last_sql'] = $_SESSION['sql'];
			//print $_SESSION['sql'];
			$_SESSION['Customer'] = $_POST['Customer'];
			
			
		}else
			{ $_SESSION['sql'] = $_SESSION['last_sql']; }
		
	
	if (!isset($_SESSION['rep_id']))
		{
		header("Location: db_reps_main.php");
		exit;
	
		}
		
						
			$myReps->get_sales_companies($_SESSION['rep_id']);
			
			if (isset($_REQUEST['page']))
				$page = $_REQUEST['page'];
			else
				$page=1;
			
			if (!isset($_SESSION['company_id']))	
				{
					if (!isset($_SESSION['company_id']))
						if (count($myReps->companies_array) > 0)
						{
							$_SESSION['company_id'] = $myReps->companies_array[0]['CompanyID'];
							for($x=0; $x < count($myReps->companies_array); $x++)
							{
								if ($myReps->companies_array[$x]['CompanyID']=="F08")
									$_SESSION['company_id'] = $myReps->companies_array[$x]['CompanyID'];
							}
						}
						else
							$_SESSION['company_id'] = "";
					$rep_id = $_SESSION['rep_id'];
					$company_id = $_SESSION['company_id'] ;
					
				}
			else
				{
					$rep_id = $_SESSION['rep_id'];
				}

			
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
			
			
			$page_htm->AddScript('<script src="db_ajax.class.php?jsphp=db_ajax.class.php" language="JavaScript"></script>');
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
			
			
			$conn->showTable_reps_ranking_classes($rows);
			$conn->pageFooter($page,"db_reps_ranking_classes.php");
			
						
			$this->pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
	}

			function pattern_top($Title="Classes Ranking")
				{
				?>
					<table style="margin-top:30px"  cellpadding="0"  cellspacing="0" border="0"	 width="100%" bgcolor="#FFFFFF"> 
								
				
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a href='db_reps_main.php' > &laquo; Back </a> 
					|
					<a href='db_reps_main.php?logout'> <?php echo isset($_SESSION['rep_id'])?"Logout":''; ?>   </a> 
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