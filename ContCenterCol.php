<?php
class CenterCont
{

function CenterCont()
		{
			//$this->ShowHeader();
			$this->AddContent("");
		}


function AddContent($arg)
	{
	?>
	<?php
	//	require "GetContent.php";
	//	return;
		?>
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FBFBFB">
<th>
 <td align="center"  with="100%">
   <div id = 'extra'>

	<div id="sb-favetags" class="sb-module box open">
    	<h3 class="sb-mtitle nodisclosure"> F. Engels:</h3>
    	<div class="contents">
        Dialectics ... is nothing more than the science of the general
		laws of motion and development of nature, human society and thought.
		      
    	</div>
	
    	<b class="cn tl"></b>
    	<b class="cn tr"></b>
    	<b class="cn bl"></b>
    	<b class="cn br"></b>
	</div>

		<div id="whatsthis" class="section">
		<p>

			<strong>What&#8217;s this?</strong>	
    		This page shows the most recent posts from <a href="/profile/jamiemottram">Jamie Mottram's</a> favorite blogs.
	</p>

	</div> 

	
	<div id="favehome" class="right" onmouseover="divLink(this,'/faves/glenn_fleishman')" style="background-image:url(images/Engels.JPG)">
                    <img src="http://static.technorati.com/pix/icn-newhome.gif" alt="New" id="icn-new" />
        
<!--        <img src="images/Engels.JPG" alt="What's New in Glenn Fleishman's Favorite Blogs" width="364" height="502" /> -->

		<h3>Latest posts:</h3>
        <ol>
                            				
				                    <li>Mobile Assassins To Offer Group Game With Camera Phone... </li>
				                                            				
				                    <li>Black New York Firefighter Snaps Photo Of Co-worker In... </li>
				                                            				
				                    <li>How Many Times Have You Bought Star Wars? How Many... </li>
            </ol>

        <p class="r">
            <a href="/faves/glenn_fleishman" class="e">View Favorites &raquo;</a>
        </p>

                <p>
            Got favorite blogs?<br />
            <a href="/faves/">Create Your Own!</a>
        </p>
        
        <b class="cn tl"></b>
        <b class="cn tr"></b>
        <b class="cn bl"></b>
        <b class="cn br"></b>
    </div>

  <div id="sb-messaging" class="sb-module box open">


<!--    <img src="images/Engels.JPG" alt="" width="44" height="62" /> -->
    <strong><h3>CNN News:</h3> </strong> 

    <div class="contents">
		<ul>
<!--                    <li><a href="/signup/?f=blogclaim" class="st">Do you blog? <em>Claim it</em> to get in here!</a></li>
        
        <li><a href="/signup/?f=watchlist" class="st">Want more? <em>Become a member</em> to save searches in a Watchlist.</a></li> 
		<h3 class="sb-mtitle nodisclosure"> F. Engels:</h3> -->
    	
        	<script type="text/javascript">
				//document.write("<em> CNN News: </em>")
				new rssticker_ajax("CNN", 600, "cnnbox", "cnnclass", 4000, "date")
			</script>
				
    </ul>
    </div>
		<b class="cn tl"></b>
    	<b class="cn tr"></b>
    	<b class="cn bl"></b>
    	<b class="cn br"></b>
	</div> 
</div> 
</td>
<td align="center" with="50%">
	 
	<div id='extra'>
	 <div id="sb-messaging" class="sb-module box open">


<!--    <img src="images/Engels.JPG" alt="" width="44" height="62" /> -->
    <strong><h3>MSNBC News:</h3> </strong> 

    <div class="contents">
		<ul>
<!--                    <li><a href="/signup/?f=blogclaim" class="st">Do you blog? <em>Claim it</em> to get in here!</a></li>
        
        <li><a href="/signup/?f=watchlist" class="st">Want more? <em>Become a member</em> to save searches in a Watchlist.</a></li> 
		<h3 class="sb-mtitle nodisclosure"> F. Engels:</h3> -->
    	
        	<script type="text/javascript">
//				document.write("<em> MSNBC News: </em>")
				new rssticker_ajax("MSNBC", 600, "msnbc1", "cnnclass", 4000, "date")
			</script>
				
    </ul>
    </div>
		<b class="cn tl"></b>
    	<b class="cn tr"></b>
    	<b class="cn bl"></b>
    	<b class="cn br"></b>
	</div> 
</div>
</td>
</table>	
 
	 <?php
	 
	}

}

$contcol = new CenterCont();
?>


