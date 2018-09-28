<html>
  <head>
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

  <script src="clsJSPHP.php?jsphp=clsJSPHP.php" language="JavaScript"></script>

  </head>
  <body onLoad="">
     
    <!--EXAMPLES--><br /><br />
    <h2>Examples</h2>
    
    <h3>Example 1</h3>
    This example shows how to get just raw php output:
    
    <div class="example">
      <input type="button" onClick="alert(jsphp_gcontent('..\ajaxinclude.php','prm1=1',false));" value="hello world" />
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
