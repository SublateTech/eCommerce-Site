<?php  
  /* Requires */
  require('hippo_ajax_form_func.php');
  
  /* Submit Data */
  if(isset($_POST['aryFormData']))
  {
    $aryFormData = $_POST['aryFormData'];
    /*Usage:
    echo 'debug='.$aryFormData['text1'][0].'<br>';
    */
    foreach ($aryFormData as $key => $value )
    {
      foreach ($value as $key2 => $value2 )
      {
        echo $key.'=>'.strip_tags($value2).'<br>';
      }
    }
  }
  else /*Else: if(isset($_POST['aryFormData']))*/
  {
  } /*End: if(isset($_POST['aryFormData']))*/
  
  
?>
