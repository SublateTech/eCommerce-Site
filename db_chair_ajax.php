<?php
  
//  if(!defined('JSPHP_INC')) die('YOU ARE NOT ALLOWED TO ACCESS THIS FILE DIRECTLY');
if (!session_id()) session_start();

if(isset($_REQUEST['action']) && $_REQUEST['action']=='1') 
	{
	
		require("db_chair_class.php");
		$chair = new chair_class();

		?>
						
			<table  border="0" align="center" width="90%">
						<tr>
							<td colspan="6">
								
									<table  border="0" width="100%">
										<tr>
											<td width="40%" align="left">
												<?php 
													//$chair->get_order_header($_REQUEST['Teacher'], $_REQUEST['Student']);	 
													$chair->get_order_header_by_id($_REQUEST['ID']);	 
													if (count($chair->order_array)>0)
														{
															print 'Student :    '.'<b>'.$_REQUEST['Student'].'</b>'; 
														} ?>
											</td>
											<td >
												Prize Level: <?php print "<b>".$chair->order_array[0]['Prize']."</b>"; ?>
											</td>
											<td >
												Retail: <?php print "<b>".$chair->format_value($chair->order_array[0]['Retail'],true)."</b>"; ?>
											</td>
										
											<td >
												Collected: <?php print "<b>".$chair->format_value($chair->order_array[0]['Collected'],true)."</b>"; ?>
											</td>
											
											<td width="15%" align="right">
												<img src="images/up.gif"  onClick="expandcontent(this,'<?php print $_REQUEST['ID']?>');" />
											</td>
										</tr>
									</table>
								
							</td>
							
							
							
						</tr>
					
						<?php 
							//$chair->get_order_detail($_REQUEST['Teacher'], $_REQUEST['Student']);
							$chair->get_order_detail_by_id($_REQUEST['ID']);
							 $i=0;
							 ?>
							 <tr >
	 								<?php echo "<td  style='padding-left:10px' width='10%'  align='left' bgcolor=".$chair->row_color($i).">";?> <?php echo "<b>Item</b>"; ?></td>
									<?php echo "<td width='50%' align='left' bgcolor=".$chair->row_color($i).">";?> <?php echo '<b>Description</b>';?>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo '<b>Quantity</b>'; ?></td>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo '<b>Price</b>'; ?></td>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo '<b>Subtotal</b>';?></td>
									</tr>
							<?php	
							 $i++; 
							 foreach ($chair->detail_array as $val) { 
								
								?>
									<tr >
									<?php echo "<td  style='padding-left:10px' width='10%'  align='left' bgcolor=".$chair->row_color($i).">";?> 
									<?php
												echo "<a  href='#' onclick=\"javascript:NewWindow('db_chair_ranking.php?item=";
												echo $val['ProductID']; 
												echo "','',450,530,'')\">".$val['ProductID']."</a>";

									?> 
									<?php //echo $val['ProductID']; ?></td>
									<?php echo "<td width='50%' align='left' bgcolor=".$chair->row_color($i).">";?> 
																			<?php
												echo "<a  href='#' onclick=\"javascript:NewWindow('db_chair_ranking.php?item=";
												echo $val['ProductID']; 
												echo "','',450,530,'')\">".$val['Description']."</a>";

									?> 

									<?php //echo $val['Description'];?>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo $val['Quantity']; ?></td>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo $chair->format_value($val['Price']); ?></td>
									<?php echo "<td width='10%' align='right' bgcolor=".$chair->row_color($i).">";?><?php echo $chair->format_value($val['Subtotal']);?></td>
									</tr>
							 <?php
							 $i++;
							 }
							 
						?>
						<tr height="3px"></tr>
			</table>
		
	<?php
		exit;
	
	}


  if(isset($_REQUEST['company_id']))
  	{
		$_SESSION['Company'] = $_REQUEST['company_id'];

		
  	} ?>	  				
					<table width="100%" border="0" cellpadding="0"  cellspacing="0" bgcolor="#FFFFFF">				
							<tr>
								
								<TD  align="right">Season :</FONT></TD>
								<TD  ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
								
								<td  align="left" >	
								<?php 
								require_once("db_cart_form_class.php");
								$frobj = new db_cart_form_class();	 
		
								
								
								$ar1 = array();
								$ar1[0][0] ='Spring 2007         ';
								$ar1[0][1] ='S07';
								$ar1[1][0] ='Fall 2007           ';
								$ar1[1][1] ='F07';
								$ar1[2][0] ='Spring 2008         ';
								$ar1[2][1] ='S08';
								$ar1[3][0] ='Fall 2008           ';
								$ar1[3][1] ='F08';
								$ar1[4][0] ='Spring 2009         ';
								$ar1[4][1] ='S09';




								
								if(!isset($_SESSION['Company']))
									$_SESSION['Company'] = $ar1[4][1];
							
								print $frobj->add_select_list_value('Company', $_SESSION['Company'], $ar1, true, false,"onchange=\"jsphp_shtml('Login_1','db_chair_ajax.php','company_id='+document.frmChair.Company.options[document.frmChair.Company.selectedIndex].value);\"");
														
						 		?>
								</td> 
								</tr>
								
								<tr >
									<td height="20px"></td>
								</tr>
								
								<tr>
							 
								<TD width="40%" align="right">Chairperson Name :</FONT></TD>
								<TD ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>

								 <td align="left">
						 
								<?php 	
										require_once("db_cart_form_class.php");
										$frobj = new db_cart_form_class();	 
										$frobj->TextBox('Customer', '', true, '', 30, "default",false);	
										echo $frobj->Objets['Customer']->show(); ?>

								 <?php
								 	/*
									require_once("db_chair_class.php");
									$chair = new chair_class();
									$chair->get_customers($_SESSION['Company']);
									$ar = array();
									$index = 0;
									foreach ($chair->customers_array as $val_1)  
										{
											$ar[$index][0] = $val_1['Name']." (".$val_1['State'].") ";	
											$ar[$index][1] = $val_1['Name'];
											$index++;
										}																						
									echo $frobj->add_select_list_value('Customer','', $ar, true, true,true);
									*/

								?>
								
								 </td>
								</tr>
								<tr >
									<td height="20px"></td>
								</tr>
								
								<tr>
								 <TD width="20%" align="right"><FONT  NOWRAP>Password :</FONT></TD>
								 <TD ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
								 <td align="left">	
									
								<?php 	$frobj->TextBox('password', '', true, '', 10, "default",true);	
										echo $frobj->Objets['password']->show(); ?>
										
								</td>
								</tr>
								<tr >
									<td height="20px"></td>
								</tr>
								<tr>
								
								<td></td>
								<td></td>
								<td  align="left" width="100%"	> 
								<?php
									$frobj->Button('Submit', "Log In", "submit", "default");
									$frobj->Objets['Submit']->show();
									?>
									
								</td>
						</tr>
					</table>
					
	  <?php
	  //}
  ?>
