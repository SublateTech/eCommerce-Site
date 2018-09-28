<?php
	/**
	 * formulaire
	 *	Date de création : 21 Août 2006
	 * 	Dernière modification: 20 Novembre 2006
	 * 	Classe qui permet de créer des formulaires HTML, offre la possibilité de mettre des champs
	 * 	obligatoires et de valider.
	 */
	class db_form
	{
		// Variables de la classe	
		var $title;							// Nom du formulaire
		var $action='';						// Action du formulaire
		var $method='POST';						// Méthode du formulaire (post par défaut)
		var $obligatoireFont;				// Le caractère qui indique que l'objet est obligatoire
		var $Objets = array();				// Les objets que contient le formulaire
		var $tableCSS;						// La classe CSS du <table> principal
		var $errorBoxCSS;					// La classe CSS de l'error box
		var $tdCSS;							// La classe CSS des <td>
		var $errors = array();				// Liste des erreurs
		var $event;
		
		/**
		 * Formulaire
		 *
		 * @param string $name
		 * @param string $method
		 * @param string $action
		 * Constructor
		 */
		function db_form($name = "",$method = "post",$action = "")
		{
			if(isset($_SERVER['QUERY_STRING']))
				$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
			else
				$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];

			$this->title = $name;
			
			if(strlen($action) > 0)
				$this->action = $action;
			else 
				$this->action = $_SERVER['REQUEST_URI'];
				
			$this->method = $method;
			
		}
		
		/**
		 * Crée l'entête HTML du formulaire
		 */
		function start()
		{
			print '<form name="'.$this->title.'" method="'.$this->method.'" action="'.$this->action.'">';
		}
		
		/**
		 * Crée le pied HTML du formulaire
		 */
		function close()
		{
			print '</form>';
		}

		/**
		 * Ajoute le message d'erreur dans le tableau errors[]
		 *
		 * @param string $message
		 */
		function WriteMessage($message)
		{
			$this->errors[] = $message;
		}
		
		/**
		 * Ajoute un objet de type TextBox au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $label
		 * @param boolean $obligatoire
		 * @param string $value
		 * @param integer $size
		 * @param string $cssClass
		 * @param boolean $isPassword
		 */
		function TextBox($name, $label = "", $obligatoire = true, $value = "", $size = 20, $cssClass = "default", $isPassword = false)
		{
			$name_obj = new TextBox($name, $label,$obligatoire, $value,$size,$cssClass,$isPassword);
			if ($name != '' )
				$this->Objets[$name] = $name_obj;
			else
				$this->Objets[] = $name_obj;
		}
		
		/**
		 * Ajoute un objet de type CheckBox au tableau Objets[]
		 *
		 */
		function Check($name='', $label = "", $value = false, $cssClass = "default", $event='')
		{
			
			$name_obj = new CheckBox($name, $value, $label, $cssClass,$event);
			if ($name != '' )
				$this->Objets[$name] = $name_obj;
			else
				$this->Objets[] = $name_obj;
		}
		/**
		 * Ajoute un objet de type TextBox mais en mode readonly au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $text
		 * @param string $cssClass
		 */
		function StaticText($name, $label, $text, $cssClass = "default")
		{
			$name = new StaticText($name, $label, $text, $cssClass);
			$this->Objets[] = $name;
		}

		/**
		 * Ajoute un objet de type TextArea au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $label
		 * @param boolean $obligatoire
		 * @param string $value
		 * @param integer $width
		 * @param integer $height
		 * @param string $cssClass
		 */
		
		function TextArea($name, $label = "", $obligatoire = false, $value = "",$width = 200, $height = 100, $cssClass = "default")
		{
			$name_obj = new TextArea($name,$label,$obligatoire,$value,$width,$height,$cssClass);
			if ($name != '' )
				$this->Objets[$name] = $name_obj;
			else
				$this->Objets[] = $name_obj;
		}
		
		/**
		 * Ajoute un objet de type DateList au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $cssClass
		 * @param datetime $defaultDate
		 */
		function DateList($name, $label = "Date :", $cssClass = "default", $defaultDate = "today")
		{
			if($defaultDate == "today")
				$defaultDate = date("Y-m-d");
			$name = new DateSelect($name, $label, $cssClass, $defaultDate);
			$this->Objets[] = $name;
		}
		
		/**
		 * Ajoute un objet de type Button au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $value
		 * @param string $type
		 * @param string $cssClass
		 */
		function Button($name, $value = "Envoyer", $type = "submit", $cssClass = "default")
		{
			$name_obj = new Button($name, $value, $type, $cssClass);
			if ($name != '' )
				$this->Objets[$name] = $name_obj;
			else
				$this->Objets[] = $name_obj;

		}
		
		/**
		 * Ajoute un objet quelquoncque au tableau Objets[]
		 *
		 * @param object $objet
		 */
		function Objet($objet)
		{
			$this->Objets[] = $objet;
		}
		
		/**
		 * Ajoute un champ caché au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $value
		 */
		function Hidden($name, $value="")
		{
			$h = new Hidden($name,$value);
			$this->Objets[] = $h;
		}
		
		/**
		 * Ajoute un objet de type File au tableau Objets[]
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $cssClass
		 */
		function File($name, $label = "", $cssClass = "default")
		{
			$name = new File($name, $label, $cssClass);
			$this->Objets[] = $name;
		}
		
		/**
		 * Affiche le formulaire dans une <table> avec les noms des champs à gauche.
		 */
		function Afficher()
		{
			$obligatoires = 0;
			// Début du formulaire

			print '<form enctype="multipart/form-data" method="'.$this->method.'" action="'.$this->action.'" name="'.$this->title.'">';
			print '<table width="100%" cellpadding="2" cellspacing="0" class="'.$this->tableCSS.'" align="center">';
				
			// Création des inputs de type text et textarea
			foreach($this->Objets as $objet)
			{
				if(isset($objet->label))
				{
					if(isset($objet->obligatoire))
					{
						if($objet->obligatoire)
						{
							$obligatoires++;
							$asterisque = $this->obligatoireFont;
						}
						else 
							$asterisque = "";
					}
					else 
						$asterisque = "";
					print '
						<tr>
						<td valign="middle" align="right" class="'.$this->tdCSS.'">'.$objet->label.'
						</td>
						<td valign="top">
					';
					$objet->Show();
					print 
					$asterisque.'
						</td>
						</tr>
					';
				}
				else
				{
					if(!isset($objet->hidden))
					{
						print '
							<tr>
							<td colspan="2" align="center" class="'.$this->tdCSS.'">
						';
						$objet->Show();
						print '
							</td>
							</tr>
						';
					}
					else 
						$objet->Show();
				}
			}
			
			if($obligatoires > 0 && strlen($this->obligatoireFont) > 0)
			{
				print '
					<tr>
					<td colspan="2" style="font-size: x-small; font-family: verdana" align="center">
						'.$this->obligatoireFont.' Le champ est obligatoire.
					</td>
					</tr>';
			}
			
			// Fin du formulaire
			print '</table>';
			$this->close();
		}

		/**
		 * Affiche le formulaire simplement, le titre de l'objet par dessus
		 */
		function AfficherSimple()
		{
			print '<form method="'.$this->method.'" action="'.$this->action.'" name="'.$this->title.'">';
			print '<span class="'.$this->tdCSS.'">';
			foreach($this->Objets as $objet)
			{
				if(isset($objet->label))
				{
					print $objet->label;
					print '<br/>';
					$objet->Show();
					print '<br/>';	 
				}
				else 
				{
					$objet->Show();
					if(!isset($objet->hidden))
						print '<br/>';
				}
			}
			print '</span>';
			print '</form>';
		}
		
		/**
		 * Génère le script SQL pour insérer les données dans une table SQL, le nom des champs doit correspondre
		 * avec celui de la base de donnée
		 *
		 * @param string $table
		 * @return string
		 */
		function SQL_InsertValues($table)
		{
			$r = "INSERT INTO ".$table." VALUES('',";
			foreach($this->Objets as $objet)
			{
				if(isset($objet->label) && isset($objet->name))
				{
					$name = $objet->name;
					switch($this->method)
					{
						case "post":
							$r .= "'".$_POST[$name]."',";
							break;
						case "get":
							$r .= "'".$_GET[$name]."',";
							break;
						default :
							$r = "ERREUR";
							return;
					}
				}
			}
			$r = substr($r,0,strlen($r) - 1);
			$r .= ")";
			
			return $r;
		}
		
		/**
		 * Génère le script SQL selon le formulaire, le nom des champs correspond à ceux de la table
		 *
		 * @param unknown_type $nomTable
		 * @return string
		 */
		function SQL_CreateTable($nomTable)
		{
			$r = "CREATE TABLE ".$nomTable." ( id int(11) NOT NULL auto_increment, ";
			foreach($this->Objet as $objet)
			{
				$r .= $objet->name." text NOT NULL, ";
			}
			$r .= "PRIMARY KEY (id) )";
			return $r;
		}
		
		/**
		 * Valide si tous les champs obligatoires du formulaire sont bien remplies, et valide les courriels
		 * si le nom de l'objet est courriel ou email
		 *
		 * @return boolean
		 */
		function Valider()
		{
			$ctr = 0; // Compteur qui contient le nombre de champs obligatoires non-remplis
			foreach($this->Objets as $objet)
			{
				if(isset($objet->obligatoire) && $objet->obligatoire)
				{
					switch($this->method)
					{
						case "post":
						{
							if(!isset($_POST[$objet->name]) || strlen($_POST[$objet->name]) == 0)
							{
								$ctr++; // Incrémentation du compteur
								$label = trim(strtolower(str_replace(":","",$objet->label)));
							
								$this->WriteMessage("Le champ <b>".$label."</b> est vide.");
							}
							else
							{
								if(substr_count("courriel",$objet->name) > 0 || substr_count("email",$objet->name) > 0)
								{
									if(!verifEmail($_POST[$objet->name]))
									{
										$ctr++;
										$this->WriteMessage("Le courriel est invalide.");
									}
								}
							}	
						}
							break;
						case "get":
						{
							if(!isset($_GET[$objet->name]) || strlen($_GET[$objet->name]) <= 0)
							{
								$ctr++; // Incrémentation du compteur
								$label = str_replace(":","",$objet->label);
							
								$this->WriteMessage("Le champ <b>".$label."</b> doit être rempli");
							}
							else
							{
								if(substr_count("courriel",$objet->name) <= 0)
								{
								$ctr++;
								if(!verifEmail($_GET[$objet->name]))
									$this->WriteMessage("Le courriel est invalide");
								}
							}
						}
							break;
					}
				}
			}
			// Effectuer ce IF seulement s'il y a des champs obligatoires qui n'ont pas été remplis.
			if($ctr > 0 || count($this->errors) > 0)
			{
				print '
					<center>
					<div class="'.$this->errorBoxCSS.'">
					
				';
				foreach($this->errors as $string)
				{
					print $string."<br/>";
				}
				print "</div></center>";
				return false; // Valeur de retour false, afin de dire que le formulaire n'a pas été validé.
			}
			else 
				return true; // Valeur de retour true, afin de dire que le formulaire a été validé.
		}
		
		/**
		 * Obtient la date dans un format valide pour SQL à partir d'un élément $_POST. Il suffit d'y passer le nom
		 *
		 * @param string $dateselect
		 * @return datetime
		 */
		function GetDate($dateselect)
		{
			$date = $_POST['a'.$dateselect]."-".$_POST['m'.$dateselect]."-".$_POST['j'.$dateselect];
			return $date;
		}
		
	}
	
	
	/**
	 * Select
	 * 	Crée un objet de type <select> et permet d'ajouter des <option>
	 */
	class Select
	{
		// Variables de l'objet
		var $name;
		var $size;
		var $label;
		var $cssClass;
		var $options = array();
		
		/**
		 * Constructeur : Instancie un nouvel objet de type Select
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $cssClass
		 * @param integer $size
		 */
		function select($name = "select", $label = "", $cssClass = "default", $size=1)
		{
			$this->name = $name;
			$this->label = $label;
			$this->size = $size;
			$this->cssClass = $cssClass;
		}
		
		/**
		 * Ajoute un <option> au tableau options[] qui contient toute les options du Select
		 *
		 * @param string $value
		 * @param string $label
		 * @param boolean $selected
		 */
		function addOption($value = "", $label = "", $selected = false)
		{
			if($label == "")
				$label = $value;
				
			$this->options[] = array("value"	=> $value,
									 "label"	=> $label,
									 "selected" => $selected);
		}
		
		/**
		 * Affiche l'objet avec les options du tableau options[]
		 */
		function Show()
		{
			print '<select class="'.$this->cssClass.'" name="'.$this->name.'" size="'.$this->size.'">';
			foreach($this->options as $option)
			{
				print '<option value="'.$option["value"].'"
				';
				if($option["selected"])
					print ' SELECTED';
				print '
					>'.$option["label"].'</option>';
			}
			print '</select>';
		}
		
	} 
	
	/**
	 * TextBox
	 *	Crée un objet de type <input type="text">
	 */
	class TextBox
	{
		var $name, $label, $obligatoire, $value, $size, $cssClass, $isPassword, $readonly;
		
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $label
		 * @param boolean $obligatoire
		 * @param string $value
		 * @param integer $size
		 * @param string $cssClass
		 * @param boolean $isPassword
		 * @param boolean $readonly
		 */
		function TextBox($name, $label = "",$obligatoire, $value="", $size = 20, $cssClass = "default", $isPassword)
		{
			$this->name = $name;
			$this->label = $label;
			$this->value = $value;
			$this->size = $size;
			$this->cssClass = $cssClass;
			$this->obligatoire = $obligatoire;
			$this->isPassword = $isPassword;
		}

		/**
		 * Affiche l'objet sous format HTML
		 */
		function Show()
		{
			if($this->isPassword) 	$type = "password";
			else 					$type = "text";
			if($this->readonly)		$readonly = " readonly ";
			else 					$readonly = "";
			print '<input type="'.$type.'" name="'.$this->name.'" size="'.$this->size.'" 
				    value = "'.$this->value.'" class="'.$this->cssClass.'" '.$readonly.'>
			';
		}
	}
	
	/**
	 * TextArea
	 *	Crée un objet de type <textarea>
	 */
	class TextArea
	{
		var $name, $label, $obligatoire, $value, $width, $height, $cssClass;
		
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $label
		 * @param boolean $obligatoire
		 * @param string $value
		 * @param integer $width
		 * @param integer $height
		 * @param string $cssClass
		 */
		function TextArea($name, $label = "", $obligatoire, $value = "", $width = 200, $height = 50, $cssClass = "")
		{
			$this->name = $name;
			$this->label = $label;
			$this->value = $value;
			$this->width= $width;
			$this->height = $height;
			$this->obligatoire = $obligatoire;
			$this->cssClass = $cssClass;
		}
		
		/**
		 * Affiche l'objet en format HTML
		 */
		function Show()
		{
			print '<textarea name="'.$this->name.'" style="width:'.$this->width.';height:'.$this->height.'" class="'.$this->cssClass.'">'.$this->value.'</textarea>';
		}
	}
	
	/**
	 * Button
	 *	Crée un objet de type <input type="button">
	 */
	class Button
	{
		var $name, $value, $type, $cssClass;
		
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $value
		 * @param string $type
		 * @param string $cssClass
		 */
		function Button($name, $value, $type, $cssClass)
		{
			$this->name = $name;
			$this->value = $value;
			$this->type = $type;
			$this->cssClass = $cssClass;
		}
		
		/**
		 * Affiche l'objet en format HTML
		 */
		function Show()
		{
			print '<input name="'.$this->name.'" type="'.$this->type.'" value="'.$this->value.'" class="'.$this->cssClass.'">';
		}
	}
	
	/**
	 * File
	 *	Crée un objet de type <input type="file">
	 */
	class File
	{
		var $name, $label, $cssClass;
		
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $cssClass
		 */
		function File($name, $label, $cssClass)
		{
			$this->name = $name;
			$this->label = $label;
			$this->cssClass = $cssClass;
		}
		
		/**
		 * Affiche l'objet en format HTML
		 */
		function Show()
		{
			print '<input type="file" name="'.$this->name.'" class="'.$this->cssClass.'">';
		}
	}
	
	/**
	 * Hidden
	 *	Crée un objet de type <input type="hidden">
	 */
	class Hidden
	{
		var $name, $value, $hidden;
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $value
		 */
		function Hidden($name, $value)
		{
			$this->hidden = true;
			$this->name = $name;
			$this->value = $value;
		}
		
		/**
		 * Affiche l'objet en format HTML
		 */
		function Show()
		{
			print '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'"/>';
		}
	}
	
	/**
	 * CheckBox
	 *	Crée un objet de type <input type="checkbox"> 
	 */
	class CheckBox
	{
		var $name, $value, $label, $cssClass, $event;

		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $value
		 * @param string $label
		 * @param string $cssClass
		 */
		function CheckBox($name, $value=false, $label, $cssClass = "default", $event='')
		{

			$this->label = $label;
			$this->cssClass = $cssClass;
			$this->name = $name;
			$this->value = $value;
			$this->event = $event;
						
		}
		
		/**
		 * Affiche l'objet sous format HTML
		 */
		function Show()
		{
			if ($this->value)
				echo '<input class="'.$this->cssClass.'" name="'.$this->name.'" type="checkbox"  checked="checked" '.$this->event.' > '.$this->label.'<br/>';
			else
				echo '<input class="'.$this->cssClass.'" name="'.$this->name.'" type="checkbox"  '.$this->event.' > '.$this->label.' <br/>';	
			
				
		}
	}
	
	/**
	 * Radio
	 *	Crée un objet de type <input type="radio">
	 */
	class RadioButton
	{
		var $name, $value, $label, $cssClass;

		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $value
		 * @param string $label
		 * @param string $cssClass
		 */
		function RadioButton($name, $value, $label, $cssClass = "default")
		{
			$this->label = $label;
			$this->cssClass = $cssClass;
			$this->name = $name;
			$this->value = $value;
		}
		
		/**
		 * Affiche l'objet sous format HTML
		 */
		function Show()
		{
			print '<input class="'.$this->cssClass.'" name="'.$this->name.'" type="radio" value="'.$this->value.'"> '.$this->label.'<br/>';
		}
	}

	/**
	 * DateSelect
	 *	Crée un objet contenant 3 listes déroulantes, le jour, le mois, l'année, peut se faire
	 * 	attribuer une date par défaut.
	 */
	class DateSelect 
	{
		var $name, $label, $cssClass, $defaultDate;
		/**
		 * Constructeur : Instancie l'objet
		 *
		 * @param string $name
		 * @param string $label
		 * @param string $cssClass
		 * @param datetime $defaultDate
		 */
		function DateSelect($name, $label, $cssClass, $defaultDate)
		{
			$this->cssClass = $cssClass;
			$this->label = $label;
			$this->name = $name;
			$this->defaultDate = $defaultDate;
		}
		
		/**
		 * Affiche l'objet sous format HTML
		 */
		function Show()
		{
			if(strlen($this->defaultDate) > 0 && substr_count($this->defaultDate,"-") == 2)
				list($dAnne,$dMois,$dJour) = explode('-',$this->defaultDate);
				
			$months = array(	1 => "Janvier",
								2 => "Février",
								3 => "Mars",
								4 => "Avril",
								5 => "Mai",
								6 => "Juin",
								7 => "Juillet",
								8 => "Août",
								9 => "Septembre",
								10 => "Octobre",
								11 => "Novembre",
								12 => "Décembre"	);
								
			$jour = new Select("j".$this->name, "", $this->cssClass);
			for($i = 1; $i <= 31; $i++)
			{
				$selected = false;
				
				if(isset($dJour))
				{
					if($dJour == $i)
						$selected = true;
				}
				
				$jour->addOption($i,$i,$selected);
			}
			
			$mois = new Select("m".$this->name, "", $this->cssClass);
			for($i = 1; $i <= 12; $i++)
			{
				$selected = false;
				if(isset($dMois))
				{
					if($dMois == $i)
						$selected = true;
				}
				$mois->addOption($i,$months[$i],$selected);
			}
			
			$annee = new Select("a".$this->name, "", $this->cssClass);
			for($i = 1960; $i <= 2009; $i++)
			{
				$selected = false;
				
				if(isset($dAnne))
				{
					if($dAnne == $i)
						$selected = true;
				}
				$annee->addOption($i,$i,$selected);
			}
			
			$jour->Show();
			$mois->Show();
			$annee->Show();
		}
	}

	/**
	 * Fonctions qui peuvent être utile pour le traitement d'un formulaire
	 */
		
	/**
	 * Fonction qui valide une adresse courriel avec une expression régulière.
	 *
	 * @param string $email
	 * @return boolean
	 */
	function verifEmail($email)
	{
		return preg_match("!^[a-zA-z0-9._-]+@[a-zA-z0-9._-]{2,}\.[a-z]{2,4}$!",$email);
	}

	/**
	 * Vérifie qu'aucune balise de format HTML ne soit insérer
	 *
	 * @param string $string
	 * @return boolean
	 */
	function verifHTML($string)
	{
		$expHTML = "!<+[a-zA-Z0-9 =\"'/@%;:]+>!";
		if(!preg_match($expHTML,$string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>