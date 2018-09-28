<?php 
//require_once("classes/MySql_class.php");
class topMenu //extends MySql 
	{
	
	var $popup=false;
	
	
	function open($title='No title')
		{
			echo '<script type="text/javascript" src="css/chrome.js"> </script>';
			echo '<link rel="stylesheet" type="text/css" href="css/chromestyle.css" />';

			echo "<table height='20px' width='100%'><tr><td>";
			echo "<div id='chromemenu'>";
			echo "<ul>";
		}
	
	function close()
		{
			echo "</ul>";
			echo "</div>";
			echo "</td></tr></table>";
		}
	
	
	function open_menu($name='', $m_submenu='', $href='', $width=150, $target='')
		{
		
			$target = ($target==''?'':' target="'.$target.'"');
						
			$this->popup=false;
			if ($href == '')
				$href='#';
			
			if ($m_submenu != '') { 
				echo "<li><a href = '".$href."'  onmouseover = \"cssdropdown.dropit(this,event,'".$m_submenu."')\"".$target." >".$name."</a></li>";
				echo "<div id='".$m_submenu."' class='dropmenudiv' style='width:".$width."px; '>";
				$this->popup=true;
				}
			else
				{
				
					echo "<li><a href='".$href."'".$target." >".$name."</a></li>";
				}
		}
	function close_menu()
		{
			if ($this->popup) {
				echo "</div>";
				$this->popup=true; }
			
		}

	function	add_option($name='', $href='', $target='')
		{
			$target = ($target==''?'':' target="').$target.'"';
			echo "<a href='".$href."'".$target." >".$name."</a>";

		}
	
	function add_login()
		{
		?>		
			<ul>
			<td valign="middle" style=" height:25px; background: url(../images/SigTop.gif) bottom repeat-x; "  width="7%">
			<?php if (isset($_SESSION['user'])) { ?>
						
						<a href='db_cart_login.php?action=log_out'>Log out</a> 
								<?php
					}else { ?>
						<div id='cart_logout'> <a href='db_cart_login.php?action=log_in'>Log in</a>  </div>
			<?php		
					} ?>
			 
			</td>
			</ul>
			<ul>
				<td valign="middle" style=" height:25px; background: url(../images/SigTop.gif) bottom repeat-x; "  width="3%">
					<a href='db_cart_checkout_modify.php'><img src="images/cart.gif" /> </a> 
				</td>
			</ul>

			
		<?php
		}
	
	function add_reps_login()
		{
		?>		
			<ul>
			<td valign="middle" style=" font-size:9px; height:25px; background: url(../images/SigTop.gif) bottom repeat-x; "  width="10%">
			<?php if (isset($_SESSION['rep_id'])) { ?>
						
						<div id='cart_logout'><a href='http://www.sigfund.com/db_reps_main.php?logout'>Reps Log out</a> </div>
								<?php
					}else { ?>
						<div id='cart_logout'> <a href='http://www.sigfund.com/db_reps_main.php?login'> Reps Log in</a>  </div>
			<?php		
					} ?>
			 
			</td>
			
			</ul>
		
		<?php
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