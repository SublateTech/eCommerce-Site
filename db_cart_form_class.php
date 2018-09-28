<?
require_once('classes/form.class.php'); 
class db_cart_form_class extends db_form
{


	function form_start($name, $href='', $div='', $bool=false)
		{
			$this->title = $name;
			$this->action = $href;
			$this->start();
			
		}
		
	function Label($text='', $require=false)
	{
	
		if ($require)
			echo "<p class='label_short'>"."<font id='require'>"."*"."</font>".$text."</p>";	
		else		
			echo "<p class='label_short1'>".$text."</p>";
	
	}
		
	function form_end($show=false, $button_name='submit_form', $button_value = '')
		{
			$this->Button($button_name==''?"submit_form":$button_name, $button_value=='' ? "Update" : $button_value, "submit", "default");
			echo $show ? '<br>' : '<div id=\'showSubmitDiv\' style="display:none;" >';
			$this->Objets[$button_name==''?"submit_form":$button_name]->show();
			echo $show ? '' : '</div>';
			$this->close();
		}
		
		
	function input_text($text, $idField, $passValue, $ifPassword, $value, $size,$require=false)
	 {?>
	 			
		<tr align="left" valign="middle">	
			<td width="50%">
			<?php
				if ($require)
					echo "<p class='label'>"."<font id='require'>"."*"."</font>".$text."</p>";	
				else		
					echo "<p class='label'>".$text."</p>";
			?>
			
			</td>
			<td>	
				<?php
						$this->TextBox($idField, '', true, $value, $size, "default",$ifPassword);	
						echo $this->Objets[$idField]->show();
				?>

			
			</td>
		</tr>
			
	<?php
	/*	
		echo "<tr><td align='left' colspan='4'>";
		if ($require)
			echo "<p class='label'>"."<font id='require'>"."*"."</font>".$text."</p>";	
		else		
			echo "<p class='label'>".$text."</p>";
		$this->TextBox($idField, '', true, $value, $size);	
		echo "<p class='text'>".$this->Objets[$idField]->show()."</p>";
		echo '</td></tr>';*/
	
	 }
	 
	 //TextArea($name, $label = "", $obligatoire = false, $value = "",$width = 200, $height = 100, $cssClass = "default")
	 function input_text_area($text, $idField, $value, $width , $height, $require=false)
	 {?>
	 
			
		<tr align="left" valign="middle">	
			<td width="50%">
			<?php
				if ($require)
					echo "<p class='label'>"."<font id='require'>"."*"."</font>".$text."</p>";	
				else		
					echo "<p class='label'>".$text."</p>";
			?>
			
			</td>
			<td>	
				<?php
						$this->TextArea($idField, '',false, $value, $width, $height, "default");	
						echo $this->Objets[$idField]->show();
				?>

			
			</td>
		</tr>
			
	<?php
	/*	
		echo "<tr><td align='left' colspan='4'>";
		if ($require)
			echo "<p class='label'>"."<font id='require'>"."*"."</font>".$text."</p>";	
		else		
			echo "<p class='label'>".$text."</p>";
		$this->TextBox($idField, '', true, $value, $size);	
		echo "<p class='text'>".$this->Objets[$idField]->show()."</p>";
		echo '</td></tr>';*/
	
	 }
	 
	 function Check_button($name, $label = "", $value = "", $cssClass = "default", $event='')
	 {
			
		$this->Check($name, $label, $value,'', $event);
		echo "<tr ><td width=\"50%\" align='center' colspan='2'>";
		//echo "<p class='label'>".$label."</p>";
		echo "</td><td><p class='text'>".$this->Objets[$name]->show()."</p>";
		echo '</td></tr>';
	
	 }
	 
	 function select_list($text, $idField, $selected, $ar, $value, $require=false, $add_value=false, $event='')
	   {
	   
		if ($selected == '')
			$default = true;
		else
			$default = false;
			
		echo "<tr><td width=\"50%\" align='left' colspan='1'>";
		if ($require)
			echo "<p class='label'>"."<font id='require'>"."*"."</font>".$text."</p>";	
		else
			echo "<p class='label'>".$text."</p>";
			
		if (!$add_value)
			echo "</td><td align='left'>".$this->add_select_list($idField, $selected, $ar, $value, $default, $event);
		else
			echo "</td><td  align='left'>".$this->add_select_list_value($idField, $selected, $ar, $value, $default, $event);
		echo '</td></tr>';

	  	
	  }
	  
	  
	  function validate($module='')
	  	{
			require_once ("db_cart_validate.php");
			$db_validate = new  db_cart_validate();
			$result = $db_validate->validate($module);
			$this->error = $db_validate->error;
			return  $result;
		}
		
	function add_select_list($idField, $selected, $ar, $value = false, $default = true, $event='')
  	{
    	if($ar=='' || count($ar)==0)
    	{
      	return false;
    	}
    	else
    	{
      		if ($event=='')
				$strRet = '<select id='.$idField.' name='.$idField.'>';
			else
				$strRet = '<select id='.$idField.' name='.$idField.' '.$event.'>';
				
      		if ($default)
				$strRet.= "<option value='Default'>Select</option>";
      		for($i=0; $i<count($ar); $i++)
      		{
        	if ($value)
				if ($ar[$i] == $selected)
					$strRet.= "<option value='".$ar[$i]."' selected>".$ar[$i].'</option>';	
				else
					$strRet.= "<option value='".$ar[$i]."'>".$ar[$i].'</option>';
			else
				if ($i+1 == $selected)
					$strRet.= "<option value='".($i+1)."' selected>".$ar[$i].'</option>';	
				else
				$strRet.= "<option value='".($i+1)."'>".$ar[$i].'</option>';
		
      			}
      		$strRet.= '</select>';
      	return $strRet;
    }
	
  }
  
  	function add_select_list_value($idField, $selected, $ar, $value = false, $default = true, $event='')
  	{	
    	if($ar=='' || count($ar)==0)
    	{
      	return false;
    	}
    	else
    	{
      		if ($event=='')
				$strRet = '<select id='.$idField.' name='.$idField.'>';
			else
				$strRet = '<select id='.$idField.' name='.$idField.' '.$event.'>';

      		if ($default)
				$strRet.= "<option value='Default'>Select</option>";
      		for($i=0; $i<count($ar); $i++)
      		{
        	if ($value){
				
				if (trim($ar[$i][1]) == trim($selected))
					$strRet.= "<option value='".$ar[$i][1]."' selected>".$ar[$i][0].'</option>';	
				else
					$strRet.= "<option value='".$ar[$i][1]."'>".$ar[$i][0].'</option>'; }
			else
				if ($i+1 == $selected)
					$strRet.= "<option value='".($i+1)."' selected>".$ar[$i][0].'</option>';	
				else
				$strRet.= "<option value='".($i+1)."'>".$ar[$i][0].'</option>';
		
      			}
      		$strRet.= '</select>';
      	return $strRet;
    }
}

	
// first update eventually modified data
}

/*
if (isset($_POST['button']) && $_POST['button'] != '')
	echo $_POST['text1'];


$db_form = new db_cart_form1( "form1","post","");
$db_form->start();
$db_form->TextBox('text1', '', true, "", 20);
$db_form->Button('button', "Envoyer", "submit", "default");
$db_form->Objets['text1']->show();
echo $db_form->Objets['text1']->name;
$db_form->Objets['button']->show();
$db_form->close();
*/

/*
			echo "<script language=\"javascript\" type=\"text/javascript\">";
			echo "javascript:ajaxpage('db_cart_validate.php?module=".$module."','error')";
			echo "</script>";*/

?>