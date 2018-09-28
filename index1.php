<?php
require "page.php";
$homepage = new Page();
//Header Page
$homepage->ShowHeader();

Class Content
	{
		function Content()
				{

					$this-> CreateStructure();
/*					TopRow();
					LeftColumn();
					
					RightColumn();
					BottomRow(); */
				}
				
		function CreateStructure()
				{
					
					?>
					<table width="100%"  border="0" valign="center" align="center" cellspacing="0" bgcolor="#3B405E">
					<tr>
						<td>
							  <!-- --------------------------  Banner ---------------------------------------------------------->
							  <tr>  <!-- Banner -->	
									<td colspan= "3"> 
										<div id='BannerRow'>
								 			<DIV class="innerDIV">
												<?php require ('banner.php'); ?>
								 			</DIV>
    									</div>
							   		</td>
							   </tr> <!-- End Benner -->
							   
							   <!-- ----------------------------------- Menu Bar ----------------------------------------------->
								<tr> <!-- Menu Bar -->
									<td  width="100%" colspan= "3"> <?php require('smenu.php');   ?>  </td> 		
								</tr> <!-- En Menu Bar -->
								
								<!-- ----------------------- Middle ------------------------------------------------------------->
								
								<tr  border = "0" bgcolor="ffffff" >	<!-- Middle Part -->
									<?php /* <td valign="top" width="20%"><div id= 'LeftCol'> <?php  require("LeftMenu.php"); ?> </div>  </td> 
				      			 	<td valign="top" width="80%"><div id= 'CenterCol'> <?php require('ContCenterCol.php') ?> </div> </td> */ ?>
						  	 						
									<td>
									<table  border="0"  height="450px"cellpadding="0" cellspacing="0" width="100%">
										<tr>
												<td colspan= "3" width="100%" height="240px" align="center" valign="center" background="images/SigMiddle.gif">			 		
						 						</td>	
										
										</tr>
														
										<tr>
													<td  height="226" width="80%" height="22px" align="center" valign="left" background="images/Girl-line.gif">			 		
							 						</td>
													<td  width="165" height="226" align="bottom" valign="center">			 		
														<img   height="100%"  src="images/Girl.gif" />
	 												</td>
													<td width="12%"  height="226" align="center" valign="left" background="images/Girl-line.gif">			 		
							 						</td> 
										</tr>
									</table>
									</td>
								 	<!-- <td valign="top" width="20%">Col3 </td> -->
								</tr>	<!-- End Middle Part -->	   	  		
						   		
								<!-- -------------------------- Footer ----------------------------------------------------------->					  		
								<tr> <td colspan= "3"> <div id='BottomRow'><?php require('footer.php') ?> </div> </td> </tr>
						</td>				
					</tr>
				</table>
				
					
				<?php
							
				}

				function CenterColumn()
					{
		 			
				 		
				 	}
					
				
}				

$xContent = new Content();

$xContent-> CenterColumn();
$homepage->EndPage();
?>
