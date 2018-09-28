<?PHP
// +----------------------------------------------------------------------+
// | examples.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved|
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['stop_on_warn'] = FALSE;        // Don't stop script on warnings
$sess = new DB_eSession(&$sess_param);      // session_start() done.
?>
<HTML>
<HEAD>
<TITLE>DB_eSession class examples</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099"
ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<?PHP

$counter = $sess->getSessVar('count', 0);   // Get session variable if it exists
$counter++;
$sess->setSessVar('count', $counter);       // Save the new value
echo "Counter set to: $counter <br>";
echo "<br>";

echo "Class version number is: ", $sess->getVersion(), "<br>";
echo "<br>";

echo "MySQL server version is: ", $sess->getMySQLVer(), "<br>";
echo "<br>";

$type_code = NULL;
echo "IP address: ", $sess->getIPAddr($type_code), "<br>";
echo "IP type code: $type_code <br>";
echo "<br>";

if ($sess->secureConnection())
    echo "This page is running in a secure SSL connection (HTTPS).<br>";
else
    echo "This page is not running on a secure connection.<br>";
echo "<br>";

echo "PHP's session name is: ", $sess->getSessName(), "<br>";
echo "<br>";

echo "Session inactivity (maxlifetime) is set to: ", $sess->getSessLife(),
     " seconds (", $sess->getSessLife(TRUE), " minutes)<br>";
echo "Session absolute timeout is set to: ", $sess->getSessTimeout(),
     " seconds (", $sess->getSessTimeout(TRUE), " minutes)<br>";
echo "<br>";

// Use member functions to retrieve names or use $sess_param['tb_id_col'], etc.
echo "Table session ID column name is: ", $sess->getSessIDName(), "<br>";
echo "Table security level column name is: ", $sess->getSecLevelName(), "<br>";
echo "Table created column name is: ", $sess->getCreateName(), "<br>";
echo "Table expiry column name is: ", $sess->getExpiryName(), "<br>";
echo "Table timeout column name is: ", $sess->getTimeoutName(), "<br>";
echo "Table locked column name is: ", $sess->getLockName(), "<br>";
echo "Table session value column name is: ", $sess->getSessValueName(), "<br>";
echo "Table encryption IV column name is: ", $sess->getEncIVName(), "<br>";
echo "Table security ID column name is: ", $sess->getSecIDName(), "<br>";
echo "Table trace column name is: ", $sess->getTraceName(), "<br>";
echo "<br>";

// First time running script, active sessions will maybe be zero. At the end of
// this script PHP will write/save the session data. So, after refreshing
// this page, number of active sessions will be at least 1.
echo "The number of active sessions: ", $sess->nbrActiveSess(), "<br>";
echo "The number of inactive sessions: ", $sess->nbrInactiveSess(), "<br>";
echo "<br>";

// Retrieve the current active session data
if ($row = $sess->getSessInfo(session_id(), TRUE,
                              $sess_param['confirm_pswd'])) {

    echo "Current active session data:<br>";
    echo "<TABLE BORDER>";
    echo "<TR>";
    echo "<TH>", $sess->getSessIDName(), "</TH>";
    echo "<TH>", $sess->getSecLevelName(), "</TH>";
    echo "<TH>", $sess->getCreateName(), "</TH>";
    echo "<TH>", $sess->getExpiryName(), "</TH>";
    echo "<TH>", $sess->getTimeoutName(), "</TH>";
    echo "<TH>", $sess->getLockName(), "</TH>";
    echo "<TH>", $sess->getSessValueName(), "</TH>";
    echo "<TH>", $sess->getEncIVName(), "</TH>";
    echo "<TH>", $sess->getSecIDName(), "</TH>";
    echo "<TH>", $sess->getTraceName(), "</TH>";
    echo "</TR>";

    echo "<TR>";
    echo "<TD>", $row[$sess->getSessIDName()] , "</TD>";
    echo "<TD>", $row[$sess->getSecLevelName()] , "</TD>";
    echo "<TD>", $row[$sess->getCreateName()] , "</TD>";
    echo "<TD>", $row[$sess->getExpiryName()] , "</TD>";
    echo "<TD>", $row[$sess->getTimeoutName()] , "</TD>";
    echo "<TD>", $row[$sess->getLockName()] , "</TD>";
    echo "<TD>", htmlentities($row[$sess->getSessValueName()]), "</TD>";
    echo "<TD>", $row[$sess->getEncIVName()] , "</TD>";
    echo "<TD>", $row[$sess->getSecIDName()] , "</TD>";
    echo "<TD>", $row[$sess->getTraceName()] , "</TD>";
    echo "</TR>";

    echo "</TABLE><br><br>";
}


// Retrieve all rows and sort by creation date in descending order
if ($data = $sess->getAllSessInfo(0, -1, $sess->getCreateName(),
                                  FALSE, $sess_param['confirm_pswd'])) {

    echo "All session data sorted by creation epoch column:<br>";
    echo "<TABLE BORDER>";
    echo "<TR>";
    echo "<TH>", $sess->getSessIDName(), "</TH>";
    echo "<TH>", $sess->getSecLevelName(), "</TH>";
    echo "<TH>", $sess->getCreateName(), "</TH>";
    echo "<TH>", $sess->getExpiryName(), "</TH>";
    echo "<TH>", $sess->getTimeoutName(), "</TH>";
    echo "<TH>", $sess->getLockName(), "</TH>";
    echo "<TH>", $sess->getSessValueName(), "</TH>";
    echo "<TH>", $sess->getEncIVName(), "</TH>";
    echo "<TH>", $sess->getSecIDName(), "</TH>";
    echo "<TH>", $sess->getTraceName(), "</TH>";
    echo "</TR>";

    $cnt = count($data);

    for ($i = 0; $i < $cnt; $i++) {

        echo "<TR>";
        echo "<TD>", $data[$i][$sess->getSessIDName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getSecLevelName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getCreateName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getExpiryName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getTimeoutName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getLockName()] , "</TD>";
        echo "<TD>", htmlentities($data[$i][$sess->getSessValueName()]),
             "&nbsp;</TD>";
        echo "<TD>", $data[$i][$sess->getEncIVName()] , "&nbsp;</TD>";
        echo "<TD>", $data[$i][$sess->getSecIDName()] , "</TD>";
        echo "<TD>", $data[$i][$sess->getTraceName()] , "</TD>";
        echo "</TR>";
    }

    echo "</TABLE><br><br>";

}


if ($sess->warningsExist())
    echo "Warnings exist:<br>", $sess->getWarnings(), "<br>";

echo "The site warning message is:<br>", $sess->getSiteWarn(), "<br>";
echo "<br>";

echo $sess->createLink($_SERVER['PHP_SELF'],
                       'Refresh this page and see the counter change.');
echo "<br>";
echo "<br>";

?>

</BODY>
</HTML>