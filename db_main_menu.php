<?php
require_once("db_config.php");
class cart_menu
	{

	function top_menu()
	{

		require_once("db_cart_topmenu_Class.php");		
		$menu = new topMenu();
		$menu->open();
				
					//$menu->open_menu(strtoupper('HOME'),'','db_main.php');
					$menu->open_menu(strtoupper('Fundraising Solutions'), 't_menu1','');
						$menu->add_option('Available Programs','http://www.sigfund.com/db_main_programs.php');
						$menu->add_option('Catalog/Brochure Sale','http://www.sigfund.com/db_main_fall_catalog.php');
						$menu->add_option('Cookie Dough Sale', 'http://www.sigfund.com/db_main_cookie.php');
						$menu->add_option('Holiday Shop', 'http://www.sigfund.com/db_main_holiday.php');
						$menu->add_option('Magazine Sale', 'http://www.sigfund.com/db_main_magazine.php');
						$menu->add_option('Dollar Bar Sale', 'http://www.sigfund.com/db_main_dollar.php');
			 			
						$menu->close_menu();	
					$menu->open_menu(strtoupper('Information'), 't_menu2','',200);
						$menu->add_option('Total Service Program','http://www.sigfund.com/db_main_service.php');
						$menu->add_option('Educational Assemblies','http://www.sigfund.com/db_main_assemblies.php');
						$menu->add_option('Promotional Media','http://www.sigfund.com/db_main_videos.php');
						$menu->add_option('Privacy Policy', 'http://www.sigfund.com/db_main_privacy.php');
						$menu->add_option('Return & Refund Policy', 'http://www.sigfund.com/db_main_privacy.php?refund');
						$menu->add_option('About Us', 'http://www.sigfund.com/db_main_about_us.php');
						//$menu->add_option('Site Map', 'db_cart_main.php?category=6');
					$menu->close_menu();
					
					$menu->open_menu(strtoupper('Customer Care'), 't_menu3','',200);
						$menu->add_option('Frequently Asked Questions','db_main_faq.php');
						//$menu->add_option('Extra Order Forms','db_cart_main.php?range=15');
						$menu->add_option('Contact Us','http://www.sigfund.com/db_main_contact_us.php');
						$menu->add_option('Career Center', "http://www.signaturefundraising.com/SigFund/index_career.htm",'_new');
						$menu->add_option('Chairperson Area', "http://www.sigfund.com/db_chair_main.php");
					$menu->close_menu();	
					
					$menu->open_menu(strtoupper('Career Center'),'',"SigFund/index_career.htm",0,'_new');  
					
					$menu->open_menu(strtoupper('Fun Zone'), 't_menu4','');
						$menu->add_option('Appreciation Gifts','http://www.signaturefundraising.com/db_main_prizes.php');
						$menu->add_option('Treasure Chest','http://www.signaturefundraising.com/db_main_treasure.php');
						$menu->add_option('Sig\'s Secret','http://www.signaturefundraising.com/db_main_sig_secret.php');
					$menu->close_menu();
									
				$menu->open_menu(strtoupper('Shop Online Now!'),'','db_cart_main.php?Home');  
								

				//$menu->open_menu(strtoupper('Premium Chocolates'));
				$menu->add_reps_login();
				$menu->close();  

	
		}    // End Top Menu 
	
	function left_menu()
		{
			
			require_once("db_cart_leftmenu_Class.php");	
			?>
			
			<table style="margin-left:2px; margin-top:0; padding-top:0;" border='0'  bgcolor="#ffffff" cellpadding='0' cellspacing='0' width='100%' >
			

				<?php 
				$menu = new leftMenu();
				if (isset($_SESSION['brochure']) && $_SESSION['brochure'] == '13')
					{
					?>
					<?php

				  	} 
						
				?>

			<?php 
			// Menus Catalogs
			
			
			$menu->open("PROGRAMS");

					$menu->open_menu('Catalog/Brochure', 'menu2','',false);
					$menu->add_option('Spring Brochure','http://www.sigfund.com/db_main_spring_catalog.php');
					$menu->add_option('Fall Brochure','http://www.sigfund.com/db_main_fall_catalog.php');
					$menu->close_menu();

			$menu->open_menu('Cookie Dough','','http://www.sigfund.com/db_main_cookie.php');

			$menu->open_menu('Magazines','','http://www.sigfund.com/db_main_magazine.php');

			$menu->open_menu('Holiday Shop','','http://www.sigfund.com/db_main_holiday.php');
			$menu->open_menu('Dollar Bar','','http://www.sigfund.com/db_main_dollar.php');
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
		<td  width="100%" align="center">
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
		?>
		<?php /*
			<a href="http://click.linksynergy.com/fs-bin/click?id=JdxAZu*GB8U&offerid=7
			7482.10000007&type=4&subid=0"><IMG  style=" margin-left:5px; margin-top:35px" width="120px" height="90px" alt="Try Netflix for Free!" border="0" src="http://cdn.netflix.com/us/affiliates/banners/0804/120090A.gif"></a>
			<IMG border="0" width="1" height="1" src="http://ad.linksynergy.com/fs-bin/show?id=JdxAZu*GB8U&bids=77482.100
			00007&type=4&subid=0"> */?>
		</td>
	</tr>
			
	</table>

	<?php		
		}		
}

?>