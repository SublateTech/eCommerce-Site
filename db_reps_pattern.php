<?php 
if (!session_id()) session_start();
			require("db_cart_form_class.php");
			$frobj = new db_cart_form_class(); 

			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

			
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
				  	pattern_top("Sales Rep Charges");
					?>
				
						<table  valign="top" border="0" width="100%" >
						
								 <p><FONT face="Arial, Helvetica, sans-serif" size="2"><b><br>
			            			<br>
				            		Welcome to our Reps Area:</b>	</FONT><br>
			            			<br>
				          		<br>
					    		<a href="#1"><p>1. Rep Sales Report</p><br></a>
					    		<a href="#2"><p>2. Sales Rep Charges</p><br></a>
					    		
						    					    
						
						</table>
				

						<?
						pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 

	function pattern_top($Title="Rep Sales Report")
				{
				?>
					<table style="margin-top:30px"  border="0"	 width="100%" bgcolor="#FFFFFF"> 
								
				
				<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
					<a href='db_reps_sales.php?logout'> <?php echo isset($_SESSION['rep_id'])?"Logout":''; ?>   </a> 
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
					  <td width="40%"  rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td height="0"  align = "left"  valign="middle"><br></td>
                      <td width="40%" rowspan="3"> </td>
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
				
		
?>