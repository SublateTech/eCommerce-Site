<?php 
require_once("db_cart_scroll.php");

class cart_right_menu {
	
	var $line = 4;
	var $page;
	var $sql = SQL;
	var $view = 1;
	var $item;
	
function setitem($item)
{
	$this->item = $item;
}

function cart_right_menu ()
{
		$this->page = 1;
		$this->line = 4;
		
}

function Show($page)
	{	
	$this->page = $page;
	$page_box = new boxstd();


	$page_box->Header(); 


	$conn1 = new Conn;
	$conn1->_server = DB_SERVER;
	$conn1->_user = DB_USER;
	$conn1->_pwd = DB_PASSWORD;
	$conn1->_db = DB_NAME;
	$this->line = 4;

	if (!$this->sql) {
    	$this->sql = $conn->sql;
	} 

	$this->line = 4;
	
	require_once("db_cart_query.php");
	
	$db_sql = new cart_query();

	$sql =  $db_sql->get_query(true);

	/********** this is for rest of right menu *********************************************/		
	$this->sql = $sql;
	
	//echo $this->sql;
	$conn1->connect($this->sql, $this->line); //create an object of split  pass the sql and total no of rows to be displayed in a page
	if ($conn1->errMsg != "") {
    	die($conn1->errMsg);
	} 
	$rows = $conn1->getQuery($this->page);
	$conn1->setview(3);
	$conn1->setcols( 1);
	echo "<div id = 'db_cart_page_center'> ";
		$conn1->pageFooter($this->page);
	echo "</div>";	
	$conn1->showTable($rows, 3);
	$conn1->showFooter($this->page);

	$page_box->Footer(); 
	}

function ShowCenter($page)
{
	$conn = new Conn;
	$conn->_server = DB_SERVER;
	$conn->_user = DB_USER;
	$conn->_pwd = DB_PASSWORD;
	$conn->_db = DB_NAME;
	if ($this->view == 3)
		{
		$this->sql = $_SESSION['last_sql_V2']; 
		}
	if ($this->view == 1)
		$this->line = 9;
	
	$connDB = $conn->connect($this->sql, $this->line); //create an object of split  pass the sql and total no of rows to be displayed in a page
	if ($conn->errMsg != "") {
    	die($conn->errMsg);
		} 
	$rows = $conn->getQuery($page);
	if ($this->view == 2  ||  $this->view == 3 )
		{
		$conn->setview(2);
		$conn->setcols(1);
		$conn->showTable($rows, 2); 
		$this->showMagazine_note();
		$conn->showFooter(1);
		
	} elseif ($this->view == 1)
	 {
		
		$conn->setview($this->view);
		$conn->setcols(3);
		$conn->setitem("");
		
		echo "<div id = 'db_cart_page_right'> ";
			$conn->pageFooter($page);
		echo "</div>";
		?>
		<TABLE CELLSPACING=0 CELLPADDING=0 BORDER=0>
				<FORM NAME='frmSort' METHOD='post' ACTION="db_cart_main.php?sort">
					<TR>
						<TD><IMG SRC="images/spacer.gif" WIDTH=10 HEIGHT=1 BORDER=0>	</TD>
						<TD><FONT CLASS=SearchNavCell NOWRAP>Sort:</FONT></TD>
						<TD ALIGN=center><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=2 BORDER=0></TD>
						<TD> <?PHP
							require_once("db_cart_form_class.php");
							$frobj = new db_cart_form_class(); 
							
							$ar = array('by Item Number','by Name','by Price');
							echo $frobj->add_select_list('select', $_SESSION['frmSort'], $ar, true, false);
							?>
								
						</TD>
						<TD><IMG SRC="images/spacer.gif" WIDTH=8 HEIGHT=1 BORDER=0></TD>
						<TD bgcolor="#EBECF0" VALIGN=BOTTOM><INPUT TYPE=image SRC="images/button_go_T1.gif" BORDER=0 title="submit sort" name="submitsort"></TD>
					</TR>
				</FORM>
		</TABLE>
	<?PHP
		$conn->showTable($rows, $this->view); 
		$this->showMagazine_note();
		$conn->showFooter($page);
		
	} elseif ($this->view == 4)
	 {
		$conn->setview(4);
		$conn->setcols(1);
		$conn->setitem("");
		$conn->showTable($rows, $this->view); 
	} elseif ($this->view == 5)
	 {
		$conn->setview(5);
		$conn->setcols(1);
		$conn->setitem("");
		$conn->showTable($rows, $this->view); 
	}	

	}
	
	function showMagazine_note()
		{
		/*
		if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == 13)
			{
			print "<tr><td><br>"; 
			print '<font style="margin-left:10px; margin-top:10px;" color="#FF0000" size="-4">';
			print "NOTE: All Magazine purchases DO NOT count towards $40.00 shipping incentive.";
			print '</font>';
			print "</td></tr>";
			}*/
		}


}
?>