<?php
/* hippo_ajax_form class by DavidLanz
  
Function
========

Class Member Function
========
*/
echo '<script language=JavaScript src=css\hippo_ajax_form.js></script>';
class hippo_ajax_form
{
  var $err_str;
  var $urlPHP;
  var $targetDiv;
  var $idForm;
  var $intDIVCounter;
  var $splitter;
  
  /* Constructor */
  function hippo_ajax_form()
  {
    $this->intDIVCounter=0;
    $this->splitter='_';
    $this->init();
  }
  
  function init()
  {
    return true;
  }
  
  function form_start($idForm, $urlPHP, $targetDiv, $ifLoading=false)
  {
    $this->ifLoading = $ifLoading;
    $this->idForm = $idForm;
    $this->urlPHP = $urlPHP;
    $this->targetDiv = $targetDiv;
    return '<form id='.$this->idForm.' name='.$this->idForm.'>';
  }
  
  function add_input_text($idField, $passValue='', $ifPassword=false, $value='', $size=20)
  {
    if($idField=='')
    {
      $this->err_str='Error: add_input_text() parameter error.';
      return false;
    }
    else
    {
      if($ifPassword)
      {
        if($passValue=='')
        {
          return '<input id='.$idField.' name='.$idField.' size='.$size.' type=password >';
        }
        else
        {
          return '<input id='.$idField.' name='.$idField.' size='.$size.' type=hidden value='.$passValue.'>';
        }
      }
      else
      {
        if($passValue=='')
        {
          return "<input id=".$idField." name='".$idField."' size=".$size." type=text value='".$value."'>";
        }
        else
        {
          return '<input id='.$idField.' name='.$idField.' size='.$size.' type=hidden value='.$passValue.'>';
        }
      }
    }
  }
  
  function add_select_list($idField, $selected, $ar, $value = false)
  {
    if($ar=='' || count($ar)==0)
    {
      return false;
    }
    else
    {
      $strRet = '<select id='.$idField.' name='.$idField.'>';
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
  
  function add_checkbox($idField, $urlProcess, $ar)
  {
    if($ar=='' || count($ar)==0)
    {
      return false;
    }
    else
    {
      for($i=0; $i<count($ar); $i++)
      {
        $strRet .= '<input type=checkbox id='.$idField.'[] name='.$idField.'[] value=false onClick=checkFormInput(this,' . '\'' . $urlProcess . '\',' . '\'' . $this->idForm . '\'' . ')>'.$ar[$i].'<br>';
      }
      return $strRet;
    }
  }
  
  function add_radio($idField, $urlProcess, $ar)
  {
    if($ar=='' || count($ar)==0)
    {
      return false;
    }
    else
    {
      for($i=0; $i<count($ar); $i++)
      {
        $strRet .= $ar[$i].'<input type=radio id='.$idField.'[] name='.$idField.'[] value=false onClick=checkFormInput(this,' . '\'' . $urlProcess . '\',' . '\'' . $this->idForm . '\'' . ')>';
      }
      return $strRet;
    }
  }
  
  function add_textarea($idField, $urlProcess)
  {
    if($idField=='' || $urlProcess=='')
    {
      return false;
    }
    else
    {
      return '<TEXTAREA id='.$idField.' name='.$idField.'></TEXTAREA>';
    } 
  }
  
  function form_end($button='Update')
  {
    $strRet = '<div id=showSubmitDiv>';
    $strRet .='<input name=form_submit id=form_submit type=button onclick=sendFormData(' . '\'' . $this->idForm . '\',' . '\'' . $this->urlPHP . '\',' . '\'' . $this->targetDiv . '\',' .  '\'' . $this->ifLoading . '\''. ') value='.$button.'>';
    $strRet .='</div>';
    $strRet .='</form>';
    return $strRet;
  }
  
  function show_error()
  {
    return $this->err_str;
  } 
}

?>