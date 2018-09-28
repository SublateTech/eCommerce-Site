<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>clsJSPHP - Testpage</title>
  <style type="text/css">
  <!--
   body{
    font: normal 12px Tahoma;
    margin:0;
    padding:0px;
   }
   h1 {
    color: #000;
    font-family: Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    font-size: 18px;
    margin-bottom: 5px;
   }
   h2{
    color: #000;
    font-family: Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    font-size: 14px;
    border-bottom: 2px #000 solid;
   }
   h3{
    font-size: 12px;
   }
   input{
    border: 1px #999 solid;
    background: #eee;
    padding: 4px;
   }
   code{
    display:block;
    padding:5px;
    border-left: 2px #999 solid;
    background-color: #ffffd2;
    margin: 10px 0px;
   }
   div#header{
    height:80px;
    background-color: #000;
    color: #fff;
    padding: 10px 20px 20px 20px;
   }
   div#header h1{
    color: red;
   }
   div#content{
    padding:20px;
    
   }
   .example{
    margin: 10px 0px;
   }
  //-->
  </style>

  <script src="./clsJSPHP.php?jsphp=./clsJSPHP.php" language="JavaScript"></script>

  </head>
  <body onload="">
  <div id="header">
   <h1>clsJSPHP</h1>
   Just another javascript-php-bridge
  </div>
  <div id="content">
  
    <!--INTRODUCTION-->
    
    <b>clsJSPHP</b> is a <a href="http://www.php.net">PHP</a> class that allows you to create 
    richer web applications. That means that you can send asyncron/syncron 
    requests to your server without reloading the page. 
    <br /><br />
    For now clsJSPHP is in an <b>alpha-phase</b>. So test it and send me feedback (kutulik@gmx.de)!
    
    <!--API--><br /><br />
    <h2>Installation</h2>
    Make a reference to the core javascript in the header of your 
    html document:
    <code>
        <b>code:</b><br /><br />
        <?=htmlentities('<script src="[PATH_TO_clsJSPHP.php]?jsphp=[PATH_TO_clsJSPHP.php]" language="JavaScript"></script>');?>
    </code><br />
    
    and you are ready to start!<br /><br />
    
    <h2>Usage</h2>
    
    clsJSPHP doesn't register any php functions that you can call with javascript
    on the client-side. clsJSPHP request a php-file and handle the returned output.
    
    <h3>How should the code look like?</h3><br />
    
    <h3>THE HTML-SIDE:</h3>
    <code>
        <b>code:</b><br /><br />
        
        <b>client-side:</b><br />
        <pre>
        <?=str_replace(array('[b]','[/b]'),array('<b style="color:red;">','</b>'),htmlentities('
            <html>
              <head>
                [b]<script src="[PATH_TO_clsJSPHP]?jsphp=[PATH_TO_clsJSPHP]" language="JavaScript"></script>[/b]
              </head>
              <body>
                <input type="button" onClick="[b]jsphp_exec(\'[PATH_2_PHPFILE]\',\'[PARAMETER]\',[ASYNC=true/false]);[/b]" />
              </body>
            </html>
              '));?>
         </pre>
        </code><br />
        
        <i>[PATH_TO_clsJSPHP]</i><br />relative Path to clsJSPHP (e.g. './clsJSPHP.php' if it is in the same folder)<br /><br />
        <i>[PATH_2_PHPFILE]</i><br />relative Path to the clsJSPHP.php class (e.g. './ajaxhandle/ajaxinclude.php')<br /><br />
        <i>[PARAMETER]</i><br />The parameters you want to tranfer to the php file (e.g. 'id=1&user=frank')<br /><br />
        <i>[ASYNC]</i><br />Parameter if you want to request the php file asyncron or not (default is true)<br /><br />
      
      <br />
      <h3>THE SERVER-SIDE:</h3>
      <code>
        <b>code:</b><br /><br />    
        
         <b>server-side (the php file you are calling):</b><br />
         <pre>
          &lt;?
            //Make sure this file is called by clsJSPHP
            if(!defined('JSPHP_INC')) die('YOU ARE NOT ALLOWED TO ACCESS THIS FILE DIRECTLY');
            
            <b>$jsphp</b>-&gt;addAlert('This is a test');
            
            <b>$jsphp</b>-&gt;output();
            
            /*
              To get transfered parameters use $_POST or $_REQUEST !!
              
              Parameters are send with POST because you can transfer more data with it.
            
            */
          ?&gt;
         </pre>
    </code><br />
    
    And that's it. After pressing the button (html-side) a message ('This is a test') will appear.
    Quite simple right!?
    <br /><br />
    <h3>You have the following methods to manipulate the HTML-Side from the requested php file:</h3>

    <pre>
    <b>$jsphp</b>-&gt;setStyle($targetid,$attribute,$style);
    <b>$jsphp</b>-&gt;setAttributte($targetid,$attribute,$value);
    <b>$jsphp</b>-&gt;innerHTML($targetid,$text);
    <b>$jsphp</b>-&gt;addAlert($msg);
    </pre>
    
    <h3>Quick javascript functions on the html-side</h3>
    <pre>
    <b>jsphp_gcontent(url,prm)</b>
    returns output as string from requested php file (url)
    
    <b>jsphp_shtml(id,url,prm,async)</b>
    set inner html of an element (with the given id) with the output from requested php file (url)
    
    <b>jsphp_svalue(id,url,prm,async)</b>
    set value of an element (e.g. input-field with the given id) with the output from requested php file (url)
    
    </pre>
    
    
    More features will be included in the future.
    
    
    <!--EXAMPLES--><br /><br />
    <h2>Examples</h2>
    
    <h3>Example 1</h3>
    This example shows how to get just raw php output:
    
    <div class="example">
      <input type="button" onClick="alert(jsphp_gcontent('ajaxinclude.php','prm1=1',false));" value="hello world" />
    </div>

    <code>
        <b>code:</b><br /><br />
        <?=htmlentities("alert(jsphp_gcontent('ajaxinclude.php','prm1=1'));");?>
    </code><hr />
  
    <h3>Example 2</h3>
    This example shows how to set an input-value with php output:
    
    <div class="example">
      <input type="text" id="txtval" /> 
      <input type="button" onClick="jsphp_svalue('txtval','ajaxinclude.php','prm2=1&index=2');" value="Set value" />
    </div>
    <code>
        <b>code:</b><br /><br />
        <?=htmlentities("jsphp_svalue('txtval','ajaxinclude.php','prm2=1&index=2');");?>
    </code><hr />
    
    <h3>Example 3</h3>
    This example shows how to set inner html of an element with php output:
    
    <div class="example">
      <div id="cdiv" style="border:1px #ccc solid;background:#eee;width:300px;height:200px;overflow:auto;padding:4px;">click button!</div>
      <br />
      <input type="button" onClick="jsphp_shtml('cdiv','ajaxinclude.php','prm3=1');" value="Load data" />
    </div>
    <code>
        <b>code:</b><br /><br />
        <?=htmlentities("jsphp_shtml('cdiv','ajaxinclude.php','prm3=1');");?>
    </code><hr />
    
    <h3>Example 4</h3>
    This example shows how to modify html with requested php file:
    
    <div class="example">
      <div id="cmdiv" style="border:1px #ccc solid;background:#eee;width:300px;padding:4px;">Sample text...</div>
      <br />
      <input type="button" onClick="jsphp_exec('ajaxinclude.php','prm4=1');" value="Send request" />
    </div>
    <code>
        <b>code:</b><br /><br />
        <?=htmlentities("jsphp_exec('ajaxinclude.php','prm4=1');");?>
        
        <pre>
        <b>ajaxinclude.php:</b>
        
        if(isset($_REQUEST['prm4'])){
          $jsphp->addAlert('textcolor will be modified...');
          $jsphp->setStyle('cmdiv','color','red');
          $jsphp->output();
        }
        </pre>
    </code>
    
    
    <hr />
    <b>copyright (c) 2005 by Artur Heinze</b> - published under the <a href="http://www.gnu.org/copyleft/lesser.html#SEC3">LGPL</a> license
  </div>
  </body>
</html>
