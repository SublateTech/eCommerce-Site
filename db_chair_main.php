<?php 
	//if($_SERVER['HTTPS'] != "on")
	//{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);exit;}
	
	if (!session_id()) session_start();
		
	$chair = new chair_main_class();
	$chair->Start();
	
	
	class chair_main_class { 
	
	var $rep_id='';
	var $rep_name='';
	
	
	function chair_main_class()
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
		unset($_SESSION['Company']);
		}
		
	
	require_once("db_chair_class.php");
	$myChair = new chair_class();

	if (isset($_POST['Submit']))	
		{
		
		if (!$myChair->check_password($_POST['Customer'],$_POST['password']))
		 	{
			header("Location: db_chair_main.php");
			exit;
			}
			unset($_POST['Submit']);
		}
		
	
		
	if (!isset($_SESSION['Customer']) || !isset($_SESSION['Company']) )
		{
		$this->login();
		die();
		}
			
			if (isset($_REQUEST['page']))
				$page = $_REQUEST['page'];
			else
				$page=1;
				
			
			
			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();
			$page_htm->AddScript('<script src="./clsJSPHP.php?jsphp=./clsJSPHP.php" language="JavaScript"></script>');
			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	false;
			$page_cnt->s_bar 	=	false;
			//$page_cnt->t_menu 	=	false;
			$page_cnt->Header(); 
			$page_cnt->Header_Center(); 
			$page_box->Header();
			
			$this->pattern_top("Chairperson Area");
							
			?>
						<table  valign="top" border="0" width="100%" >
						
						  <tr>
								   <td></td>
								   <td width="30%"  align="left" ></td>
								   <td width="20%"  align="left" >
								   		<div id="navcontainer">
											<ul id="navlist">
												<li><a href="db_chair_ranking.php?range=All" id="current">School Sellers</a></li>
											</ul>
											<ul id="navlist">
												<li><a href="db_chair_ranking_classes.php?range=All" id="current">Classes Ranking</a></li>
											</ul>
											<ul id="navlist">
												<li><a href="db_chair_tickets.php" id="current">Student Item Reports</a></li>
											</ul>
											<ul id="navlist">
												<li><a href="db_chair_internet_orders.php?range=All" id="current">Internet Orders</a></li>
											</ul>
											<ul id="navlist">	
												<li><a href="db_chair_x-bash.php" id="current">X-Treme Bash Party</a></li>
											</ul>

										</div>

								   
								   </td>
								   <td width="30%"  align="left" ></td>
								   <td></td>
					      </tr>
						</table>

			<?
	
			$this->pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
	}

			function pattern_top($Title="Chairperson Area")
				{
				?>
					<table style="margin-top:30px"  border="0"	 width="100%" bgcolor="#FFFFFF"> 
								
				
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a href='db_chair_main.php?logout'> <?php echo isset($_SESSION['Customer'])?"Logout":''; ?>   </a> 
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
					
					$page_htm->AddScript('<script src="./clsJSPHP.php?jsphp=./clsJSPHP.php" language="JavaScript"></script>');		
					$page_htm->ShowHeader(); 
					$page_cnt->menu 	=	false;
					$page_cnt->s_bar 	=	false;
					//$page_cnt->t_menu 	=	false;
					$page_cnt->Header(); 
					$page_cnt->Header_Center(); 
					$page_box->Header();
					
					$this->pattern_top("Chairperson Area - Log In");
					?>
							<table   align="center" valign="top" border="0" width="60%" >
						<TR align="left">
                           <td align="center" >
						   		
								<FORM NAME='frmChair' METHOD='post' ACTION="db_chair_main.php">
								<?php 
								print '<div id="Login_1">';
									include_once("db_chair_ajax.php");
								print '</div>';
								?>
								
								</FORM>
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