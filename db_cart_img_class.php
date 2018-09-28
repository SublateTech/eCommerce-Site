<?PHP

/*****************************************************************
/*    Class to embed and extract images to/from a mysql database *
/*																 *
/*    Free software- GNU/GPL (C)Can Ince 17-January-2005  		 *
/*	  http://www.forabilisim.net								 *
/*****************************************************************/

class Img2Mysql 
{

	var $connection;
	var $user;
	var $password;
	var $database;
	var  $server;
	
	var $query, $result, $row;
	
	var $rowset = array();
	var $num_querys = 0;
	
	function Img2Mysql( $user, $password, $server, $database )
	{
	
		$this->server = $server;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		
		$this->connection = @mysql_connect( $this->server, $this->user, $this->password );
		
		if( $this->connection )
		{
			if( $database != '' )
			{
				$dbselect = @mysql_select_db( $this->database, $this->connection );
				if( !$dbselect )
				{
					@mysql_close( $this->connection);
					$this->connection = $dbselect;
				}
			}
			return $this->connection;
		} else
			return false;
	}
	
	function close()
	{
		unset( $query );
		unset( $result );
		unset( $row );
		$this->free();
		return @mysql_close( $this->connection );
	}
	
	function change_db( $database )
	{
		if( $database != '' )
		{
			$dbselect = @mysql_select_db( $database, $this->connection );
			$this->database = $database;
			if( !$dbselect )
			{
				@mysql_close( $this->connection );
				$this->connection = $dbselect;
			} else
				return true;
		} else {
			return false;
		}
	}
	
	function query( $query = '' )
	{
		if( $query != '' )
		{
			$this->result = @mysql_query( $query, $this->connection );
			$this->num_querys++;
		}
		if( $this->result )
		{
			return $this->result;
		} else 
			return false;
	}
	
	function numrows( $result = 0 )
	{
		if( !$result )
		{
			$result = $this->result;
		}
		
		if( $result )
		{
			return @mysql_num_rows( $result );
		} else
			return false;
	}
	
	function fetchrows( $result = 0 )
	{
		if( !$result )
		{
			$result = $this->result;
		}
		
		if( $result )
		{
			return @mysql_fetch_array( $result );
		} else
			return false;
	}
	
	function fetchrow( $result = 0 )
	{
		return $this->fetchrows( $result );
	}
	
	function fetchrowset( $result = 0 )
	{
		if( !$result )
		{
			$result = $this->result;
		}
		
		if( $result )
		{
			unset( $this->rowset[$result] );
			while( $this->rowset[$result] = $this->fetchrows( $result ) )
			{
				$return[] = $this->rowset[$result];
			}
			return $return;
		} else
			return false;
	}
	
	function free( $result = 0 )
	{
		if( !$result )
		{
			$result = $this->result;
		}
		
		if( $result )
		{
			unset($this->rowset[$result] );
			@mysql_free_result($result);
			return true;
		} else
			return false;
	}
	
	function tell_querys()
	{
		return $this->num_querys;
	}
	function nextid()
	{
		if( $this->connection )
			return @mysql_insert_id( $this->connection );
		else
			return false;
	}
	
	function error()
	{
		$result['message'] = @mysql_error( $this->connection );
		$result['code'] = @mysql_errno( $this->connection );
		return $result;
	}
	
	function getData() {

if (!$mysql->connection)
die ("Could not connect to the database");

$query1=$mysql->query("select * from ProductImg");
$n=0;
while ($fetch1=$mysql->fetchrows($query1)) {
	$id[$n]=$fetch1[id];
	$imgname[$n]=$fetch1[imgname];
	$imgcontent[$n]=$fetch1[imgcontent];
	$n++;
		}
	}
	
	function getImageByName ($imgname){
	global $id,$imgcontent,$mysql;
	
	if (!$mysql->connection) {
die ("Could not connect to the database");
} 
$query1=$mysql->query("select * from main where `imgname` = '$imgname'");
$fetch1=$mysql->fetchrows($query1);
	$imgcontent=$fetch1["Small"];
	$imgcontent=base64_decode($imgcontent);
	return $imgcontent;
	}
	
	function getImageById1 ($id){
	global $imgname,$imgcontent,$mysql;
	if (!$mysql->connection)
		die ("Could not connect to the database");
	$query1=$mysql->query("select Small from ProductImg where ProductID='$id'");
	$fetch1=$mysql->fetchrows($query1);
	$imgcontent=$fetch1['Small'];
	$imgcontent=base64_decode($imgcontent);
	return $imgcontent;
	}

	function getImageById ($id){
	global $imgname,$imgcontent,$mysql;
	if (!$mysql->connection)
		die ("Could not connect to the database");
	$query1=$mysql->query("select Small from ProductImg where ProductID='$id'");
	$fetch1=$mysql->fetchrows($query1);
	$imgcontent=$fetch1['Small'];
	$imgcontent=base64_decode($imgcontent);
	return $imgcontent;
	}

	
	function image2Sql($imgpath,$imgname) {
	global $id,$imgcontent,$mysql;
	if (!$mysql->connection)
		die ("Could not connect to the database");
	$handle = fopen($imgpath, "r");
	while (!feof($handle)) {
	$buffer = fgets($handle, 4096);
    $total.=$buffer;
		}
	fclose($handle);
	$total=base64_encode($total);
	$query1=$mysql->query("insert into main (`imgname`, `imgcontent`) values ('$imgname','$total')");
	}
	
	function sql2Image($imagename) {
		$content=$this->getImageById($imagename);
		$handle=fopen($imagename.".jpg","w");
		fwrite ($handle,$content);
		fclose($handle);
	}


	function base64_to_jpeg( $imageData, $outputfile ) { 
  		/* encode & write data (binary) */ 
		  $ifp = fopen( $outputfile, "wb" ); 
		  fwrite( $ifp, base64_decode( $imageData ) ); 
		  fclose( $ifp ); 
		  /* return output filename */ 
		  return( $outputfile ); 
		} 



}

?>