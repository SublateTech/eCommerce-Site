<?php
Class Conn {
    var $_server; //database server
    var $_user; //database username
    var $_pwd; //database password
    var $_db; //database name
    var $conn;

    var $totalcols; //total no of cols returned by the query
    var $totalrows; //total no of rows returned by the query
    var $maxrow; //total no of rows displayed in a page
    var $sql; //the main query
    var $errMsg;
    var $totalpages;
    var $fieldName;
    var $fieldRequire;
	var $page;
		
	var $array = array();

    function connect($sql, $maxrow)
    {
        
		$this->sql = $sql;
        $this->maxrow = $maxrow;
        if ($this->maxrow <= 0) {
            
			$this->errMsg = "Max results in a page is not a valid entry";
            return;
        } 
		/*
		$this->_user = "signatv9_sa";
		$this->_pwd = "sa";
		$this->_server = "107.104.236.2";
		*/
		$this->conn = mysql_connect($this->_server, $this->_user, $this->_pwd)
			or die("Error: " . mysql_error() . "<br>");
			
        mysql_select_db($this->_db, $this->conn)
        	or die("Error: " . mysql_error() . "<br>");
        
		$result = mysql_query($sql);
        if (!$result) {
            $this->errMsg = "ERROR: " . mysql_error() . "<br>";
            return;
        } 

		
        $fieldCount = mysql_num_fields($result);
        for ($i = 0; $i < $fieldCount; $i++) { 
            $fieldName[$i] = mysql_field_name($result, $i);
        } 
        $this->fieldName = $fieldName; 
        // echo $this -> fieldName[0];
        $this->totalrows = mysql_num_rows($result);
		
        if ($this->totalrows == 0) { // total rows=0
            
			$this->errMsg = " ";
            return;
        } 
        $this->totalcols = mysql_num_fields($result); 
        // Get the number of pages
        $this->totalpages = (int)(($this->totalrows-1) / $this->maxrow + 1);
        return;
    } 

    function getQuery($page) // in this method only the present page to be displayed will be passed
    {
        
		$this->page = $page;
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
	if($this->totalrows	>0)
		{
        $sqlimit = $this->sql . " limit " . $min . "," . $this->maxrow;
        $outputdisplay = mysql_query($sqlimit)or die("ERROR:" . mysql_error());
        if (mysql_num_rows($outputdisplay) == 0) {
            $this->errMsg = "";
            return;
        } else {
				if (mysql_num_rows($outputdisplay) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($outputdisplay)) {
					foreach($row as $key => $val) {
						$this->array[$counter][$key] = $val;
					}
					$counter++;
				}
			} 
				
		
            return $outputdisplay;
        } 
	  }
    } 
    function showTable_messages($rows, $fieldRequire)
    {
		/*
		
				<table  width="100%" border="0">
					<FORM NAME='frmCompany' METHOD='post' ACTION="db_reps_charges.php?company">
					<TR>
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
						<TD ><IMG SRC="images/spacer.gif" WIDTH=150 HEIGHT=1 BORDER=0>	</TD>
						<TD  align="right" width="10%"><FONT CLASS=SearchNavCell NOWRAP>Season:</FONT></TD>
						<TD  colspan="1" ALIGN=right ><IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=2 BORDER=0></TD>
						<TD  > <?PHP
							require_once("db_cart_form_class.php");
							$frobj = new db_cart_form_class(); 
							
							
							require_once("db_reps_class.php");
							$reps = new reps_class();
							//$reps->get_charges_companies($_SESSION['rep_id']);
							$index=0;
							$ar = array();
							foreach ($reps->companies_array as $val_1)  
								{
								$ar[$index] = $val_1['CompanyID'];
								$index++;
								}
							echo $frobj->add_select_list('select', $_SESSION['company_id'], $ar, true, false);
							?>
								
						</TD>
						
				<TD  VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit sort" name="submitsort"></TD>
					</TR>
				</FORM>

					</table>						
			*/			
					//$_SESSION['company_id'] = "S08"; ?>
						
						<table   valign="top" border="0" width="100%" >
						<tr height="8px">
							<td>&nbsp;								
							</td>
						</tr>
						
						 <tr height="8px">
				 			   <th align="Left" height="8px" >Date</th>
								<th align="left">Message</th>
						</tr>
						<?php
						$total =0;
						
						$i=0;
						foreach ($this->array as $val) { 
										
						
						?>
						   
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td  height="8px" width="18%" align="left"><?php print $val['DateTime']?></td>
								<td  width="100px" align="left"><?php print $val['Message'] ?></tD>
						</tr>
						<tr height="1px"></tr>
						<?php 
						        
						 $i++;           
						}

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

    function showTable_tickets($rows)
    {
	
				include("excelwriter.inc.php");
				$excel=new ExcelWriter("myXls.xls");
	
				//print $excel->file;
				
				if($excel==false)	
					echo $excel->error;

		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<FORM NAME=frmDraw METHOD='post' ACTION="db_reps_tickets.php">
						<div id="Menu_1">
					<?php
							include_once("db_reps_tickets_menu.php");
							
					
					//$_SESSION['company_id'] = "S07"; ?>
						</div>
						</FORM>
					
					
						
						<table   valign="top" border="0" width="100%" >
						
						<tr height="8px">
							<td colspan="5">&nbsp;								
							</td>
						</tr>
						
						 		
						
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
								
							$myArr=array('Teacher','Student','Nro_Items');
							$excel->writeLine($myArr);

								
						?> 						
						
						 <tr height="4px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_reps_tickets.php?Sort=Teacher">Teacher </a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Student") print $image;?><a href="db_reps_tickets.php?Sort=Student">Student</a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Nro_Items") print $image;?><a href="db_reps_tickets.php?Sort=Nro_Items">No Items</a></th>
								
						</tr>
	
						<?php
						if (isset($_POST['Customer']) || isset($_REQUEST['Sort']))
						{
						$total =0;
						
						$i=0;
						foreach ($this->array as $val) { 
										
						
						?>
						 
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td  height="8px"  align="left"><?php print $val['Teacher']?></td>
								<td   align="left"><?php print $val['Student'] ?></tD>
								<td  width="100px" align="left"><?php print $val['NoItems'] ?></tD>
								
						</tr>
						<?php //<tr height="1px"></tr> ?>
						
						<?php 
							$myArr=array($val['Teacher'],$val['Student'],(int) $val['NoItems']/1+0);
							$excel->writeLine($myArr);

						        
						 $i++;           
						}

						
						
						
						$excel->close();
						}

						?>
						<tr>
							<td colspan="4">
								<b><a href="<? print $excel->file ?>">Download Excel Version</a></b>
							</td>
						</tr>
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

    function showTable_chair_tickets($rows)
    {
	
				include("excelwriter.inc.php");
				$excel=new ExcelWriter("myXls.xls");
	
				//print $excel->file;
				
				if($excel==false)	
					echo $excel->error;

		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php print "<b><p style='text-align:left'>"."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
					</table>
					
						
						<table   valign="top" border="0" width="100%" >
						
						<tr height="8px">
							<td colspan="5">&nbsp;								
							</td>
						</tr>
						
						 		
						
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
								
							$myArr=array('Teacher','Student','Nro_Items');
							$excel->writeLine($myArr);

								
						?> 						
						
						 <tr height="4px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_chair_tickets.php?Sort=Teacher">Teacher </a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Student") print $image;?><a href="db_chair_tickets.php?Sort=Student">Student</a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Nro_Items") print $image;?><a href="db_chair_tickets.php?Sort=Nro_Items">No Items</a></th>
								
						</tr>
	
						<?php
						if (isset($_SESSION['Customer']) || isset($_REQUEST['Sort']))
						{
						$total =0;
						
						$i=0;
						foreach ($this->array as $val) { 
										
						
						?>
						 
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td  height="8px"  align="left"><?php print $val['Teacher']?></td>
								<td   align="left"><?php print $val['Student'] ?></tD>
								<td  width="100px" align="left"><?php print $val['NoItems'] ?></tD>
								
						</tr>
						<?php //<tr height="1px"></tr> ?>
						
						<?php 
							$myArr=array($val['Teacher'],$val['Student'],(int) $val['NoItems']/1+0);
							$excel->writeLine($myArr);

						        
						 $i++;           
						}

						
						
						
						$excel->close();
						}

						?>
						<tr>
							<td colspan="4">
								<b><a href="<? print $excel->file ?>">Download Excel Version</a></b>
							</td>
						</tr>
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 


    function showTable_reps_ranking_classes($rows)
    {
		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<FORM NAME=frmDraw METHOD='post' ACTION="db_reps_ranking_classes.php">
						<div id="Menu_1">
							<?php	include_once("db_reps_ranking_classes_ajax.php");
							
							//$_SESSION['company_id'] = "S07"; ?>
						</div>
						</FORM>
					
					
						
						<table   valign="top" border="0" width="100%" >
						
						<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
						
						 		
						
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
						?> 						
						
						<tr height="5px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_reps_ranking_classes.php?Sort=Teacher">Teacher </a></th>
								<th align="left"></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Nro_Items") print $image;?><a href="db_reps_ranking_classes.php?Sort=Nro_Items">No Items</a></th>
								<?php //<th align="left">Amount</th> ?>
						</tr>
	
						<?php
						if (isset($_POST['Customer']) || isset($_REQUEST['Sort']))
						{
						$total =0;
						
						$i=0;
						
						foreach ($this->array as $val) { 
							
						
						?>
						 
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td  height="8px"  align="left"><?php print $val['Teacher']?></td>
								<td   align="left"></tD>
								<td  width="100px" align="left"><?php print $val['Nro_Items'] ?></tD>
								<?php /*<td  width="100px" align="Right"><?php print $this->format_value($val['retail'],true) ?></tD> */ ?>
								
						</tr>
						<tr height="1px"></tr>
						<?php 
						        
						 $i++;           
						}
						}

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 
	
	function showTable_reps_internet_orders($rows)
    {
		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<FORM NAME=frmDraw METHOD='post' ACTION="db_reps_internet_orders.php">
						<div id="Menu_1">
							<?php	include_once("db_reps_internet_orders_ajax.php");
							
							//$_SESSION['company_id'] = "S07"; ?>
						</div>
						</FORM>
					
					
						
						<table   valign="top" border="0" width="100%" >
						
						<tr height="8px">
							<td colspan="4">&nbsp;								
							</td>
						</tr>
						
						 		
						
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
						?> 						
						
						<tr height="5px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_reps_internet_orders.php?Sort=Student">Student </a></th>
								<th  align="right" width="20%" align="left"><?php if ($_SESSION['Sort']=="Retail") print $image;?><a href="db_reps_internet_orders.php?Sort=Retail">Retail </a></th>
								<th   align="10%" </th>
								<th align="left"><?php if ($_SESSION['Sort']=="Items") print $image;?><a href="db_reps_internet_orders.php?Sort=Nro_Items">No Items</a></th>
								<?php //<th align="left">Amount</th> ?>
						</tr>
	
						<?php
						if (isset($_POST['Customer']) || isset($_REQUEST['Sort']))
						{
						$total =0;
						
						$i=0;
						
						foreach ($this->array as $val) { 
							
						
						?>
						 
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td  width="40%" height="8px"  align="left"><?php print $val['Student']?></td>
								<td   align="Right"><?php print $this->format_value($val['Retail'],true) ?></tD>
								<td></td>
								<td  width="100px" align="center"><?php print $val['Items'] ?></tD>
								<?php /*<td  width="100px" align="Right"><?php print $this->format_value($val['retail'],true) ?></tD> */ ?>
								
						</tr>
						<tr height="1px"></tr>
						<?php 
						        
						 $i++;           
						}
						}

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

    function showTable_charges($rows, $fieldRequire)
    {
	?>
				<table  width="100%" border="0">
					<FORM NAME='frmCompany' METHOD='post' ACTION="db_reps_charges.php?company">
					<TR>
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
						<TD ><IMG SRC="images/spacer.gif" WIDTH=150 HEIGHT=1 BORDER=0>	</TD>
						<TD  align="right" width="10%"><FONT CLASS=SearchNavCell NOWRAP>Season:</FONT></TD>
						<TD  colspan="1" ALIGN=right ><IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=2 BORDER=0></TD>
						<TD  > <?PHP
							require_once("db_cart_form_class.php");
							$frobj = new db_cart_form_class(); 
							
							
							require_once("db_reps_class.php");
							$reps = new reps_class();
							$reps->get_charges_companies($_SESSION['rep_id']);
							$index=0;
							$ar = array();
							foreach ($reps->companies_array as $val_1)  
								{
								$ar[$index] = $val_1['CompanyID'];
								$index++;
								}
							echo $frobj->add_select_list('select', $_SESSION['company_id'], $ar, true, false);
							?>
								
						</TD>
						
				<TD  VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit sort" name="submitsort"></TD>
					</TR>
				</FORM>

					</table>						
						
						<table   valign="top" border="0" width="100%" >
						<tr height="8px">
							<td>&nbsp;								
							</td>
						</tr>
						
						 <tr height="8px">
				 			   <th align="center" height="8px" >Date</th>
				    			<th align="left"></th>
								<th align="left">Description</th>
								<th align="right">&nbsp;</th>
								<th align="center">Charge</th>
						</tr>
						<?php
						$total =0;
						
						$i=0;
						foreach ($this->array as $val) { 
						
						$total += $val['Charge'];
						
						
						?>
						   
						 <tr  height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td   height="10px" width="80px" align="center"><?php print $val['Date']?></td>
								<td  width="100px" align="center"><?php print $val['Description']?></td>
								<tD  width="220px" align="left"><?php print $val['Description_1'] ?></tD>
								<tD  width="220px" align="left"><?php print $val['Description_2'] ?></tD>
								<tD  width="80px" align="right"><?php print $this->format_value($val['Charge'],true) ?></tD>
						</tr>
						<tr height="1px"></tr>
						<?php 
						        
						 $i++;           
						}
						
						if (isset($_REQUEST['range']) && $_REQUEST['range']=="All")
						{
						?>	
												
						<tr bgcolor="<?php print $this->row_color($i)?>" >
				 			    
				    			
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td ><b>Total:</b></td>
								<td align="right" ></td>
								<td align="right"><b><?php print $this->format_value($total,true); ?></b></td>
						</tr>
						<?php
							}
						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

    function showTable_sales($rows, $fieldRequire)
    {
    /*    echo "<table border='1'><tr>"; 
        // echo "show field:".$fieldRequire."<br>";
        $this->fieldRequire = $fieldRequire;
        if ($fieldRequire) {
            foreach($this->fieldName as $name) {
                echo "<th>" . $name . "</th>";
            } 
            echo "</tr>";
        } while ($row = mysql_fetch_row($rows)) {
            // print the results over here
            for($i = 0;$i < $this->totalcols;$i++) {
                echo "<td>" . "$row[$i]" . "</td>";
            } 
            echo "</tr>";
        } 
        echo "</table>";*/
		
	/*	<table style="margin-top:30px"  border="0"	 width="100%" bgcolor="#FFFFFF"> 
					<tr>
					<td height="41"  colspan="4">
					<div id='center_title'>
					<font size="+1">  Reps Area</font>
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
				      <td width="88%"  align = "CENTER"  valign="top"> */ ?>
						<?php //echo "<b>Page No: " . $this->page . "</b>"; ?>
						
						

				<table  width="100%" border="0">
					<FORM NAME='frmCompany' METHOD='post' ACTION="db_reps_sales.php?company">
					<TR>
						<TD width="50%"> <?php print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
						<TD ><IMG SRC="images/spacer.gif" WIDTH=150 HEIGHT=1 BORDER=0>	</TD>
						<TD  align="right" width="10%"><FONT CLASS=SearchNavCell NOWRAP>Season:</FONT></TD>
						<TD  colspan="1" ALIGN=right ><IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=2 BORDER=0></TD>
						<TD  > <?PHP
							require_once("db_cart_form_class.php");
							$frobj = new db_cart_form_class(); 
							
							
							require_once("db_reps_class.php");
							$reps = new reps_class();
							$reps->get_sales_companies($_SESSION['rep_id']);
							$index=0;
							$ar = array();
							foreach ($reps->companies_array as $val_1)  
								{
								$ar[$index] = $val_1['CompanyID'];
								$index++;
								}
							echo $frobj->add_select_list('select', $_SESSION['company_id'], $ar, true, false);
							?>
								
						</TD>
						
						<TD  VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit sort" name="submitsort"></TD>
					</TR>
				</FORM>

					</table>						
						
						<table   valign="top" border="0" width="100%" >
						<tr height="8px">
							<td>&nbsp;
								
							</td>
						</tr>
						
						 <tr height="8px">
				 			   <th  height="23"></th>
				    			<th align="left" width="140px">&nbsp;</th>
								<th align="left" >&nbsp;</th>
								<th align="right"  width="120px">&nbsp;</th>
								<th align="right">&nbsp;</th>
								<th align="right"  width="120px">Signed</th>
								<th>Actual</th>
								<th></th>
								<th>CODE123</th>
						</tr>
						<?php
						$retail =0;
						$signed = 0;
						$sellers =0;
						$units=0;

						$CODE1=0;
						$CODE2=0;
						$CODE3=0;
						
						$Retail1 = 0;
						$Retail2 = 0;
						$Retail3 = 0;
						
						$i=0;
						
						$LastCustomer = "";
						foreach ($this->array as $val) { 
							
							
						
						   if ($LastCustomer != $val['CustomerID'])
						   	  {
							  
		  				    $retail += $val['Retail'];
							$signed += $val['Signed'];
							$sellers +=$val['NoSellers'];
							$units += $val['NoItems'];
							  
							  if ($i==0)
							  {
						    ?>
								<tr bgcolor="<?php print $this->row_color($i)?>">
					 			   <td  colspan="9" >&nbsp;</td>
								</tr>
								<tr height="1px"></tr>
							
							<?php
								}
							$i++;           
						   ?>
						 	<tr align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			    <td colspan="4" ><b><?php print $val['CustomerID']." ".$val['Name'] ?></b></td>
								<td  colspan="1" >Due:</td>
				    			<td align="left"></td>
								<tD align="right"><b><?php print $this->format_value($val['AmountDue'],true); ?></b></tD>
								<td colspan="2" align="left"></td>
							</tr>
							
							<tr bgcolor="<?php print $this->row_color($i)?>">
				 			   <td align="left" colspan="2" ><?php print $val['Address'] ?></td>
							   <td align="left" colspan="1" >Prize:</td>
							   <td align="left" colspan="5" ><?php print $val['Prize_Description'] ?></td>
							   <td >&nbsp;</td>
							</tr>
							
						 	<tr  align="left" bgcolor="<?php print $this->row_color($i)?>" >
				 			    <td width="15%" ><?php print $val['City'] ?></td>
				    			<td ><?php print $val['ChairPerson'] ?></td>
								<td >Signed:</td>
								<td ><?php print $val['SignedDate'] ?></td>
								<td >UNITS:</td>
								<td align="right" ></td>
								<td align="right"><?php print $val['NoItems'] ?></td>
								<td ></td>
								<td ></td>
							</tr>
						 	<tr  align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			   <td  ><?php print $val['State'].",". $val['ZipCode']?></td>
				    			<td ></td>
								<td >Start:</td>
								<td ><?php print $val['StartDate'] ?></td>
								<td >Sellers:</td>
								<td  align="right"><?php print $val['Signed'] ?></td>
								<td align="right"><?php print $val['NoSellers'] ?></td>
								<? /*
								<td  align="right"><?php print $val['ProfitPercent']."%" ?></td>
								<td  align="right"><?php print $val['ProfitBrochure_2']."%" ?></td> */?>
								<td ></td>
								<td ></td>


							</tr>
						 	<tr  align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			   <td  ><?php print $this->cv_phone($val['HeadPhone']) ?></td>
				    			<td ><?php print $this->cv_phone($val['PhoneNumber']) ?></td>
								<td >End:</td>
								<td ><?php print $val['EndDate'] ?></td>
								<td >Retail:</td>
								<td ></td>
								<td  align="right"><?php print $this->format_value(round($val['c_Retail'],2),true) ?></td>
								<td ></td>
								<td ></td>
								
							</tr>
							<tr  align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			   <td  ></td>
				    			<td ></td>
								<td >PickUp:</td>
								<td ><?php print $val['PickUpDate'] ?></td>
								<td ><font size="-5">Ave Retail/Sell.:</font></td>
								<td ></td>
								<td  align="right"><?php print $this->format_value(round($val['Avg_Retail'],2),true) ?></td>
								<td align="right"></td>
								<td align="right"></td>

							</tr>
							<tr  align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			   <td  ></td>
				    			<td ></td>
								<td >Delivery:</td>
								<td ><?php print $val['DeliveryDate'] ?></td>
								<td ><font size="-5">Ave Units/Sell.:</font></td>
								<td ></td>
								<td align="right"><?php print round($val['Av_Units'],0) ?></td>
								<td align="right"></td>
								<td align="right"></td>


							</tr>
							<?php
								}
							?>
							
							
							<tr  align="left" bgcolor="<?php print $this->row_color($i)?>">
				 			   	<td  ></td>
				    			<td ></td>
								<td ><?php $LastCustomer != $val['CustomerID']? print "Brochure:":print ""; ?></td>
								<td colspan="3" ><?php print $val['Description']; ?></td>
								<td align="right"><?php print $this->format_value($val['Retail'],true); ?></td>
								<td align="right"><?php print $this->format_value($val['Retail']*(1-$val['ProfitPercent']/100),true) ?></td>
								<td align="right"><?php print $this->format_value($val['Retail']*(1-$val['ProfitPercent']/100)*($val['CODE']/100),true) ?></td>

							</tr>
							
				
							<?php
								
								if ($val['CODE'] >0 ) 
							  		$Retail1   += $val['Retail']*(1-$val['ProfitPercent']/100);
							 		$CODE1+= $val['Retail']*(1-$val['ProfitPercent']/100)*($val['CODE']/100);
							 	?>
	 							
								<?php
						 		 $LastCustomer = $val['CustomerID'];
						}
						
						if (isset($_REQUEST['range']) && $_REQUEST['range']=="All")
						{
						?>	
												
						<tr bgcolor="<?php print $this->row_color($i)?>" >
								<td ><b>TOTAL UNITS:</b></td>
								<td align="right" ></td>
								<td align="right"><b><?php print $units ?></b></td>
				 			    <td >&nbsp;</td>
				    			<td >&nbsp;</td>
								<td ><b>Total Invoice:</b></td>
								<td align="right"><b><?php print $Retail1 ?></b></td>
								<td ><b>CODE1:</b></td>
								<td align="right"><b><?php print $CODE1 ?></b></td>


						</tr>
						 <tr bgcolor="<?php print $this->row_color($i)?>">
								<td ><b>Total Sellers:</b></td>
								<td  align="right"><b><?php print $signed ?></b></td>
								<td align="right"><b><?php print $sellers ?></b></td>
				 			   <td  >&nbsp;</td>
				    			<td >&nbsp;</td>
								<td ><b>Total Invoice:</b></td>
								<td align="right"><b><?php print $Retail2 ?></b></td>
								<td ><b>CODE2:</b></td>
								<td align="right"><b><?php print $CODE2 ?></b></td>

	
						</tr>
						 <tr bgcolor="<?php print $this->row_color($i)?>">
								<td ><b>Total Retail:</b></td>
								<td ></td>
								<td align="right"><b><?php print $this->format_value($retail,true) ?></b></td>
				 			   <td  >&nbsp;</td>
				    			<td >&nbsp;</td>
								<td ><b>Total Invoice:</b></td>
								<td align="right"><b><?php print $Retail3 ?></b></td>
								<td ><b>CODE3:</b></td>
								<td align="right"><b><?php print $CODE3 ?></b></td>

	
						</tr>
						<?php
							}
						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 
	
	function cv_phone($phone)
	{
		if (strlen($phone)==10)
			{
			$phone = "(".substr($phone,0,3).") ".substr($phone,3,3)."-".substr($phone,6,4);
					
			}
		if (trim(strlen($phone))==7)
			{
			$phone = substr($phone,0,3)."-".substr($phone,3,4);
			}

		return $phone;
	
	}

	// format a decimal number into an euro amount 
	// $encoding is used for the browser and 
	function format_value($value, $encoding = true) {
		if ($encoding) {
			$curr = (ord(CURRENCY) == "128") ? "&#8364;" : htmlentities(CURRENCY);
		} else {
			$curr= CURRENCY;
		}
		$formatted = $curr."".number_format($value, 2, ".", ",");
		return $formatted;
	}
    function pageFooter($page, $script='db_reps_sales.php')
    {
        $rem = 0 ;
			if ($page == $this->totalpages)
				$rem = $this->totalrows - (int) $this->totalpages * $this->maxrow; 
			if (isset($_REQUEST['range']) && $_REQUEST['range'] == "All" )
				echo "<a href=".$script."?&range=Pages" .  "><b style=\"padding-left:10px;\" >View Pages</b></a>";					
			else
				echo "<a href=".$script."?&range=All" .  "><b style=\"padding-left:10px;\" >View All</b></a>";					
			echo " | ".(($page-1) * ($this->maxrow) + 1)." - ". (((($page-1) * ($this->maxrow) + 1) + $this->maxrow - 1) + $rem)."". " of ".$this->totalrows. " | ";
			echo "Page: <b>".$page."</b> | ";
		
		$line = $this->maxrow;
        if (($page == "") || ($page <= "0")) { // first page
            $page = 1;
        } 
        if ($page > $this->totalpages) { // stop at last page
            $page = $this->totalpages;
        } 
        if ($page > 1) { // insert the back link
            $backpage = $page-1;
            echo "<a href=".$script."?page=$backpage" . SID . ">Back</a>&nbsp;&nbsp;" ;
        } 
        for($j = 1;$j <= $this->totalpages;$j++) { // insert the page links
            if ($j == $page) {
                echo $j . "&nbsp;&nbsp;";
            } else {
                echo "<a href=".$script."?page=$j" . SID . ">" . $j . "</a>&nbsp;&nbsp;" ;
            } 
        } 
        if ($page < $this->totalpages) { // insert the next link
            $nextpage = $page + 1;
            echo "<a href=".$script."?page=$nextpage" . SID . ">Next</a>&nbsp;&nbsp;" ;
        } 
        return;
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
	    function showTable_ranking($rows)
    		{
		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php //print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="5">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<table   valign="top" border="0" width="100%" >
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
								
							
								
						?> 						
						
						 <tr height="5px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_chair_ranking.php?Sort=Teacher">Teacher </a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Student") print $image;?><a href="db_chair_ranking.php?Sort=Student">Student</a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Nro_Items") print $image;?><a href="db_chair_ranking.php?Sort=Nro_Items">No Items</a></th>
								<?php //<th align="left">Amount</th> ?>
						</tr>
						
						
	
						
						<?php
						if (isset($_SESSION['Customer']))
						{
						$subtotal =0;
						$i=0;
  					   if (count($this->array)>0)
								 $teacher = $this->array[0]['Teacher'];

						foreach ($this->array as $val) { 
						
							if ($_SESSION['Sort']=="Teacher")
							    {
								if ($teacher != $val['Teacher'])
									{
									?>
										<tr bgcolor="#AAAAAA">
										<td align="left" colspan="1"><b><?php print $teacher; ?></b></td>
										<td  align="Right" colspan="1"><b><?php print "Subtotal : "; ?></b></td>
										<td  align="right" colspan="1"><b><?php print $subtotal;?></b></td>
										</tr>
									<?php
									$teacher = $val['Teacher'];
									$subtotal = 0;
									}
								}
						
							$subtotal += $val['NoItems'];
						?>
						 	<tr style=" cursor:pointer;" height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>"  onMouseOver="this.style.background='#BBBBBB'" onMouseOut="this.style.background='<?php print $this->row_color($i)?>'" onclick="jsphp_expand('<?php print $val['ID']?>','db_chair_ajax.php','action=1&ID=<?php print $val['ID']?>&Teacher=<?php print $val['Teacher'];?>&Student=<?php print $val['Student'];?>');" >
								<td > <?php print $val['Teacher']?></td>
								<td   align="left" ><?php print $val['Student'] ?></tD>
								<td  width="100px" align="left"><?php print $val['NoItems'] ?></tD>
							</tr>
							<tr height="1px">
								<td colspan="3"><div id="<?php print $val['ID']?>" class="switchcontent" style="display:none"></div></td>
							</tr>
						
						
						<?php 
						 $i++;           
						}
									?>
										<tr   bgcolor="#AAAAAA" >
										<td align="left" colspan="1"><b><?php print $_SESSION['Sort']=="Teacher"?$teacher:""; ?></b></td>
										<td  align="Right" colspan="1"><b><?php print $_SESSION['Sort']=="Teacher"?"Subtotal : ":"Total : "; ?></b></td>
										<td  align="right" colspan="1"><b><?php print $subtotal;?></b></td>
										</tr>
									<?php
						
						
						}

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

	    function showTable_internet_orders($rows)
    		{
		
		?>
					
					<table   border="0"  width="100%">
					<tr >
						<TD width="50%"> <?php //print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="5">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<table   valign="top" border="0" width="100%" >
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
								
							
								
						?> 						
						
						 <tr height="5px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Student") print $image;?><a href="db_chair_internet_orders.php?Sort=Student">Student</a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Retail") print $image;?><a href="db_chair_internet_orders.php?Sort=Retail">Retail</a></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Items") print $image;?><a href="db_chair_internet_orders.php?Sort=Items">No Items</a></th>
								<?php //<th align="left">Amount</th> ?>
						</tr>
						
						
	
						
						<?php
						if (isset($_SESSION['Customer']))
						{
						$subtotal =0;
						$retail = 0;
						$i=0;
  					   if (count($this->array)>0)
								 $teacher = $this->array[0]['Student'];

						foreach ($this->array as $val) { 
						
						
							$subtotal += $val['Items'];
							$retail += $val['Retail'];
						?>
						 	<tr style=" cursor:pointer;" height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>"  onMouseOver="this.style.background='#BBBBBB'" onMouseOut="this.style.background='<?php print $this->row_color($i)?>'" onclick="jsphp_expand('<?php print $val['ID']?>','db_chair_ajax.php','action=1&ID=<?php print $val['ID']?>&Teacher=<?php print $val['Teacher'];?>&Student=<?php print $val['Student'];?>');" >
								<td > <?php print $val['Student']?></td>
								<td   align="left" ><?php print $this->format_value($val['Retail'],true) ?></tD>
								<td  width="100px" align="left"><?php print $val['Items'] ?></tD>
							</tr>
							<tr height="1px">
								<td colspan="3"><div id="<?php print $val['ID']?>" class="switchcontent" style="display:none"></div></td>
							</tr>
						
						
						<?php 
						 $i++;           
						}
									?>
										<tr   bgcolor="#AAAAAA" >
										<td align="left" colspan="1"><b><?php print "Total:"; ?></b></td>
										<td  align="left" colspan="1"><b><?php print $this->format_value($retail,true);?></b></td>
										<td  align="left" width="100px" colspan="1"><b><?php print $subtotal;?></b></td>
										</tr>
									<?php
						
						
						}

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
        return;
    } 

    function showTable_ranking_classes($rows)
    		{
			
				include("excelwriter.inc.php");
				$excel=new ExcelWriter("myXls.xls");
	
				//print $excel->file;
				
				if($excel==false)	
					echo $excel->error;
		
		?>
					
					<table    width="100%">
					<tr >
						<TD width="50%"> <?php //print "<b><p style='text-align:left'>".$_SESSION['rep_name']."</p></b>"; ?></TD>
					</tr>
					<tr height="8px">
							<td colspan="5">&nbsp;								
							</td>
						</tr>
					</table>
					
					
						
						<table   valign="top" border="0" width="100%" >
						<?php 
							if ($_SESSION['Order']=="ASC")
								$image = "<img src=images/sort_"."ascending".".gif />";
							else
								$image = "<img src=images/sort_"."descending".".gif />";
								
							
								
						?> 						
						
						 <tr height="5px">
				 			   <th align="Left" height="5px" ><?php if ($_SESSION['Sort']=="Teacher") print $image;?><a href="db_chair_ranking_classes.php?Sort=Teacher">Teacher </a></th>
								<th align="left"></th>
								<th align="left"><?php if ($_SESSION['Sort']=="Nro_Items") print $image;?><a href="db_chair_ranking_classes.php?Sort=Nro_Items">No Items</a></th>
								<?php //<th align="left">Amount</th> ?>
						</tr>
						
						
						
						<?php
							$myArr=array("Teacher","No Items");
							$excel->writeLine($myArr);

						
						
						
						if (isset($_SESSION['Customer']))
						{
						$subtotal =0;
						$i=0;
  					   if (count($this->array)>0)
								 $teacher = $this->array[0]['Teacher'];

						foreach ($this->array as $val) { 
						
						
							$subtotal += $val['Nro_Items'];
						?>
						 	<tr style=" cursor:pointer;" height="10px" align="left" bgcolor="<?php print $this->row_color($i)?>"  >
								<td > <?php print $val['Teacher']?></td>
								<td   align="left" ></tD>
								<td  width="100px" align="left"><?php print $val['Nro_Items'] ?></tD>
							</tr>
							<tr height="1px">
								<td colspan="3"><div id="<?php print $val['ID']?>" class="switchcontent" style="display:none"></div></td>
							</tr>
						
						<?php 
						
							$myArr=array($val['Teacher'],$val['Nro_Items']);
							$excel->writeLine($myArr);

						 $i++;           
						}
									?>
										<tr   bgcolor="#AAAAAA" >
										<td align="left" colspan="1"><b><a href="<? print $excel->file ?>">Download Excel Version</a></b></td>
										<td  align="Right" colspan="1"><b><?php print $_SESSION['Sort']=="Teacher"?"Total : ":"Total : "; ?></b></td>
										<td  align="right" colspan="1"><b><?php print $subtotal;?></b></td>
										</tr>
									<?php
								
								$myArr=array("","");
								$excel->writeLine($myArr);

								$myArr=array("Total:",$subtotal);
								$excel->writeLine($myArr);
							

						}
						

						?>
			
						</table><br><br>
						<? /*
					  </td>
  				</tr>
			    <tr valign="bottom">
					  <td height="32"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
		</table> */?>
		<?php
		if ($excel->close()==false)
			echo $excel->error;
        return;
    } 

} 

?>
