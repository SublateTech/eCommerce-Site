<?PHP
require_once("classes/MySql_class.php");
class Login extends MySql
	{
	
	function getUserInfo ($eMail, $pwr){
		global $name,$mysql;
		if (!$this->connection)
			{ die ("Could not connect to the database"); }
		else
			{
			$query1=$this->query("Select * from cart_customer WHERE UPPER(EMAIL) = UPPER('".$eMail."') AND PASSWORD='".$pwr."'");
			$fetch1=$this->fetchrowsobj($query1);
			}
			return $fetch1;
		}	
	
	}


?>