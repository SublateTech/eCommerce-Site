<?php 
require_once("classes/MySql_class.php");
class leftMenu 
	{
	function leftMenu()
	{
		echo "<link href='css/leftmenu.css' type='text/css' rel='stylesheet'>";
 	    echo "<script language='javascript' src='css/leftmenu.js'></script>";
	}
	function open($title='No title')
		{
		//echo "<table  style='margin-bottom:0; background-attachment: scroll; ' border='0'  cellspacing='0' cellpadding='0' width='100%' height='100%' bgcolor='#EBECF0'>";
		echo "<tr>	<td >";
		
		?>

		
		<div id="extra"> 
				<div  id="sb-module" class="box sb-module">
					<h1><b> <?php echo $title; ?> </b></h1>					
					<b class="cn tl"></b>
    				<b class="cn tr"></b>
				</div>
		</div>
				

		<?php	
		
		
    	echo "<div id='masterdiv'>";
			
		}
	function title($name='')
		{
			echo "<div class='menu' style=\"text-align:left; background-color: '#EBECF0' \">".$name."</div>";	
		}
	function open_menu($name='', $m_submenu='', $href='', $open=false)
		{
			if ($m_submenu!='' && $m_submenu!='')
				{
				if ($open) {
					echo "<div class='menu'  onMouseOver=\"this.style.background='#EBECF0'\" onMouseOut=\"this.style.background='#ffffff'\" onClick=\"SwitchMenu('".$m_submenu."')\">".$name;				echo "</div>";
					echo "<span  style=\"display:block\";  class='options'  id='".$m_submenu."'>";
						}
				else {
					echo "<div class='menu' onMouseOver=\"this.style.background='#EBECF0'\" onMouseOut=\"this.style.background='#ffffff'\" onClick=\"SwitchMenu('".$m_submenu."')\">".$name."</div>";	
					echo "<span class='Options'  id='".$m_submenu."'>";
					
					}
				}
			elseif ($href != '')
				{
				echo "<div class='menu' onMouseOver=\"this.style.background='#EBECF0'\" onMouseOut=\"this.style.background='#ffffff'\" style='text-align:left; '>";
				echo "<a href=".$href." >";
				echo $name."</a>"."</div>";
				}
				
			else
				echo "<div class='menu' onMouseOver=\"this.style.background='#EBECF0'\" onMouseOut=\"this.style.background='#ffffff'\" style='text-align:left; '>".$name."</div>";	
		}
	function close_menu()
		{
			echo "</span>";
		}
	function	add_option($name='', $href='')
		{
			echo "<div class='Option' onMouseOver=\"this.style.background='#EBECF0'\" onMouseOut=\"this.style.background='#ffffff'\">
                <a href='".$href."'>".$name."</a></div>";
		}
	function	close()
		{
		echo "</div>";
		echo "</td></tr>";
   		//echo "</table>";

		}
		
	function get_categories_menu (){
		if (!$this->connection)
			{ die ("Could not connect to the database"); }
		else
			{
			$query1=$this->query("Select * from cart_categories");
			$numrows= $this->numrows($query1);
			$this->open();
			$this->open_menu('Categories:', 'menu3');
			while ($row = $this->fetchrowsobj($query1)) {
   					//echo $row->CategoryID;
   					//echo $row->Short_Name;
					$this->add_option($row->Short_Name,'db_cart_main.php?Under=10');
					}
			$this->close_menu();	
			$this->close();
			$this->free($query1);
			}	

		}
}