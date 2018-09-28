<?php
require_once("db_cart_functions.php");		

Class Conn {
    var $_server; //database server
    var $_user; //database username
    var $_pwd; //database password
    var $_db; //database name
    var $conn;

	var	$cols;
	var $totalcols; //total no of cols returned by the query
    var $totalrows; //total no of rows returned by the query
    var $maxrow; //total no of rows displayed in a page
	var $min = 0;
	var $max = 0;
	
    var $sql; //the main query
    var $errMsg;
    var $totalpages;
    var $fieldName;
	var $view = 1;  //1=Normal View, 2=Item View, 3=LeftMenu View
	var $item = "";

	function setview($view)
	{
		$this->view = $view;
				
	}

	
	function setcols($cols)
	{
		$this->cols = $cols;
	}
	
	function setitem($item)
	{
		$this->item = $item;
	}

	
	function setrows($rows)
	{
		$this->maxrow = $rows;
	}


    function connect($sql, $maxrow)
    {	

		$this->sql = $sql;
        $this->maxrow = $maxrow;
        if ($this->maxrow <= 0) {
            $this->errMsg = "Max results in a page is not a valid entry";
            return;
        } 
        
		$this->conn = mysql_connect($this->_server, $this->_user, $this->_pwd)
        or die("Error: " . mysql_error() . "<br>");
        mysql_select_db($this->_db, $this->conn)
        or 	die("Error: " . mysql_error() . "<br>");
			

        $result = mysql_query($sql);
        if (!$result) {
            $this->errMsg = "ERROR: " . mysql_error() . "<br>";
            return;
        } 

     /*   $fieldCount = mysql_num_fields($result);
        for ($i = 0; $i < $fieldCount; $i++) {
            $fieldName[$i] = mysql_field_name($result, $i);
        } */
       /* $this->fieldName = $fieldName; */
        // echo $this -> fieldName[0];
        $this->totalrows = mysql_num_rows($result);
		//if ($this->maxrow == 9999)
		//	$this->maxrow = $this->totalrows;
        if ($this->totalrows == 0) { // total rows=0
            $this->errMsg = "No Result returned";
            return;
        } 
        //$this->totalcols = mysql_num_fields($result); 
        // Get the number of pages
        $this->totalpages = (int)(($this->totalrows-1) / $this->maxrow + 1);
        return;
    } 

    function getQuery($page) // in this method only the present page to be displayed will be passed
    {
		//if ($view == $this->viewtype)
		
        if (($page == "") || ($page <= 0)) { // if the page passed is null, show the first page
            $min = 0;
        } else {
            if ($page > $this->totalpages) { // go to the last page
                $min = $this->maxrow * ($this->totalpages-1);
            } else { // Calulate the max and min limit for the page
                $page = $page-1;
                $min = $page * $this->maxrow;
                $max = $this->maxrow;
            } 
        } 
	    // generate the query with the limits
        $sqlimit = $this->sql . " limit " . $min . "," . $this->maxrow;
        $outputdisplay = mysql_query($sqlimit)or die("ERROR" . mysql_error());
        if (mysql_num_rows($outputdisplay) == 0) {
            $this->errMsg = "No results";
            return;
        } else {
            return $outputdisplay;
        } 
    } 

    function showTable($rows, $view)
	 {
	 $this->viewtype=$view;
	 if ($view == 3)
	 	{
		//$this->showItem($rows);
		$this->ShowRightView($rows);
		return;	
		}
	 	 
	if ($view == 2)
		{
			$this->showItem($rows);
			return;
		}
	if ($view == 4)
		{
			$this->showItemImg($rows);
			return;
		}
		
	if ($view == 5)
		{
			$this->showFeaturedItemImg($rows);
			return;
		}


		echo "<table style='margin-top:10px;' border='0' cellpadding='0' cellspacing='0' width='100%'>"; 
		$perc = 100 / $this->cols;
		$x= $this->cols + 1;		
	
		while ($row = mysql_fetch_object($rows)) 	{
		
		if ($x==$this->cols + 1)
			{
			$x=1;
			echo "<tr>";
				}
			 echo "<td width='$perc%' >"; 
			?>
            <?php //onmouseover="this.style.borderStyle='dashed';" onmouseout="this.style.borderStyle='none';" ?>
			<table  align="center"  width="140px" border="0" cellpadding="0" cellspacing="0">
			
			<form  name="frmAdd"  action="<?php echo PROD_IDX; ?>" method="post">
    					
					<tr >
						<td colspan="1"  align="center" >
					<?php  //$imageData = $row->Small;
							//$this->base64_to_jpeg( $imageData, $row->ProductID.".jpg" )?>
			  <a href="db_cart_main.php?view=2&item=<?php echo $row->ProductID; ?>"> <img  style="margin-top:20px;" height="150px" src="/images/150H/<?php echo $row->ProductID.'.jpg';?>" /> </a>
						</td>
					</tr>	
					
					<tr >
						<td width="100%" colspan="1" align="center">
							<p class="divider">
				    		 <label style=" text-align: center; padding-left:5px; padding-right:5px; width:100%;" for="prod_<?php echo $row->ProductID; ?>">
										 <a href="db_cart_main.php?view=2&item=<?php echo $row->ProductID; ?>"><b>
									 <?php echo $row->ProductID.'. ' ; ?></b><?php echo $row->Name_Eng; ?> </a> 
								</label>
							</p>
						</td>
	  				</tr>
					
					<tr>
						
						<td colspan="1"   align="center">
							<?php 
									if ($row->old_price > 0 ) {
										echo "Price: "."<font style=\"text-decoration: line-through;\">".$_SESSION['myCart']->format_value($row->old_price)."</font>"; 
										echo  "  "."<font color='#FF0000'>"."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"."</font>"; }
									else
										echo "Price: "."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"; 
									
									
							?>
						</td>
	  				</tr>
									
	 				 		<input type="hidden" name="price" value="<?php echo $row->Price; ?>">
					  		<input type="hidden" name="art_no" value="<?php echo $row->ProductID; ?>">
					  		<input type="hidden" name="product" value="<?php echo escape_string($row->Name_Eng); ?>">
					 <tr >
					 	<td align="center">
					 	<table width="40%" >
							<tr>
					 		<td  width="50%"  align="right"  >
							<input name="add"  type="image"   value="submit"   src="images/add2cart.gif"  alt="Add to cart" >
							</td>
							<td width="50%" align="left" >
							<input  style="width:20px; padding:0; " type="text"  name="quantity" maxlength="4" value="1"   > 
							</td>
							</tr>
						</table>
						</td>
					</tr>
					
				</form>
			
			</table>
			
              
			  <?php
			  
           
			if ($x==$this->cols + 1)
				{ echo "</tr>";}
			$x+=1;
			echo "</td>";
            
        } 
		
		echo "</table>";
        return;
    } 

    function showItem($rows)
	 {
	 
        
		$row = mysql_fetch_object($rows);

		?>
				<table  width="100%" border="0" cellpadding="0" cellspacing="0">

					<form action="<?php echo PROD_IDX; ?>" method="post">
					<td  width="50%" align="center"  >
							<table border="0">
								<tr>
									<td>
										<?php // $imageData = $row->Small;
														
										//$this->base64_to_jpeg( $imageData, $row->ProductID.".jpg" )
							  			//<a href="db_cart_main.php?view=3&item=<?php echo $row->ProductID; ">
												echo "<a href='#' onclick=\"javascript:NewWindow('db_cart_main.php?img=larger&view=2&item=";
												echo $row->ProductID; 
												echo "','',450,530,'')\">"."<img  width='100%' height='150px' src=\"/images/150H/".$row->ProductID.'.jpg'. "\" />"."</a>";
										?>
										</a>
								 	</td>
								</tr>
								 <tr>
								 	<td  align="center">
										<?php if (!(isset($_REQUEST['img']) && $_REQUEST['img'] == "larger"))
												//echo "<a href='db_cart_view.php?img=larger&view=2&item=".$row->ProductID."'>Larger Image</a>";
												echo "<a  href=\"javascript:NewWindow('db_cart_main.php?img=larger&view=2&item=";
												echo $row->ProductID; 
												echo "','',450,530,'')\"><img src=\"img/search.gif\" />   Larger Image</a>";
																					?>
										
									</td>
								 </tr>
								 <?php if ($row->ProductID == "8851")
								 	{
									?>
								  <tr>
								 	<td  align="center">
										<?php if (!(isset($_REQUEST['img']) && $_REQUEST['img'] == "larger"))
												//echo "<a href='db_cart_view.php?img=larger&view=2&item=".$row->ProductID."'>Larger Image</a>";
												echo "<a  href=http://www.sigfund.com/images/Snowman_Custom.wmv><img src=\"img/search.gif\" />   Video </a>";
										?>
										
									</td>
								 </tr>
								<?php } ?>
							 </table>
						</td>
						
						<td  align="left">
							<table style="margin-right:5px" border="0">
								<tr>
									<td align="left">
										<p class="divider"> 
				    						<label  style="text-align:left; padding-right:5px; margin-left:0; width:100%;   " for="prod_<?php echo $row->ProductID; ?>">
										<b><?php echo $row->ProductID.'. ' ; ?>
										<?php echo $row->Name_Eng; ?> </b> 
											</label>
											</p> 
									</td>
								</tr>
								<tr>
									<td  align="Left">
											<?php echo "<i>". $row->Name_Spa . "</i><br>"; ?>
									</td>
	  							</tr> 
								<tr>
									<td  align="Left">
										<font style="font-size:12px; ">
											<?php echo $row->Description; ?>
										</font>
										<br>
									</td>
	  							</tr> 
								<tr>
									<td   valign="bottom"  height="30px" align="left">
										<?php /*echo "Price: "."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>";*/ ?>
														<?php 
										if ($row->old_price > 0 ) {
											echo "Price: "."<font style=\"text-decoration: line-through;\">".$_SESSION['myCart']->format_value($row->old_price)."</font>"; 
											echo  "  "."<font color='#FF0000'>"."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"."</font>"; }
										else
											echo "Price: "."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"; ?>
									</td>
	  							</tr>
										
	 				 					<input type="hidden" name="price"  	value="<?php echo $row->Price; ?>">
					  					<input type="hidden" name="art_no" 	value="<?php echo $row->ProductID; ?>">
					  					<input type="hidden" name="product" value="<?php echo escape_string($row->Name_Eng); ?>">
					 			<tr>
					   				<td   align="left">
						  				<input style="margin-top:20px; margin-left:-4px;" name="add" type="image" value="submit"  src="images/add2cart.gif" alt="Add to cart" >
									</td>
								</tr>
								<tr>
									<td  align="left">
										<span  style='margin-bottom:5;'> Quantity: </span>
										<input  style=" width:25px;" id="cart_width"  style="margin-bottom:0; " type="text"  name="quantity" maxlength="4" value="1" > 
						
									</td>
								</tr>

							</table>
						  </td> 
						  </tr>
	  			</form>
				</table>
		<?php 
        return;
    } 


    function pageFooter($page)
    {
      
	  $item = $this->item;
	  $view = $this->view;
	  $line = $this->maxrow;
        if (($page == "") || ($page <= "0")) { // first page
            $page = 1;
        } 
		//echo "<a href='db_cart_main.php?View=all'> View All |'</a>";
		if ($this->view == 1)
			{
			$rem = 0 ;
			if ($page == $this->totalpages)
				$rem = $this->totalrows - (int) $this->totalpages * $this->maxrow; 
			echo "<a href=db_cart_main.php?view=$view&range=All" .  "><b style=\"padding-left:10px;\" >View All</b></a>";					
			echo " | ".(($page-1) * ($this->maxrow) + 1)." - ". (((($page-1) * ($this->maxrow) + 1) + $this->maxrow - 1) + $rem)."". " of ".$this->totalrows. " | ";
			echo "Page: <b>".$page."</b> | ";
			}
        if ($page > $this->totalpages) { // stop at last page
            $page = $this->totalpages;
        } 
        if ($page > 1) { // insert the back link
            $backpage = $page-1;
			if ($item == "" )
	            echo "<a href=db_cart_main.php?view=$view&page=$backpage" .  ">&laquo;Back</a>&nbsp;&nbsp;" ;
			else
				echo "<a href=db_cart_main.php?item=$item&view=$view&page=$backpage" .  ">&laquo;Back</a>&nbsp;&nbsp;" ;
        } 
        if ($this->view != 3 && $this->view != 2)
		 for($j = 1;$j <= $this->totalpages;$j++) { // insert the page links
            if ($j == $page) {
                echo $j . "&nbsp;&nbsp;";
            } else {
            		if ($item == ""   )
						echo "<a href=db_cart_main.php?view=$view&page=$j" .  ">" . $j . "</a>&nbsp;&nbsp;" ;
					else
						echo "<a href=db_cart_main.php?item=$item&view=$view&page=$j" .  ">" . $j . "</a>&nbsp;&nbsp;" ;
            } 
        } 
        
		if ($page < $this->totalpages) { // insert the next link
            $nextpage = $page + 1;
            if ($item == "" )
				echo "<a href=db_cart_main.php?view=$view&page=$nextpage" .  ">Next&raquo;</a>&nbsp;&nbsp;" ;
			else
				echo "<a href=db_cart_main.php?item=$item&view=view&page=$nextpage" .  ">Next&raquo;</a>&nbsp;&nbsp;" ;
        } 
      
        return;
    } 
	function showFooter($page)
	{
	?>
	<tr>
		<td colspan="3" >
				<table  width="100%"  height="50px" border="0" cellpadding="0"  cellspacing="0" >
					<tr>
						<td   valign="bottom" align="left">
							<?php  if ($this->view  == 2) { ?>
							<?php //$this->pageFooter($page); ?>
								<a href="<?php echo "db_cart_main.php?view=1"; ?>"><img  src="images/CONTINUE-SHOPPING.jpg" /> </a>
							<?php 
								} else {
									if ($this->view  == 3) {
										echo "<div id = 'db_cart_page_center'> ";
											$this->pageFooter($page);
										echo "</div>";
										} else $this->pageFooter($page);
														
								} ?>
						</td>
						<?php    if ($this->view != 3) { ?>
						<td valign="bottom" align="right">
							<?php
								if ($this->view!=1)
									{ ?>
										<a style="padding-right:10px;" href="<?php echo $_SERVER['PHP_SELF']; ?>?action=checkout"><img src="images/CHECKOUT.jpg" /></a>
									<?php } else { ?>
										<a style="padding-right:10px;" href="<?php echo $_SERVER['PHP_SELF']; ?>?action=checkout">Checkout&raquo;</a>
									<?php } ?>
						</td>
					<?php } ?>

					</tr>	
				</table>
		</td>
	</tr>
	<?php
	}
	
	
	function base64_to_jpeg( $imageData, $outputfile ) { 
		/* encode & write data (binary) */ 
		  $ifp = fopen( $outputfile, "wb" ); 
		  fwrite( $ifp, ( $imageData ) ); 
		  fclose( $ifp ); 
		  /* return output filename */ 
		  return( $outputfile ); 
		} 

   function showRightview($rows)
	 {
	 	$browser = GetBrowser();
	//	if ($browser[0] == 6) 
		if ( $browser [0] == 6 || ($browser[0]==5 && $browser[1]=='7.0'))
			echo "<table style='margin-left:0;'  align='left' border='0' cellpadding='0' cellspacing='0' width='100%'>"; 
		else
			echo "<table  align='left' border='0' cellpadding='0' cellspacing='0' width='100%'>"; 
		$perc = 100 / $this->cols;
		$x= $this->cols + 1;		
		?>
			<tr >
						<td  width="100%" align="center" height="30px	">
							<p class="title"> You may <br> also want </p>
						</td>
					</tr>

		<?php
		while ($row = mysql_fetch_object($rows)) 	{
		
		if ($x==$this->cols + 1)
			{
			$x=1;
			echo "<tr>";
				}
			 echo "<td width='100%' >"; 
			?>
            
			<table   align="left" border="0" cellpadding="0" cellspacing="0">
			
			<form action="<?php echo CONTINUE_SCRIPT; ?>" method="post">
    					
					<tr >
						<td width="100%"  align="center" >
					<?php  //$imageData = $row->Small;
							//$this->base64_to_jpeg( $imageData, $row->ProductID.".jpg" )?>
							  <a href="db_cart_main.php?view=2&item=<?php echo $row->ProductID; ?>"> <img  style="margin-top:10px; margin-left:5px; margin-right:5px;"  height="100px" src="/images/150H/<?php echo $row->ProductID.'.jpg';?>" /> </a>
						</td>
					</tr>	
					
					<tr>
						<td   width="100%" align="center">
							<p class="divider">
				    		<span style="padding-left:2.5px; padding-right:2.5px; text-align: justify;  font-size:9px;" for="prod_<?php echo $row->ProductID; ?>">
							 <a href="db_cart_main.php?view=2&item=<?php echo $row->ProductID; ?>"><b><?php echo $row->ProductID.'. ' ; ?></b><?php echo $row->Name_Eng; ?> </a> 
							</span>
							</p>
						</td>
	  				</tr>
					
					<tr>
						<td  width="100%" align="center">
							<font size="0">
																		<?php 
									if ($row->old_price > 0 ) {
										echo "Price: "."<font style=\"text-decoration: line-through;\">".$_SESSION['myCart']->format_value($row->old_price)."</font><br>"; 
										echo  "  "."<font color='#FF0000'>"."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"."</font>"; }
									else
										echo "Price: "."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>"; 
									
									
							?>

							 <?php /*echo "Price: "."<b>".$_SESSION['myCart']->format_value($row->Price)."</b>";*/ ?> </font>
						</td>
	  				</tr>
										
	 				 		<input type="hidden" name="price" value="<?php echo $row->Price; ?>">
					  		<input type="hidden" name="art_no" value="<?php echo $row->ProductID; ?>">
					  		<input type="hidden" name="product" value="<?php echo escape_string($row->Name_Eng); ?>">
					 <tr>
					</tr>
					
				</form>
			
			</table>
			
              
			  <?php
			  
           
			if ($x==$this->cols + 1)
				{ echo "</tr>";}
			$x+=1;
			echo "</td>";
            
        } 
		
		echo "</table>";
        return;
    } 

    function showItemImg($rows)
	 {
	 
       
		$row = mysql_fetch_object($rows)
		?>
			 	<table  align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center">
										<?php  //$imageData = $row->Small;
												
										//$this->base64_to_jpeg( $imageData, $row->ProductID.".jpg" )?>
							  			<?php echo "<img   height='450px' src=\"/images/400H/".$row->ProductID.'.jpg'. "\" />"; ?>
																																			
								 	</td>
								</tr>
								 <tr>
								 	<td align="center">
										<TR>
												<TD align="center">
												<br />
												<form action="#">
												<div>
												<input type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
												</div>
												</form>
												</TD>
										</TR>

									</td>
								 </tr>
							 </table>
						
		<?php 
        return;
    } 

    function showFeaturedItemImg($rows)
	 {
	 
       
		$row = mysql_fetch_object($rows)
		?>
			 	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				
								<tr valign="bottom">
									<td  align="center">
							  			
										<font size="+4">
										<?php echo "Featured Item"; ?>
										</font>
										<font size="+2">
										<?php echo "<a onclick='javascript:window.close()'  target='_blank' href='http://www.sigfund.com/db_cart_main.php?view=2&item=8851'>Click Here</a>"; ?>
										</font>
																																			
								 	</td>
								</tr>

				
								<tr valign="bottom">
									<td  align="center">
										<?php  //$imageData = $row->Small;
											//http://localhost/db_cart_main.php?view=2&item=113
												
										//$this->base64_to_jpeg( $imageData, $row->ProductID.".jpg" )?>
							  			<?php echo "<a onclick='javascript:window.close()' target='_blank' href='http://www.sigfund.com/db_cart_main.php?view=2&item=8851'><img   height='450px' src=\"/images/400H/".$row->ProductID.'.jpg'. "\" /></a>"; ?>
																																			
								 	</td>
								</tr>
								 <tr valign="bottom">
								 	<td align="center">
										<TR>
												<TD align="center">
												<br />
												<form action="#">
												<div>
												<input type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
												</div>
												</form>
												</TD>
										</TR>

									</td>
								 </tr>
							 </table>
						
		<?php 
        return;
    } 
	


} 

?>
