<?php
class Page
{

  // class Page's attributes
  var $title = "Signature Fundraising, inc.";
  var $scripts = "";
 

  // class Page's operations
  
  function EndPage()
	{
		//echo "\n</body>\n</html>\n";
	}
 
  function set_title($title)
  	{
		$this->title = $title;
	}
  
   function __destruct() {
   	echo "</BODY></HTML>";
    }

  function Show_General_Header()
  {
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
	
    echo "<HEAD>\n";
		$this -> DisplayTitle();
    echo "</HEAD>\n
	<BODY> 
	\n";

  }

  
  function ShowHeader()
  {
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';

	/*echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
 		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">  ';*/

    echo "<HEAD>\n";
	$this -> DisplayTitle();
    $this -> LoadScripts();
    echo "</HEAD>\n<BODY>\n";

  }

  function DisplayTitle()
  {
     echo '<title>';
	 echo $this->title ;
	 echo "</title>\n";
	 echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
	 
  }


  function AddScript($script='')
  	{
		$this->scripts .= 	$script;	
	}

  function LoadScripts()
  { 
  	 
	/*		<script type="text/javascript" src="css/chrome.js"> </script>
		<link rel="stylesheet" type="text/css" href="css/chromestyle.css" />
	*/
	
	echo '
		<script src="css/ajaxticker.js" type="text/javascript"></script>
		<script src="css/ContracExpand.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/tn-sub.css" />
		<link rel="stylesheet" type="text/css" href="css/signature.css" />
		<link rel="stylesheet" type="text/css" href="css/rssticker.css" />		
		';
	echo $this->scripts;

  }
  
}
?>