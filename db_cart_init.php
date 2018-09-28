<?php
error_reporting(E_ALL);
require_once("db_cart_functions.php");
class Content
	{
			
		var $menu 	= true;  //left - menu
		var $rmenu 	= false;  //right - menu
		var $t_menu	= true;
		var $s_bar 	= true; 
		
		
		function Header_Center()
			{
			$this->SearchBar();
			?>
			
			
			<tr align="center">	<!-- Middle Part -->
									
									<?php if ($this->menu) { ?>
										<td align="center" valign="top" width="150px" bgcolor="#FFFFFF" >
									
											<?php  
												//require("db_cart_leftmenu.php"); //Old Fashion
												require_once('db_cart_menu.php');   
												$menu = new cart_menu();
												$menu->left_menu();
											?> 
									
										</td> 
									<?php }?>

				      			 	<td  align="left" bgcolor="#FFFFFF" valign="top" width="<?php 
									
									if ($this->rmenu && $this->menu)
										{
										$browser = GetBrowser();
										if ($browser[0]==5 && $browser[1]=='7.0')
											echo "64%";
										else
											echo "65%";
										}
									elseif 	($this->menu)
										echo "630";
									else
										echo "100%";
									
									/*echo ($this->rmenu ? "65%" : $this->menu ? "80%":"100%");*/
									
									?>">
									
					<?php
				}
	
		function SearchBar()
			{
			?>
			<?php if ($this->s_bar)
					{
								?>


			<tr bgcolor="#00FF00" >
				<td   style="padding-bottom:1;"  bgcolor="#3B405E" colspan="3" >
					<table    width="100%" border="0" cellpadding="0"  cellspacing="0">
						<tr>
							<TR HEIGHT=25 WIDTH=386 >
							<TD bgcolor="#EBECF0" align="center">
							<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0>
							<FORM NAME=frmSearch METHOD='post' ACTION="db_cart_main.php">
								<TR><TD><IMG SRC="images/spacer.gif" WIDTH=40 HEIGHT=1 BORDER=0>	</TD>
								<TD><FONT CLASS=SearchNavCell NOWRAP>Search by item #</FONT></TD>
								<TD ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
								<TD>
								<INPUT TYPE=text NAME=Search SIZE=0 MAXLENGTH=150 VALUE=""></TD>
								<TD><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=1 BORDER=0></TD>
								<TD VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit search" name="submit search"></TD>
								</TR>
							</FORM>
							</TABLE>
							</TD>
		
							<TD bgcolor="#EBECF0" align="center">
							<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0>
							<FORM NAME=frmSearch METHOD='post' ACTION="db_cart_main.php">
							<TR><TD><IMG SRC="images/spacer.gif" WIDTH=40 HEIGHT=1 BORDER=0>	</TD>
							<TD><FONT CLASS=SearchNavCell NOWRAP>Search:</FONT></TD>
							<TD ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
							<TD>
								<?php // <INPUT TYPE=text Class=TextBoxStandardText ID=SearchString NAME=SearchString SIZE=0 MAXLENGTH=150 VALUE=""> ?>								
								<select name="select">
 									 <option>by Name</option>
									 <option>by Description</option>
									 <option>by Item Number</option>
									 <option>por Español</option>
								</select>
								<INPUT TYPE=text ID=SearchString NAME=SearchString SIZE=0 MAXLENGTH=150 VALUE="">
							</TD>
							<TD><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=1 BORDER=0></TD>
							<TD bgcolor="#EBECF0" VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit search" name="submit search"></TD>
							</TR>
							</FORM>
							</TABLE>
							</TD>
							</TR>
							
							
							
						<?php //</tr> ?>
				
					</table>
				
				</td>
				
			</tr>
			<?php
				}  //End Search Menu
			}
	
		function Footer_Center()
			{
			?>
			<!-- <td valign="top" width="20%">Col3 </td> -->
								</td>
									</tr>	<!-- End Middle Part -->	   	  		
								
			<?php   		
			}
	
		function open_right_menu()
			{
			?>
			</td>
				<?php
					$browser = GetBrowser();
					if ( $browser [0] == 3  || $browser [0] == 6  || ($browser[0]==5 && $browser[1]=='7.0'))
			  			echo '<td style="padding-right:2.5px;" align="left" bgcolor="#FFFFFF" valign="top" width="120px">';
					else
						echo '<td style="padding-right:2.5px;" align="left" bgcolor="#FFFFFF" valign="top" width="120px">';
				?>
			<?php 
			}
	
		function close_right_menu()
			{
			?>
				</td> 
					</tr>	<!-- End Middle Part -->	   	  		
	
			<?php
			}
		
	
	
		function Header()
			{
			?>
			<?php 
		
				//Header Page
				//$this->$hp->ShowHeader(); 
			?>
			
			<table width="780"  border="0" valign="center" align="center" cellspacing="0" bgcolor="#3B405E">
					<tr>
						<td>
							  <?php // <!-- --------------------------  Banner ----------------------------------------------------------> ?>
							  <tr>  <!-- Banner -->	
									<td colspan= "3"> 
												<?php require ('banner.php'); ?>
								 	</td>
							   </tr> <!-- End Benner -->
							   
							   <?php //<!-- ----------------------------------- Menu Bar -----------------------------------------------> ?>
								<?php if ($this->t_menu)
											{
								?>
								<tr> <!-- Menu Bar -->
									<td  height="15px" width="100%" colspan= "3"> <?php 
										require_once('db_cart_menu.php');   
										$menu = new cart_menu();
										$menu->top_menu();
									?>  </td> 		
								</tr> <!-- En Menu Bar -->
								<?php } ?>
				
			<?php 
			}
	
		function Footer()
			{
			?>
									<tr> <td colspan= "3"> <div id='BottomRow'><?php require('footer.php') ?> </div> </td> </tr>
						</td>				
					</tr>
				</table>
				<script language="JavaScript" src="css/cot.js" type="text/javascript"></script>
				<script type="text/javascript">COT("images/cornertrust.gif", "SC2", "none");</script>
				<?php /*
				<div id='fixmetoo'>
						<img src="images/cornertrust.gif" >
				</div> */ ?>

				
				
				<?php
				//$this->$hp->EndPage();
				?>
		
			<?php
				return;
			}
	
	}				

?>
