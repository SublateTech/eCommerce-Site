<?php
require_once("db_config.php");
class cart_menu
	{

	function top_menu()
		{

		
		require_once("db_cart_topmenu_Class.php");		
		$menu = new topMenu();
		$menu->open();
				
				$menu->open_menu(strtoupper('HOME'),'','db_cart_main.php?Home');
				if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '13')
					{
						$menu->open_menu(strtoupper('Prices'), 't_menu1','');
						$menu->add_option('$10','db_cart_main.php?range=10!');
						$menu->add_option('$20','db_cart_main.php?range=20!');
						$menu->add_option('View All', 'db_cart_main.php?range=All');
						$menu->close_menu();	
				  	} 


				if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '4')
					{
					

					$menu->open_menu(strtoupper('Category'), 't_menu2','',200);
						$menu->add_option('Home Decor','db_cart_main.php?category=1');
						$menu->add_option('Kitchen $ Gadgets','db_cart_main.php?category=2');
						$menu->add_option('Bath & Body','db_cart_main.php?category=3');
						$menu->add_option('Specialty Items', 'db_cart_main.php?category=4');
						$menu->add_option('Candles & Fragrances', 'db_cart_main.php?category=5');
						$menu->add_option('Address Books & Organizers', 'db_cart_main.php?category=6');
						$menu->add_option('Gourmet Foods & Chocolates', 'db_cart_main.php?category=7');
						$menu->add_option('Gift Wrap and Accessories', 'db_cart_main.php?category=8');
						$menu->add_option('Jewerly', 'db_cart_main.php?category=9');	
						$menu->add_option('Featured Items', 'db_cart_main.php?category=10');
						$menu->add_option('View All', 'db_cart_main.php?category=All');
					$menu->close_menu();
					
					$menu->open_menu(strtoupper('Prices'), 't_menu1','');
						$menu->add_option('Under $10','db_cart_main.php?range=10');
						$menu->add_option('$10 - $15','db_cart_main.php?range=15');
						$menu->add_option('$15 - $20','db_cart_main.php?range=20');
						$menu->add_option('$20 +', 'db_cart_main.php?range=20>');
						$menu->add_option('View All', 'db_cart_main.php?range=All');
					$menu->close_menu();	
				  	} 

				if (!isset($_SESSION['brochure']))
					$brochure = 0;
				else
					$brochure = $_SESSION['brochure'];
			
				
				if ($brochure != '4')
					{
					$menu->open_menu(strtoupper('Spring 09'),'','db_cart_main.php?Brochure=4');  
					}
			/*	if ($brochure != '11')
					{
					$menu->open_menu(strtoupper('Expressions Collection'),'','db_cart_main.php?Brochure=11');
					}*/

				//$menu->open_menu(strtoupper('WEB Specials'),'','db_cart_main.php?Brochure=12');
				$menu->open_menu(strtoupper('Magazines'),'','db_cart_main.php?Brochure=13');
				$menu->open_menu(strtoupper('Premium Chocolates'),'','db_cart_main.php?Brochure=4&category=7');

				//$menu->open_menu(strtoupper('Premium Chocolates'));
				$menu->add_login();
				$menu->close();  

	
		}    // End Top Menu 
	
	function left_menu()
		{
			
			require_once("db_cart_leftmenu_Class.php");	
			?>
			
			<table style="margin-left:2px; margin-top:0; padding-top:0;" border='0'  bgcolor="#ffffff" cellpadding='0' cellspacing='0' width='150px' >
			

				<?php 
				$menu = new leftMenu();
				if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '13')
					{
					?>
					<tr>
						<td valign='top'>
					<?php
					
					$menu->open("Magazines");
					if (isset($_REQUEST['range']))	
						$menu->open_menu('Prices', 'menu1','',true);
					else  
						$menu->open_menu('Prices', 'menu1','',false);
					
					$menu->add_option('$10','db_cart_main.php?range=10!');
					$menu->add_option('$20','db_cart_main.php?range=20!');
					$menu->add_option('View All', 'db_cart_main.php?range=All');
						
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
					

				if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '4')
					{
					?>
					<tr>
						<td valign='top'>
					<?php
					
					$menu->open("Spring 09 Catalog");
					if (isset($_REQUEST['category']) || isset($_SESSION['category']))
						$menu->open_menu('Category', 'menu2','',true);
					else					
						$menu->open_menu('Category', 'menu2','',false);
						
					$menu->add_option('Home Decor','db_cart_main.php?category=1');
					$menu->add_option('Kitchen & Gadgets','db_cart_main.php?category=2');
					$menu->add_option('Bath & Body','db_cart_main.php?category=3');
					$menu->add_option('Specialty Items', 'db_cart_main.php?category=4');
					$menu->add_option('Candles & Fragrances', 'db_cart_main.php?category=5');
					$menu->add_option('Address Books & Organizers', 'db_cart_main.php?category=6');
					$menu->add_option('Gourmet Foods & Chocolates', 'db_cart_main.php?category=7');
					$menu->add_option('Gift Wrap and Accessories', 'db_cart_main.php?category=8');
					$menu->add_option('Jewelry', 'db_cart_main.php?category=9');
					$menu->add_option('Featured Items', 'db_cart_main.php?category=10');
					$menu->add_option('View All', 'db_cart_main.php?category=All');
						
					$menu->close_menu();
					if (isset($_REQUEST['range']) || isset($_SESSION['range']))	
						$menu->open_menu('Prices', 'menu1','',true);
					else $menu->open_menu('Prices', 'menu1','',false);
					
					$menu->add_option('Under $10','db_cart_main.php?range=10');
					$menu->add_option('$10 - $15','db_cart_main.php?range=15');
					$menu->add_option('$15 - $20','db_cart_main.php?range=20');
					$menu->add_option('$20 +', 'db_cart_main.php?range=20>');
					$menu->add_option('View All', 'db_cart_main.php?range=All');
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
					$menu->open_menu('Spring 2009','','db_cart_main.php?Brochure=4');  
				}
/*			if ($brochure != '11')
				{
					$menu->open_menu('Expressions Collection','','db_cart_main.php?Brochure=11');
				}*/

			//$menu->open_menu('WEB Specials','','db_cart_main.php?Brochure=12');
			if ($brochure != '13')
				{
				$menu->open_menu('Magazines','','db_cart_main.php?Brochure=13');
				}
			$menu->open_menu('Premium Chocolates','','db_cart_main.php?Brochure=4&category=7');
			$menu->close();  
				
			?>
			
		</td>
	 </tr>

	<?php if (isset($_SESSION['brochure']))	
		{ ?>
	 <tr>
	 	<td align='center' >
	 		<div id="cilgat" style="z-index:100;position:absolute"></div>
	 		<div id="sclgat" style="display:inline"></div>
	 		<div id="sdlgat" style="display:none"></div>
	 		<script type="text/javascript">var selgat=document.createElement("script");selgat.type="text/javascript";selgat.defer=true;selgat.src=(location.protocol.indexOf("https")==0?"https://secure.providesupport.com/image":"http://image.providesupport.com")+"/js/signature/safe-standard.js?ps_h=lgat\u0026ps_t="+new Date().getTime();document.getElementById("sdlgat").appendChild(selgat)</script><noscript><div style="display:inline"><a href="http://www.providesupport.com?messenger=signature">Live Support</a></div></noscript>
	   
    	</td>
	</tr>
	<tr>
		<td  valign="bottom" height="150px" align="center">
			<img src="images/horz_master_120pixels.gif" />
		</td>
	</tr>
	
	<?php } ?>

	
		<tr>
		<td   align="center">
	<?php /*
	
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
	*/?>	
		
<?php	/*	include_once('classes/phpMyBorder.class.php'); 
  			$pmb = new PhpMyBorder(false);  // using stylesheet, to use stylesheet see class-file for details.
  
  			/*echo $pmb -> begin_round("100%","EEEEEE","000000"); //  (width, fillcolor, edgecolor)
  			echo "content...";
  			echo "<br>";
  			echo 	"content...";
  			echo $pmb -> end_round(); 
			
  			echo "<br>"; 
  
  			echo $pmb -> begin_raised("100%","EEEEEE"); //  (width, fillcolor)
  			 
			<script type="text/javascript">
				var xmlfile="http://"+window.location.hostname+"/GetThougts.php" //path to ticker txt file on your server.
				//ajax_ticker(xmlfile, divId, divClass, delay, optionalfadeornot)
				new ajax_ticker(xmlfile, "ajaxticker1", "cnnclass", 6500, "fade")
	 		</script> 
			
			<script type="text/javascript">
//				document.write("<em> MSNBC News: </em>")
				new rssticker_ajax("MSNBC", 600, "msnbc1", "cnnclass", 4000, "date")
			</script>
			<?php
  			echo $pmb -> end_raised();

  			echo "<br>";

  			echo $pmb -> begin_shadow("98%","EEEEEE","000000","555555"); //  (width, fillcolor, edgecolor, shadowcolor)
  				?>
				<script type="text/javascript">
					//document.write("<em> CNN News: </em>")
					new rssticker_ajax("CNN", 600, "cnnbox", "cnnclass", 4000, "date")
				</script>
			<?php	
  			echo $pmb -> end_shadow(); */
		
		/*
			<a href="http://click.linksynergy.com/fs-bin/click?id=JdxAZu*GB8U&offerid=7
			7482.10000007&type=4&subid=0"><IMG  style=" margin-left:5px; margin-top:35px" width="120px" height="90px" alt="Try Netflix for Free!" border="0" src="http://cdn.netflix.com/us/affiliates/banners/0804/120090A.gif"></a>
			<IMG border="0" width="1" height="1" src="http://ad.linksynergy.com/fs-bin/show?id=JdxAZu*GB8U&bids=77482.100
			00007&type=4&subid=0"> */
			?>
			<a href="http://click.linksynergy.com/fs-bin/click?id=JdxAZu*GB8U&offerid=78684.10000002&type=4&subid=0">
			<IMG style=" margin-left:5px; margin-top:35px"  alt="Netflix, Inc." border="0" src="http://cdn.netflix.com/us/affiliates/banners/0804/120060A_599.gif"></a><IMG border="0" width="1" height="1" src="http://ad.linksynergy.com/fs-bin/show?id=JdxAZu*GB8U&bids=78684.10000002&type=4&subid=0">
		</td>
	
	</tr>

		<tr>
			<td  valign="bottom" height="20px"  width="100px" align="center">
			
			</td>
	</tr>
	<tr> 
		<td align="center"  >
			<a  href="http://www.signaturefundraising.com/db_cart_main.php?view=2&item=ESM2"><img height="100px" src="images/150H/ESM2.jpg" /><font size="1" color="#FF0000"><br />Extreme Sticker<br />Machine Refills</font></a>
		</td>
	</tr>
			
	</table>

	<?php		
		}		
}

?>