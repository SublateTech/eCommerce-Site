<html>
<head>
<?php
  include ("hippo_ajax_form_class.php");
?>
</head>
<body>
<?php
  $frobj=new hippo_ajax_form();
  echo $frobj->form_start('form1', 'hippo_ajax_form_exec.php', 'showDiv1', false);
  
  /*Demo 1: Input Text*/
  echo '<table>';
  echo '<tr>';
  echo '<td>text1:</td>';
  echo '<td>';
  echo $frobj->add_input_text('text1');
  echo '</td></tr>';
  echo '<tr>';
  echo '<td>text2:</td>';
  echo '<td>';
  echo $frobj->add_input_text('text2', 'DavidLanz');
  echo '</td></tr>';
  echo '<tr>';
  echo '<td>text3:</td>';
  echo '<td>';
  echo $frobj->add_input_text('text3', '', true);
  echo '</td></tr>';
  echo '<tr>';
  echo '<td>text4:</td>';
  echo '<td>';
  echo $frobj->add_input_text('text4', '', '', 'Emily');
  echo '</td></tr>';
  echo '</table>';
  
  /*Demo 2: Form Controls*/
  echo '<table>';
  echo '<tr>';
  echo '<td>';
  echo 'checkbox:<br>';
  echo '</td>';
  echo '<td>';
  $ar = array('Client', 'PC', 'Server');
  echo $frobj->add_checkbox('checkbox1', 'hippo_ajax_form_exec.php', $ar);
  echo '</td>';
  echo '</tr>';
  
  echo '<tr>';
  echo '<td>';
  echo 'select:';
  echo '</td>';
  echo '<td>';
  $ar = array('Hippo', 'Emily', 'David');
  echo $frobj->add_select_list('select1', 'hippo_ajax_form_exec.php', $ar);
  echo '</td>';
  echo '</tr>';
  
  echo '<tr>';
  echo '<td>';
  echo 'radio:';
  echo '</td>';
  echo '<td>';
  $ar = array('Yes', 'No');
  echo $frobj->add_radio('radio1', 'hippo_ajax_form_exec.php', $ar);
  echo '</td>';
  echo '</tr>';
  
  echo '<tr>';
  echo '<td>';
  echo 'textarea:';
  echo '</td>';
  echo '<td>';
  echo $frobj->add_textarea('textarea1', 'hippo_ajax_form_exec.php');
  echo '</td>';
  echo '</tr>';
  echo '</table>';
  
  echo $frobj->form_end();
?>
<div id="showDiv1"></div>
</body>
</html>