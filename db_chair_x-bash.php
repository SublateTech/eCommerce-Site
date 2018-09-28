<?php 
	//if($_SERVER['HTTPS'] != "on")
	//{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);exit;}
if (!session_id()) session_start();

	/*$_POST['name'] = "Alvaro";
	$_POST['email'] = "Alvaro@SigFund.com";
	$_POST['item'] = "0113";
	$_POST['fmail1'] = "Alvaro@sigfund.com";
	$_POST['fmail2'] = "";
	$_POST['fmail3'] = "";*/

require_once ("classes/cal_class.php");

if(count($_POST)) {


require_once('classes/sec_class_inc.php');

#To - Name, To - Email, From - Name, From - Email
//$sec = new sec('Mark Davidson', 'alvaro@sigfund.com', $_SERVER['SERVER_NAME'], $_SERVER['SERVER_ADMIN']);

$sec = new sec("Russ Rice", "RRice@SigFund.com", $_POST['b_contactname'], $_POST['b_contactemail']);


$sec->Bcc($_POST['b_contactemail']);
//$sec->Bcc('mdavidson@fluxnetworks.co.uk');

#add image to be embeded
//$img1 = $sec->embed('images/150H/'.$item.'.jpg');


#produce message in html format
$message = "School Name   : " . $_POST['b_schoolname']."<br>";
$message .= "School Phone : ". cv_phone($_POST['b_schoolphone'])."<br>";
$message .= "Contact Name : ".$_POST['b_contactname']."<br>";
$message .= "Contact Phone: ".cv_phone($_POST['b_contactphone'])."<br>";
$message .= "1st Choice Date : ".$_POST['b_firstchoicedate']."<br>";
$message .= "1st Choice Time : ".$_POST['b_firstchoicetime']."<br>";
$message .= "2nd Choice Date : ".$_POST['b_secondchoicedate']."<br>";
$message .= "2nd Choice Time : ".$_POST['b_secondchoicetime']."<br>";
$message .= "3rd Choice Date : ".$_POST['b_thirdchoicedate']."<br>";
$message .= "3rd Choice Time : ".$_POST['b_thirdchoicetime']."<br>";
$message .= "Number of Volunteers : ".$_POST['b_volunteers']."<br>";
$message .= "Comment : ".$_POST['b_comment']."<br>";


//print $message;

#build the message with the message title and message content
$sec->buildMessage('X-Treme Bash : '.$_POST['b_schoolname']."/".$_POST['b_contactname'], $message);

#attach files to email
//$sec->attachment('sec.demo.php');
//$sec->attachment('sec.class.inc.php');

#build and send the email
if($sec->sendmail()) {
	//echo 'Your Email Was Sent';
	# After submission, the thank you page
	$thankyoupage = "db_chair_x-bash.php?close";
	header("Location: $thankyoupage");
exit;

} else {
	echo 'Your Email Failed to be Sent';
}






} //Here

if (isset($_REQUEST['close']))
		{
			
			
			?>
			<table  height="400px" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
							<td valign="middle">
								<tr >
									<td align="center">
											<?php 	print "Your X-Treme Bash form was sent!"	?>
								 	</td>
								</tr>
								 <tr >
								 	
										
												<TD align="center">
												<br />
												<form action="#">
												<div>
												<input type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
												</div>
												</form>
												</TD>
										
										 </tr>
								</td>	
							 </table>
			
			
			
			<?php 
				exit;
					/*
			<script language="javascript">
				this.close();
					
					
			</script> */?>
					
		<?php } 

	
	
	require("db_cart_form_class.php");
	

	
	$rep_sales = new chair_ranking_class();
	$rep_sales->Start();
	
	
	class chair_ranking_class { 
	
	var $rep_id='';
	var $rep_name='';
	var $frobj; 
	
	
	function chair_ranking_class()
	{
			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

	}
	
	
	function Start()
	{

	$this->frobj = new db_cart_form_class(); 

	if (isset($_REQUEST['logout']))
		{
		unset($_SESSION['Customer']);
		unset($_SESSION['Company']);
		}

	
	if (!isset($_SESSION['Customer']))
		{
		header("Location: db_reps_main.php");
		exit;
	
		}
		
		
			
			if (isset($_REQUEST['page']))
				$page = $_REQUEST['page'];
			else
				$page=1;
	
			

			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();
			
			
	/*		$page_htm->AddScript('<script src="db_ajax.class.php?jsphp=db_ajax.class.php" language="JavaScript"></script>');*/
			$page_htm->AddScript('<script language="JavaScript" src="classes/calendar.core.js"></script>');
			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	false;
			$page_cnt->s_bar 	=	false;
			
			
			//$page_cnt->t_menu 	=	false;
			$page_cnt->Header(); 
			$page_cnt->Header_Center(); 
			$page_box->l_menu = false;
			$page_box->Header();
			
			
			$this->pattern_top();
							
			$this->xtreme();
						
			$this->pattern_bottom();
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
	}

	function xtreme()
	{?>
						<table   cellpadding="0"  cellspacing="0" width="100%" align="center" border="0">	
							<td>
								<table  width="90%"  cellpadding="0"  cellspacing="0" align="center" border="0">
								<tr width="50"  align="left" >
								  <td colspan="2">
									<br />
										
										<center><font color="#990000" ><p>Please, do not use this option for Limo Ride, instead use our 1-800-645-3863 line service and ask for your representative. </p></font><br /></center>
										
										<center><font  face="Geneva, Arial, Helvetica, sans-serif" size="+2">   XTREME BASH</font>®  <br /></center>

                                    <p><font face="Arial, Helvetica, sans-serif"><strong>Instructions</strong></font></p>
                                        <p> <br />
                                    You can get a list of the students that qualified from the computer printout that was given to you at the delivery. You can also get a list of the students here in the Chairperson Area by clicking on "School Sellers". </p>
                                        <p><br />
                                          You can choose the day and the time you want to do your party. The parties are set up on a "first come, first served" basis and we will do our best to accommodate you! – Please provide us with 1st,2nd, and 3rd choice dates acceptable to the school. 
									  You will need to provide a 1st, 2nd and 3rd choice for dates acceptable to the school! </p>
                                        <p>&nbsp;</p>
                                        <p>Your party can last up to 2 hours. </p>
                                        <p>&nbsp;</p>
                                    <p>We will provide set-up and tear down, insurance, music, snacks (usually a choice of Capri Suns or water along with a bag of cookies) and at least 3 people to help monitor the inflatables. You will need to provide at least 2 people per inflatable. The more supervision, the better the event seems to go as there are a lot of simple games and contests that can be organized for the kids if there are adults to help! Feel free to get creative and make this event as great as you want it to be!. </p>
                                    <p><br />
                                      The number and type of inflatables that will be provided depends on the size of the school, the size of the area and what we have available on a given day.</p>
                                    <p>&nbsp;</p>
                                    <p>To preview o print your X-Treme Bash waive, click on this <a  style="text-decoration:none" href="X-treme_Bash_Waiver.pdf">Link</a>. </p>
                                    <p><b></b></p><br>
                                    <b><center>We want to make this a great reward for the students that worked hard to support your fundraiser and an event that they will look forward to in years to come!</center><br />

<center> Thank you for working with us on your fundraiser! </center></b>

								    <p>&nbsp;</p>
								    <p><br />
						              <br />									
						            </p></td>
								</tr>
								
								<td>
									<tr>
		<?php							
										
										echo $this->frobj->form_start('form1', 'db_chair_x-bash.php', 'error', false);	
										
										$calendario=new Calendar("en");
										$calendario->sfondo_settimana="Green";
										$calendario->giorni_settimana_linkabili="1,2,3,4,5";
										$calendario->notallowed="0,20";
										$calendario->sfondo_settimana="#AEB0BF";
										$calendario->notallowed="'9/22/2008','12/05/2008','12/12/2008','12/03/2008','12/04/2008','12/18/2008','12/19/2008','12/10/2008','11/25/2008','11/27/2008','12/08/2008','12/11/2008','12/01/2008','01/13/2009','01/15/2009','01/16/2009','01/22/2009','01/23/2009','01/26/2009','12/2/2008','12/09/2008','12/15/2008','12/16/2008','12/17/2008','12/24/2008','12/25/2008','12/26/2008','12/28/2008','12/29/2008','12/30/2008','12/31/2008','01/07/2009','01/08/2009','01/09/2009','01/12/2009','01/13/2009','01/14/2009','01/15/2009','01/16/2009','01/21/2009','01/27/2009','01/28/2009','01/16/2009','01/23/2009','02/06/2009','02/19/2009','01/30/2009','01/20/2009','03/10/2009','03/13/2009','03/17/2009','03/20/2009','03/26/2009','03/30/2009','03/31/2009','04/01/2009','04/02/2009','04/03/2009','04/06/2009','04/07/2009','04/08/2009','04/09/2009','04/10/2009'";
	
					    
										echo $this->frobj->input_text('School Name:','b_schoolname', '', '', $_SESSION['Name'], 40, true);
										echo $this->frobj->input_text('School Phone:','b_schoolphone','', '', cv_phone($_SESSION['PhoneNumber']), 30, true);
										echo $this->frobj->input_text('Contact Name:','b_contactname','', '',$_SESSION['ChairPerson'] , 35, true);
										echo $this->frobj->input_text('Contact Phone:','b_contactphone','', '', cv_phone($_SESSION['HeadPhone']) , 25, true);
										//echo $this->frobj->input_text('Contact eMail:','b_contactemail','', '', str_replace("*","",$_SESSION['eMail']), 35, true);
										echo $this->frobj->input_text('Contact eMail:','b_contactemail','', '', '', 35, true);
										//echo $this->frobj->input_text('1st Choice Date:','b_firstchoicedate','', '', "", 10);
										echo "<tr><td align='left' colspan=1 ><font style='margin-left:95px'>1st Choice Date:</font></td><td width='300px' align='left'>";
										$calendario->CreateCalendar("12/01/2008","","b_firstchoicedate","12/01/2008","12/31/2009",1);
										echo "<br><font color='#FF0000'> Available days are boldfaced</font> </td></tr>";

										echo $this->frobj->input_text('                Time:','b_firstchoicetime','', '', "", 10);
										echo "<tr><td align='left'><font style='margin-left:95px'>2nd Choice Date:</font></td><td  width='300px'  align='left'>";
										$calendario->CreateCalendar("12/01/2008","","b_secondchoicedate","12/01/2008","12/31/2009",1);
										echo "<br><font color='#FF0000'> Available days are boldfaced</font> </td></tr>";
										
										echo $this->frobj->input_text('                Time:','b_secondchoicetime','', '', "", 10);
										echo "<tr><td align='left'><font style='margin-left:95px'>3rd Choice Date:</font></td><td   width='300px' align='left'>";
										$calendario->CreateCalendar("12/01/2008","","b_thirdchoicedate","12/01/2008","12/31/2009",1);
										echo "<br><font color='#FF0000'> Available days are boldfaced</font> </td></tr>";
										
										echo $this->frobj->input_text('                Time:','b_thirdchoicetime','', '', "", 10);
										echo $this->frobj->input_text('Number of Volunteers Available:','b_volunteers','', '', "", 10);
										echo $this->frobj->input_text_area('Comment :','b_comment', '', 200, 100, false);
										
										/*echo '<script language="javascript" type="text/javascript" src="classes/calendar.core.js"></script>';*/

									
										
									?>	
										
									</tr>
									
									<tr>
									<?php
									echo "<tr><td  colspan=2 align='center' >";
									echo "<p class='label'>".$this->frobj->form_end(true,'submit_form','Submit')."</p>";
									echo '</td></tr>';
									
									?>
									</tr>
							</table>
							</td>
						</table>
						<?php 
		return;
	}


			function pattern_top($Title="X-TREME BASH")
				{
				?>
					<table style="margin-top:30px; margin-right:0; padding-right:0;  "  cellpadding="0"  cellspacing="0" border="0"	 width="100%" bgcolor="#FFFFFF"> 
					<tr>
						<td colspan="3">
						<div id='cart_title_right' style="text-align:right; padding-right:10px;" >
							<a href='db_chair_main.php' > &laquo; Back</a> 
							|
							<a href='db_chair_main.php?logout'> <?php echo isset($_SESSION['Customer'])?"Logout":''; ?>   </a> 
						</div>

						</td>
					</tr>
					<tr>
						<td height="41"  colspan="3">
							<div id='center_title'>
								<font size="+1">  <?php print $Title ?> </font>
							</div>
							<a name="top"></a>
				  		</td>
					</tr>	
					<tr valign="top">
					  <td width="2%"  rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td  width="96%" height="0"  align = "left"  valign="middle">
					  	 <div id='cart_title_left' style="text-align:right; padding-right:10px;" >
							<?php /*<a style="padding-left:10px; float:left; text-align:left;" href="javascript:sweeptoggle('contract');" > Contract All </a> */?>
							<span style="padding-left:5px; float:left; text-align:left;">
							<?php print "School: <b>".$_SESSION['Name']."</b>"; ?>
							</span>
							
						</div>
						</td>
                      <td  height="5" width="2%" rowspan="3"> </td>
  					</tr>
				    <tr valign="top">
				      	<td width="88%"  align = "right"  valign="top">
					
				<?
				}
				
			function pattern_bottom()
				{
				?>
				 	 	</td>
  					</tr>
			    <tr valign="bottom">
					  <td colspan="3" height="5"  align = "CENTER"  valign="middle">&nbsp;</td>
                </tr>
				</table>
				<?
				}
				
			
		
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
				
		
?>