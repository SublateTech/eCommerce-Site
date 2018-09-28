<?php
/**
 * this is an example which splits the query results into multiple totalpages as search engine does
 * you can change the query and format in which the result is being printed
 */
session_start();
$page = $_REQUEST['page'];
$_SESSION['sql'] = "Select * from Customer";
$_SESSION['line'] = 13;
$_SESSION['fieldRequire'] = true;

$sql = $_SESSION['sql'];
include("classes/Conn.class.php");
if (!$_SESSION['line'])
    $line = 10;
else
    $line = $_SESSION['line'];
echo "<b>Page No: " . $page . "</b>";
if (!$sql) {
    $sql = $conn->sql;
} 

$conn = new Conn;
$conn->_server = "207.104.236.2";
$conn->_user = "signatv9_sa";
$conn->_pwd = "sa";
$conn->_db = "signatv9_OSAS";


$connDB = $conn->connect($sql, $line); //create an object of split  pass the sql and total no of rows to be displayed in a page
if ($conn->errMsg != "") {
    die($conn->errMsg);
} 
$rows = $conn->getQuery($page);
$conn->showTable($rows, $_SESSION['fieldRequire']);
$conn->pageFooter($page);

?>
