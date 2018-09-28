<?php 
	//if($_SERVER['HTTPS'] != "on")
	//{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);exit;}
	if (!session_id()) session_start();
	$rep_sales = new reps_sales_class();
	$rep_sales->Start();
	
	
	class reps_sales_class { 
	
	var $rep_id='';
	var $rep_name='';
	
	
	function reps_sales_class()
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

	if (isset($_POST['Submit']))	
		{
		
		if ($myReps->check_password($_POST['user'],$_POST['password']))
			{
				$_SESSION['rep_id'] = $myReps->rep_id;
				$_SESSION['rep_name'] = $myReps->rep_name;
				$this->rep_name = $myReps->rep_name;
				
				unset($_POST['user']);
				unset($_POST['password']);
			}
		 else
		 	{
			header("Location: db_reps_sales.php");
			exit;
			}
			unset($_POST['Submit']);
		}
	
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
			

			if (!isset($_REQUEST['company']))	
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
										$_SESSION['sql'] = "SELECT c.CustomerID,c.AmountDue,b.Description, bc.BrochureID, bc.CODE, bc.ProfitPercent, bc.ProfitAmount, bc.Retail, bc.InvoiceAmount, c.RepID,r.Name,  c.Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone, c.PrizeID, p.Description as Prize_Description,   DATE_FORMAT(SignedDate,'%m/%d/%y') as SignedDate, DATE_FORMAT(StartDate,'%m/%d/%y') as StartDate, DATE_FORMAT(EndDate,'%m/%d/%y') as EndDate, DATE_FORMAT(PickUpDate,'%m/%d/%y') as PickUpDate, DATE_FORMAT(DeliveryDate,'%m/%d/%y') as DeliveryDate, bc.NoItems, Signed , bc.NoSellers,c.Retail as c_Retail, c.Retail/c.NoSellers as Avg_Retail, c.NoItems/c.NoSellers as Av_Units, bc.ProfitAmount   FROM Customer c LEFT JOIN Prizes p ON c.CompanyId=p.CompanyID and c.PrizeID=p.PrizeID LEFT JOIN Rep r ON c.CompanyId=r.CompanyID and  c.RepID=r.RepID LEFT JOIN BrochureByCustomer bc ON c.CompanyId=bc.CompanyID and  c.CustomerID=bc.CustomerID  LEFT JOIN Brochure b ON bc.BrochureID=b.BrochureID And bc.CompanyId=b.CompanyID  Where c.CompanyID ='$company_id' And c.Rep_Id='$rep_id' ORDER BY c.CompanyID,c.RepID,c.Name";

				}
			else
				{
					$rep_id = $_SESSION['rep_id'];
					
					$_SESSION['company_id'] = $_POST['select'];
										
					$company_id = $_SESSION['company_id'] ;
					$_SESSION['sql'] = "SELECT c.CustomerID,c.AmountDue,b.Description, bc.BrochureID, bc.CODE, bc.ProfitPercent, bc.ProfitAmount, bc.Retail, bc.InvoiceAmount, c.RepID,r.Name,  c.Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone, c.PrizeID, p.Description as Prize_Description,   DATE_FORMAT(SignedDate,'%m/%d/%y') as SignedDate, DATE_FORMAT(StartDate,'%m/%d/%y') as StartDate, DATE_FORMAT(EndDate,'%m/%d/%y') as EndDate, DATE_FORMAT(PickUpDate,'%m/%d/%y') as PickUpDate, DATE_FORMAT(DeliveryDate,'%m/%d/%y') as DeliveryDate, c.NoItems, Signed , c.NoSellers,c.Retail  as c_Retail, c.Retail/c.NoSellers as Avg_Retail, c.NoItems/c.NoSellers as Av_Units, bc.ProfitAmount   FROM Customer c LEFT JOIN Prizes p ON c.CompanyId=p.CompanyID and c.PrizeID=p.PrizeID LEFT JOIN Rep r ON c.CompanyId=r.CompanyID and  c.RepID=r.RepID LEFT JOIN BrochureByCustomer bc ON c.CompanyId=bc.CompanyID and  c.CustomerID=bc.CustomerID  LEFT JOIN Brochure b ON bc.BrochureID=b.BrochureID And bc.CompanyId=b.CompanyID  Where c.CompanyID ='$company_id' And c.Rep_Id='$rep_id' ORDER BY c.CompanyID,c.RepID,c.Name";
				}

			if (isset($_REQUEST['range']) && $_REQUEST['range']=="All")
				$_SESSION['line'] = 1000;
			else
				$_SESSION['line'] = 6;
				
			$_SESSION['fieldRequire'] = true;

			$sql = $_SESSION['sql'];
			include("db_reps_viewer.php");
			if (!$_SESSION['line'])
    			$line = 10;
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
			if ($conn->errMsg != "") {
				// die($conn->errMsg);
				} 
			$rows = $conn->getQuery($page);
			
						 
			$conn->showTable_sales($rows, $_SESSION['fieldRequire']);
			$conn->pageFooter($page);
						
			$this->pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
	}

			function pattern_top($Title="Rep Sales Report")
				{
				?>
					<table style="margin-top:30px"  border="0"	 width="100%" bgcolor="#FFFFFF"> 
								
				
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
				
			function login()
			{
			
					$page_htm = new page();
					$page_cnt = new Content();
					$page_box = new boxstd();
					
							
					$page_htm->ShowHeader(); 
					$page_cnt->menu 	=	false;
					$page_cnt->s_bar 	=	false;
					//$page_cnt->t_menu 	=	false;
					$page_cnt->Header(); 
					$page_cnt->Header_Center(); 
					$page_box->Header();
					
					$this->pattern_top("Log In");
					?>
							<table   align="center" valign="top" border="0" width="35%" >
						<TR align="left">
                           <td align="center" >
						   		<?php 
																					
								require_once("db_cart_form_class.php");
								$frobj = new db_cart_form_class();	 
								
								echo $frobj->form_start('form2', 'db_reps_sales.php', 'error', false);
								
								echo $frobj->input_text('User ID:','user', '', '', '', 20, true);
								echo $frobj->input_text('Password:','password', '', true, '', 20, true);		
								
								echo "<tr><td></td><td align='center' colspan='1'>";
  								echo "<p class='label' >".$frobj->form_end(true,'Submit','Log In')."</p>";
								echo '</td></tr>';
								
						   		?>
						   </td>
											  							 
                          </TR>
								  
							</table>
					<?php
					$this->pattern_bottom();	
					$page_box->Footer(); 
					$page_cnt->Footer_Center(); 
					$page_cnt->Footer(); 
					$page_htm->EndPage(); 

			}
			
		
	}	

				
				
				
		
?>