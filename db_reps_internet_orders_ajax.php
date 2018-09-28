<?php
  
//  if(!defined('JSPHP_INC')) die('YOU ARE NOT ALLOWED TO ACCESS THIS FILE DIRECTLY');
if (!session_id()) session_start();

  if(isset($_REQUEST['company_id']))
  	{
		$_SESSION['company_id'] = $_REQUEST['company_id'];
		
  	}
	  ?>
	  				<table width="100%" border="0" cellpadding="0"  cellspacing="0" bgcolor="#EBECF0">				
						<tr HEIGHT=25>
								
								<TD><IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=1 BORDER=0>	</TD>
								<TD align="right"><FONT CLASS=SearchNavCell NOWRAP>Season :</FONT></TD>
								<TD  ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
								<td  >	
								<select id="Company"  name = "Company" onchange="jsphp_shtml('Menu_1','db_reps_internet_orders_ajax.php','company_id='+document.frmDraw.Company.options[document.frmDraw.Company.selectedIndex].value);" >									
								<?PHP
								require_once("db_reps_class.php");
								$reps = new reps_class();
								$reps->get_sales_companies($_SESSION['rep_id']);
								$index=0;
								$ar = array();
								
								foreach ($reps->companies_array as $val_1)  
								{
									$ar[$index] = $val_1['CompanyID'];
									if (trim($val_1['CompanyID'])==trim($_SESSION['company_id']))
										$selected = ' selected';
									else
										$selected = ' ';
									echo "<option value='".$val_1['CompanyID']."'".$selected.">".$val_1['CompanyID']."</option>";
									$index++;
								}
								
								
								if(!isset($_SESSION['company_id']))
									$_SESSION['company_id'] = $ar[0];?>
								
								</select>
								</td>
								<TD><IMG SRC="images/spacer.gif" WIDTH=180 HEIGHT=1 BORDER=0>	</TD>
								<TD align="right"><FONT CLASS=SearchNavCell NOWRAP>School:</FONT></TD>
								<TD ALIGN=right><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>

								<td>
								<select name="Customer">
											
									 
									  <?php	  
									  	$reps->get_customers($_SESSION['company_id'], $_SESSION['rep_id']);
									    	foreach ($reps->customers_array as $val_1)  
											{
											if (isset($_SESSION['Customer']))
												if (trim($val_1['CustomerID'])==trim($_SESSION['Customer']))
													$selected = ' selected';
												else
													$selected = ' ';

												
												echo '<option value='.$val_1['CustomerID'].$selected.'>'.$val_1['Name'].'</option>';
												
											} 
											
												
											?>
								</select>
								</td>
								<TD><IMG SRC="images/spacer.gif" WIDTH=10 HEIGHT=1 BORDER=0>	</TD>
								<TD><IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=1 BORDER=0></TD>
								<TD bgcolor="#EBECF0"  align="center" VALIGN=BOTTOM>
								<td>
								<INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="" name="Submit">
								</td>
									
						</tr>
					</table>
					
	  <?php
	  //}
  ?>
