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
									<td valign="top" width="20%"><div id= 'LeftCol'> <?php  require("LeftMenu.php"); ?> </div>  </td> 
				      			 	<td valign="top" width="80%"><div id= 'CenterCol'> <?php require('ContCenterCol.php') ?> </div> </td> 
						  	 											
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
