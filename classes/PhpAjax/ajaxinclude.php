<?php
  
  if(!defined('JSPHP_INC')) die('YOU ARE NOT ALLOWED TO ACCESS THIS FILE DIRECTLY');

  //example 1
  if(isset($_REQUEST['prm1'])) echo 'HELLO WORLD!';
  
  if(isset($_REQUEST['prm2'])){
    $artemp[]='test1';
    $artemp[]='test2';
    $artemp[]='test3';
    $artemp[]='test4';
    $artemp[]='test5';
    
    echo $artemp[$_REQUEST['index']];
  }
  
  if(isset($_REQUEST['prm3'])){
    for($i=0;$i<5;$i++){
    ?>
    
    <p>Lorem ipsum dolor sit amet consectetuer tincidunt nulla Proin fringilla id. Sed enim felis id consequat feugiat molestie Curabitur consequat in nec. Egestas condimentum Vivamus ornare convallis ligula quam accumsan pretium pellentesque habitant. Nunc Curabitur non porttitor id vel dictumst Maecenas felis interdum lacinia. A vitae sed et fringilla urna in suscipit amet condimentum ante. Ut.</p>
    <p>Nonummy feugiat malesuada auctor elit quam massa dictum Proin eget cursus. Quis dui penatibus Donec Morbi cursus Nullam auctor justo Curabitur hendrerit. Eu eros dictum est ante vel dis interdum hendrerit sapien quis. Vestibulum eros est Vestibulum gravida sociis Fusce scelerisque auctor eleifend Sed. Ut Vestibulum Phasellus nunc in augue ligula pharetra et metus cursus. Lacus.</p>
    
    
    <?
    }
  }
  
  if(isset($_REQUEST['prm4'])){
    $jsphp->addAlert('textcolor will be modified...');
    $jsphp->setStyle('cmdiv','color','red');
    $jsphp->output();
  }
  
?>
