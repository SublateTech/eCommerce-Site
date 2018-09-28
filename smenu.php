<div id="chromemenu">
		<ul>
			<li><a href = "#" onMouseover = "cssdropdown.dropit(this,event,'dropmenu6')">HOME</a></li>
			<li><a href="#" onMouseover="cssdropdown.dropit(this,event,'dropmenu1')">BROCHURES</a></li>	
			<li><a href="#" onMouseover="cssdropdown.dropit(this,event,'dropmenu2')">FUNDRAISING IDEAS</a></li>
			<li><a href="#" onMouseover="cssdropdown.dropit(this,event,'dropmenu3')">INFORMATION</a></li>
			<li><a href="#" onMouseover="cssdropdown.dropit(this,event,'dropmenu4')">FUN ZONE</a></li>
			<li><a href='db_cart_main.php' >SHOP ONLINE</a> </li>
			<div id='cart_info'> <a href='db_cart_checkout_modify.php'><img src="images/cart.gif" /> </a> </div>
			<?php if (isset($_SESSION['user'])) { ?>
						<div id='cart_logout'> <a href='db_cart_login.php?action=log_out'>Log out</a> </div>
			<?php
					}else { ?>
						<div id='cart_logout'> <a href='db_cart_login.php?action=log_in'>Log in</a> </div>
			<?php		
					} ?>
			
		</ul>
</div>
		

<!--1st drop down menu -->      
<div id="dropmenu6" class="dropmenudiv" style="width: 150px; ">
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=index_career','CenterCol')">Career Center</a> 
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=contact','CenterCol')">Contac Us</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=about','CenterCol')">About Us</a>
</div>
                                             
<div id="dropmenu1" class="dropmenudiv" style="width: 150px; ">

	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=catalogfall','CenterCol')">Fall 06 Catalog</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=cookiedough','CenterCol')">Cookie Dough</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=catalogsalepreview','CenterCol')">Spring 07 Preview</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=cheesecake','CenterCol')">Cheese Cakes</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=gooseberry','CenterCol')">Goose Berry Patchs</a> 
<?php	// echo GetMenuDB();  ?>

</div>

<!--2nd drop down menu -->                                                
<div id="dropmenu2" class="dropmenudiv" style="width: 150px;">
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=catalogsale','CenterCol')">Catalog/Brochure </a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=cookiedoughsale','CenterCol')">Cookie Dough</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=magazinesale','CenterCol')">Magazines</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=holidayshopsale','CenterCol')">Holliday Shop</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=dollarbarsale','CenterCol')">Dollar Bar</a>
	
	
</div>

<!--3rd anchor link and menu -->                                                 
<div id="dropmenu3" class="dropmenudiv" style="width:150px;">
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=program','CenterCol')" >Program Info</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=fundraisingform','CenterCol')" >Service Info</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=questions','CenterCol')" >Questions</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=videos','CenterCol')" >Kick-Off Videos</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=picturegallery','CenterCol')" >Picture Gallery</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=downloads','CenterCol')" >Order Forms</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=assemblies','CenterCol')" >Educational Assemblies</a>
	<a href="#" onclick="javascript:ajaxpage('GetContent.php?cArg=FAQ','CenterCol')" >FAQ</a>
			
	
</div>
<?php /*<SCRIPT>
checkFontSetting(); // sets the font size if changed in session cookie
</SCRIPT>*/ ?>

<?php
function GetMenuDB()
{
$dbserver='localhost';
$dbuser='sa';
$dbpwd='';
$db='signature';

$link = mysql_connect ($dbserver, $dbuser, $dbpwd) or die ("Could not connect");
mysql_select_db($db);
$sql  = "SELECT * From Brochure";

$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
$string = "";
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
	
	//$string =  "<a href='http://index.php'>"  //. row[0] . "</a><br />";
	
	$string .=  "<a href='http://index.php'>"  . $row[1] . "</a>";
		
	}
	
		// Closing connection
		mysql_close($link);
	
	return $string;
		
}
?>