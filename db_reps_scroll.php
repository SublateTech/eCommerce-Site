<?php
/**
 * this is an example which splits the query results into multiple totalpages as search engine does
 * you can change the query and format in which the result is being printed
 */
session_start();
$page = $_REQUEST['page'];
$_SESSION['sql'] = "SELECT c.RepID,r.Name, CustomerID, c.Name, Address, City, State, ZipCode, c.PhoneNumber, ChairPerson, HeadPhone, c.PrizeID, p.Description as Prize_Description, c.BrochureID, b.Description, BrochureID_2, b1.Description as Description_2, SignedDate, StartDate, EndDate, PickUpDate, DeliveryDate, NoUnits, Signed , NoItems, NoSellers,Retail, Retail/NoSellers as Avg_Retail, NoItems/NoSellers as Av_Units  FROM Customer c LEFT JOIN Prizes p ON c.CompanyId=p.CompanyID and c.PrizeID=p.PrizeID LEFT JOIN Rep r ON c.CompanyId=r.CompanyID and  c.RepID=r.RepID LEFT JOIN Brochure b ON c.CompanyId=b.CompanyID and  c.BrochureID=b.BrochureID LEFT JOIN Brochure b1 ON c.CompanyId=b1.CompanyID and  c.BrochureID_2=b1.BrochureID Where c.CompanyID ='S07' And c.RepId='301'ORDER BY c.CompanyID,c.RepID,c.CustomerID";
$_SESSION['line'] = 4;
$_SESSION['fieldRequire'] = true;

$sql = $_SESSION['sql'];
include("db_reps_viewer.php");
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
