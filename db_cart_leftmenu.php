<?php 

require_once("db_cart_leftmenu_Class.php");
?>


<table style="margin-left:2; margin-top:0; padding-top:0;" border='0'  bgcolor="#ffffff" cellpadding='0' cellspacing='0' width='100%' height='100%'>

			<?php 
			$menu = new leftMenu();
			if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '4')
				{
				?>
				<tr>
					<td valign='top'>
				<?php
					
					$menu->open("Fall Catalog");
					if (isset($_REQUEST['category']))
						$menu->open_menu('Category', 'menu2','',true);
					else					
						$menu->open_menu('Category', 'menu2','',false);
						$menu->add_option('Home Decor','db_cart_main.php?category=1');
						$menu->add_option('Kitchen Gadgets','db_cart_main.php?category=2');
						$menu->add_option('Bath & Body','db_cart_main.php?category=3');
						$menu->add_option('Specialty Items', 'db_cart_main.php?category=4');
						$menu->add_option('Candles & Fragancies', 'db_cart_main.php?category=5');
						$menu->add_option('Address Books & Organizers', 'db_cart_main.php?category=6');
						$menu->add_option('Gourmet Foods & Chocolates', 'db_cart_main.php?category=7');
						$menu->add_option('All', 'db_cart_main.php?category=All');
						
					$menu->close_menu();
					if (isset($_REQUEST['Under']))	
						$menu->open_menu('Prices', 'menu1','',true);
					else $menu->open_menu('Prices', 'menu1','',false);
						$menu->add_option('Under $10','db_cart_main.php?Under=10');
						$menu->add_option('$10 - $15','db_cart_main.php?Under=15');
						$menu->add_option('$15 - $20','db_cart_main.php?Under=20');
						$menu->add_option('$20 +', 'db_cart_main.php?Under=20+');
						$menu->add_option('View All', 'db_cart_main.php?Under=All');
					$menu->close_menu();	
					$menu->close(); 
					
					?>	
						</td>
					</tr>
					<tr>
						<td bgcolor="#FFFFFF" height="20px">
						</td>
					</tr>
					<?php

				  } 
						
			?>
		<tr>
			<td>

			<?php 
			// Menus Catalogs
			
			if (!isset($_SESSION['brochure']))
				$brochure = 0;
			else
				$brochure = $_SESSION['brochure'];
			
			$menu->open("Catalogs");
			if ($brochure != '4')
				{
					$menu->open_menu('Spring 09','','db_cart_main.php?Brochure=4');  
				}
			if ($brochure != '11')
				{
					$menu->open_menu('Expressions Collection','','db_cart_main.php?Brochure=11');
				}

			$menu->open_menu('WEB Exclusives');
			$menu->open_menu('Magazines');
			$menu->close();  
				
			?>
			
		</td>
	</tr>
	 <tr>
	 	<td align='center' valign='bottom'>
	 		<div id="cilgat" style="z-index:100;position:absolute"></div>
	 		<div id="sclgat" style="display:inline"></div>
	 		<div id="sdlgat" style="display:none"></div>
	 		<script type="text/javascript">var selgat=document.createElement("script");selgat.type="text/javascript";selgat.defer=true;selgat.src=(location.protocol.indexOf("https")==0?			"https://secure.providesupport.com/image":"http://image.providesupport.com")+"/js/signature/safe-standard.js?ps_h=lgat\u0026ps_t="+new Date().getTime();document.getElementById("sdlgat").appendChild(selgat)</script><noscript><div style="display:inline"><a href="http://www.providesupport.com?messenger=signature">Live Support</a></div></noscript>
	   
    	</td>
	</tr>
	<?php /*
		<tr>
		<td align="left">
	
	
	  	<div id="extra">  
			<div class="sb-menu box">
				More Info:
						<b class="cn tl"></b>
    					<b class="cn tr"></b>
				</div>
			<div class="sb-menu box">
			</div>
			<div class="sb-menu box">
			</div>
			<div class="sb-menu box">
				<p class="more">
            		<a href="/weblog/" class="menuSp">More information  &#187;</a> </p>
										<b class="cn bl"></b>
    					<b class="cn br"></b>
	
			</div>
						<b class="cn bl"></b>
    					<b class="cn br"></b>
	
		</div> 
		
		
<?php		include_once('classes/phpMyBorder.class.php'); 
  			$pmb = new PhpMyBorder(false);  // using stylesheet, to use stylesheet see class-file for details.
  
  			echo $pmb -> begin_round("100%","EEEEEE","000000"); //  (width, fillcolor, edgecolor)
  			echo "content...";
  			echo "<br>";
  			echo 	"content...";
  			echo $pmb -> end_round();

  			echo "<br>";
  
  			echo $pmb -> begin_raised("100%","EEEEEE"); //  (width, fillcolor)
  			echo "content...";
  			echo $pmb -> end_raised();

  			echo "<br>";

  			echo $pmb -> begin_shadow("98%","EEEEEE","000000","555555"); //  (width, fillcolor, edgecolor, shadowcolor)
  			echo "content...";
  			echo $pmb -> end_shadow();
		?>
		</td>
	</tr>
			*/ ?>
	</table>

