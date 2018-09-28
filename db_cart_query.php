<?php

class cart_query
	{
		var $sort='';
		var $category='';
		var $brochure='';
		var $range='';
		var $search='';
		var $item='';
		var $sql_base = SQL; // "->Select * from cart_products Where ProductID > 0";
		var $sql;
	
	function cart_query()
		{
		}
	
	function get_query($inverse = false)
		{
			if (isset($_POST['Search']) && $_POST['Search']!="")
				{

					if ($inverse)	
						{
						$this->sql =  $this->sql_base.$this->get_inverse_item_sql().$this->get_Sort_sql();
						}
					else
						{
						$this->sql =  $this->sql_base.$this->get_item_sql().$this->get_Sort_sql();
						}
						
				}
			
			elseif (isset($_POST['SearchString']))
				{
					if ($inverse)	
						$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_SearchString_sql().$this->get_inverse_item_sql().$this->get_Sort_sql();
					else
						$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_SearchString_sql().$this->get_item_sql().$this->get_Sort_sql();
				}
			elseif (isset($_REQUEST['range']))
				{
					if ($inverse)	
						$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_range_sql().$this->get_inverse_item_sql().$this->get_Sort_sql();
					else
						$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_range_sql().$this->get_item_sql().$this->get_Sort_sql();
				}
			elseif (isset($_REQUEST['category']))
				if ($inverse)  //for category
			   		$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_category_sql().$this->get_inverse_item_sql().$this->get_Sort_sql();
				else
					$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_category_sql().$this->get_item_sql().$this->get_Sort_sql();
			elseif ($inverse)  //default
			   		$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_category_sql().$this->get_range_sql().$this->get_SearchString_sql().$this->get_inverse_item_sql().$this->get_Sort_sql();
				else
					$this->sql =  $this->sql_base.$this->get_brochure_sql().$this->get_category_sql().$this->get_range_sql().$this->get_SearchString_sql().$this->get_item_sql().$this->get_Sort_sql();
			
			return $this->sql;
		}
		
	function get_category_sql()
		{
			if (isset($_REQUEST['category']) && $_REQUEST['category'] != '')
				{
					if (isset($_SESSION['range']))
						unset($_SESSION['range']);
					if (isset($_SESSION['SearchString']))
							unset($_SESSION['SearchString']);

					
					if ($_REQUEST['category'] == 'All') {
						$this->category = '';
						if (isset($_SESSION['category']))
							unset($_SESSION['category']);
						}
					else {
						$this->category = $_REQUEST['category'];
						$_SESSION['category'] = $this->category;
						 }
					
				} elseif (isset($_SESSION['category']))
						$this->category = $_SESSION['category'];
								
						
			if ($this->category != '') {
				$sql = " And CategoryID = '". $this->category."'";
				return $sql; }
			else	
				return '';
	
	
		}
		
	function get_brochure_sql()
		{
			if (isset($_REQUEST['Brochure']) && $_REQUEST['Brochure'] != '')
				{
					$this->brochure = $_REQUEST['Brochure'];
					$_SESSION['brochure'] = $this->brochure;
					if (isset($_SESSION['category']))
						unset($_SESSION['category']);
					if (isset($_SESSION['range']))
						unset($_SESSION['range']);
					if (isset($_SESSION['SearchString']))
						unset($_SESSION['SearchString']);


						
				}elseif (isset($_SESSION['brochure']))
						$this->brochure = $_SESSION['brochure'];
			
			if ($this->brochure != '') {
				$sql = " And BrochureID = '". $this->brochure."'";
				return $sql; }
			else	
				return '';
	
	
		}
		
	function get_item_sql()
		{
			if (isset($_POST['Search']) && $_POST['Search'] != "" ) 
				{ 
				$this->item = $_POST['Search'];
				$_SESSION['item'] = $this->item;
				
				}
			
			if (isset($_REQUEST['item']) && $_REQUEST['item'] != '')
				{
					$this->item = $_REQUEST['item'];
					$_SESSION['item'] = $this->item;  
				}
			
			if ($this->item != '') {
				$sql = " And ProductID = '". $this->item."'";
				//$sql = " And   ProductID" .  " like '%" .$this->item. "%'";
				return $sql; }
			else	
				return '';
	
	
		}
	function get_inverse_item_sql()
		{
						
			if (isset($_REQUEST['item']) && $_REQUEST['item'] != '')
				{
					$this->item = $_SESSION['item'];
				}elseif (isset($_SESSION['item']) && $_SESSION['item'] != '')
					{
						$this->item = $_SESSION['item'];
					}
			
			if ($this->item != '') {
				$sql = " And ProductID <> '". $this->item."'";
				return $sql; }
			else	
				return '';
	
	
		}
	
	function get_SearchString_sql()
		{
						
			if (isset($_POST['SearchString']))
					{
						if (isset($_SESSION['category']))
							unset($_SESSION['category']);
						
						if (isset($_SESSION['range']))
							unset($_SESSION['range']);
				
						if ($_POST['SearchString'] == "" )
							{
							$this->search = '';
							if (isset($_SESSION['SearchString']))
								unset($_SESSION['SearchString']);
							}
						else
							{
							$search = $_POST['select'];
							switch ($search )
								{
								case "by Name":
									$this->search =  " And   Name_Eng" . " like '%" .  $_POST['SearchString'] . "%'";		
									break;
								case "by Description":
									$this->search = " And   Description" .  " like '%" .  $_POST['SearchString'] . "%'";
									break;
								case "by Item Number":
									$this->search = " And   ProductID" .  " like '%" .  $_POST['SearchString'] . "%'";
									break;
								case "por Español":
									$this->search = " And   Name_Spa" .  " like '%" .  $_POST['SearchString'] . "%'";
									break;
								default:
									$this->search='';
								}
							$_SESSION['SearchString'] = $this->search;
							 }
		
				}elseif (isset($_SESSION['SearchString']))
						$this->search = $_SESSION['SearchString'];

				 return $this->search;
		}
	
	function get_Sort_sql()
		{
						
			if (isset($_REQUEST['sort']))
				{
					//echo "What's up!!";
					$this->sort = $_POST['select'];
					$_SESSION['frmSort'] = $this->sort;
							 
		
				}elseif (isset($_SESSION['frmSort']))
						$this->sort = $_SESSION['frmSort'];
				else	{
						$this->sort = "by Item Number";
						$_SESSION['frmSort'] = $this->sort;
						}


				 switch ($this->sort )
								{
								case "by Price":
									$sort =  " ORDER BY  Price";		
									break;
								case "by Name":
									$sort =  " ORDER BY  Name_Eng";		
									break;
								case "by Description":
									$sort = " ORDER BY Description";
									break;
								case "by Item Number":
									$sort = " ORDER BY  ProductID";
									break;
								case "por Español":
									$sort = " ORDER BY Name_Spa";
									break;
								default:
									$sort = " ORDER BY  ProductID";
								}
				 return $sort;
		}
			
	function get_range_sql()
		{
				
				if (isset($_REQUEST['range']) && $_REQUEST['range'] != '')
					{
					if (isset($_SESSION['category']))
						unset($_SESSION['category']);
					if (isset($_SESSION['SearchString']))
						unset($_SESSION['SearchString']);

					
					if ($_REQUEST['range'] == 'All') {
						$this->range = '';
						if (isset($_SESSION['range']))
							unset($_SESSION['range']);
						}
					else {
						$range = $_REQUEST['range'];
						switch ($range )
							{
							case '10!':
								$this->range = " And Price = 10";
								break;
							case '20!':
								$this->range = " And Price = 20";
								break;
							case '10':
								$this->range = " And Price < ". $range;
								break;
							case '15':
								$this->range = " And Price >=10  And  Price < ". $range;
								break;
							case '20':
								$this->range = " And Price >=15  And  Price < ". $range;
								break;
							case '20>':
								$this->range = " And Price >=  20";
								break;
							default:
								$this->range = '';					
							}					
							$_SESSION['range'] = $this->range;
						 }
					
				} elseif (isset($_SESSION['range']))
						$this->range = $_SESSION['range'];

				 return $this->range;
	

		}


	}
?>