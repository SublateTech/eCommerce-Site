<?PHP
// +------------------------------------------------------------------------+
// | employees.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved |
// +------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify   |
// | it under the terms of the GNU General Public License as published by   |
// | the Free Software Foundation; either version 2 of the License, or      |
// | (at your option) any later version. Read the full included license.    |
// +------------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['security_level'] = 100;     // Security level for Employees area
$sess_param['gc_maxlifetime'] = 300;     // Inactivity timeout of 300 seconds (5 minutes)
$sess = new DB_eSession(&$sess_param);   // session_start() done.

// Retrieve $_SESSION['authenticated'] value if set, otherwise return FALSE.
// For security, don't use the same variable name as the session name
// (especially if you have register_globals turned on).
$logged_in = $sess->getSessVar('authenticated', FALSE);

if (!$logged_in) {                       // Not yet authenticated?
    session_destroy();                   // Delete session created (new DB_eSession)
    header("Location: emplogin.php");    // Go to get authenticated first.
    exit;
}

// Retrieve $_SESSION['username'] value if set, otherwise return a default value of 'Employee'.
$user = $sess->getSessVar('username', 'Employee');

$fields = $sess->getSessInfo();          // Get current session field values

if (is_array($fields)) {                 // Field values returned alright

    // Get the creation epoch, the inactivity expiration epoch, and
    // absolute session timeout epoch
    $created = getdate($fields[$sess->getCreateName()]);
    $expiry  = getdate($fields[$sess->getExpiryName()]);
    $timeout = getdate($fields[$sess->getTimeoutName()]);

    // Format the fields for displaying
    $sess_info  = 'Your session started at: ' . $created['hours']   . ':' .
                                                $created['minutes'] . ':' .
                                                $created['seconds'] . '<br>';

    $sess_info .= 'Without activity expire: ' . $expiry['hours']    . ':' .
                                                $expiry['minutes']  . ':' .
                                                $expiry['seconds'];

    // Use local calcDateDiff function to get the difference between dates
    if ($duration = calcDateDiff($fields[$sess->getExpiryName()], time()))

        $sess_info .= ' expire will be in: '  . $duration['minutes']. ' minute(s), ' .
                                                $duration['seconds']. ' second(s).<br>';
    else
        $sess_info .= '<br>';

    $sess_info .= 'You will be logged off : ' . $timeout['hours']   . ':' .
                                                $timeout['minutes'] . ':' .
                                                $timeout['seconds'] . '<br>';

    if ($duration = calcDateDiff($fields[$sess->getTimeoutName()], time()))

        $sess_info .= 'Log-off will be in : ' . $duration['hours']  . ' hour(s), ' .
                                                $duration['minutes']. ' minute(s), ' .
                                                $duration['seconds']. ' second(s).<br>';

} else {

    $sess_info = "Without activity, you're session will expire soon.";
}

$warning = $sess->getSiteWarn();         // Set to print site warning


// A function to calculate the difference between two dates.
// Pass epoch timestamps to it.
function calcDateDiff ($_date1 = 0, $_date2 = 0) {

    // $_date1 needs to be greater than $_date2.
    // Otherwise you'll get negative results.
    if ($_date2 > $_date1)
        return FALSE;

    $_seconds  = $_date1 - $_date2;

    // Calculate each piece
    $_weeks    = floor($_seconds / 604800);
    $_seconds -= $_weeks * 604800;

    $_days     = floor($_seconds / 86400);
    $_seconds -= $_days * 86400;

    $_hours    = floor($_seconds / 3600);
    $_seconds -= $_hours * 3600;

    $_minutes  = floor($_seconds / 60);
    $_seconds -= $_minutes * 60;

    // Return an associative array of results
    return array( "weeks" => $_weeks, "days" => $_days, "hours" => $_hours,
                  "minutes" => $_minutes, "seconds" => $_seconds);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Employees Area</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 42, 121, 42), L=(employeesLayout, 701, 555))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=762 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD>
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=113 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=10 HEIGHT=79></TD>
                        <TD WIDTH=103></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD WIDTH=103>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><A NOF="LS_H" HREF="./index.php"><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Home</FONT></A></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><A HREF="./members.php"><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Members Area</FONT></A></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><A HREF="./employees.php"><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Employees Area</FONT></A></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Join</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">About us</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><FONT SIZE="-1" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Contact us</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                        </TD>
                    </TR>
                </TABLE>
            </TD>
            <TD>
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=649 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=57 HEIGHT=25></TD>
                        <TD WIDTH=21></TD>
                        <TD WIDTH=248></TD>
                        <TD WIDTH=293></TD>
                        <TD WIDTH=1></TD>
                        <TD WIDTH=2></TD>
                        <TD WIDTH=27></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=6 WIDTH=592>
                            <H1><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">You have reached the Employees Area</FONT></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=38></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD COLSPAN=3 WIDTH=542>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Welcome <STRONG><?PHP echo $user; ?></STRONG>! You have reached the private Employees Area.</FONT></P>
                        </TD>
                        <TD COLSPAN=2></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=18></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD COLSPAN=2 WIDTH=541>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><?PHP echo $sess_info; ?>&nbsp;</FONT></P>
                        </TD>
                        <TD COLSPAN=3></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=13></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD COLSPAN=4 WIDTH=544>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Employee information area here. Click on Home and then back on the Employees Area again and you should still remain logged in.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Since you logged in as an Employee, then clicking on the Members Area should gain you access to that area as well.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Now, click on logout below and then click on the Employees Area again and you should be prompted for the username and password.</FONT></P>
                        </TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=17></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD WIDTH=248>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><A HREF="./logout.php"><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Click here when you want to logout.</FONT></A><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT></P>
                        </TD>
                        <TD COLSPAN=4></TD>
                    </TR>
                </TABLE>
            </TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=857 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=7 HEIGHT=130></TD>
            <TD WIDTH=850></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD></TD>
            <TD WIDTH=850>
                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><?PHP echo $warning; ?></FONT></P>
            </TD>
        </TR>
    </TABLE>
</BODY>
</HTML>
