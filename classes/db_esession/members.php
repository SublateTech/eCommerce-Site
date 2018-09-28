<?PHP
// +----------------------------------------------------------------------+
// | members.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['security_level'] = 200;     // Security level for Members area
$sess_param['gc_maxlifetime'] = 300;     // Inactivity timeout of 300 seconds (5 minutes)
$sess = new DB_eSession(&$sess_param);   // session_start() done.

// Retrieve $_SESSION['authenticated'] value if set, otherwise return FALSE.
// For security, don't use the same variable name as the session name
// (especially if you have register_globals turned on).
$logged_in = $sess->getSessVar('authenticated', FALSE);

if (!$logged_in) {                       // Not yet authenticated?
    session_destroy();                   // Delete session created (new DB_eSession)
    header("Location: login.php");       // Go to get authenticated first.
    exit;
}

// Retrieve $_SESSION['username'] value if set, otherwise return a default value of 'member'.
$user = $sess->getSessVar('username', 'member');

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

$warning = $sess->getSiteWarn();        // Set to print site warning


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
<TITLE>Members Area</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 42, 121, 42), L=(membersLayout, 688, 555))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=750 NOF=LY>
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
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=637 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=66 HEIGHT=25></TD>
                        <TD WIDTH=11></TD>
                        <TD WIDTH=248></TD>
                        <TD WIDTH=293></TD>
                        <TD WIDTH=1></TD>
                        <TD WIDTH=2></TD>
                        <TD WIDTH=16></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=6 WIDTH=571>
                            <H1><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">You have reached the Members Area</FONT></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=48></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD COLSPAN=3 WIDTH=542>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Welcome <STRONG><?PHP echo $user; ?></STRONG>! You have reached the private Members Area.</FONT></P>
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
                        <TD COLSPAN=7 HEIGHT=12></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD COLSPAN=4 WIDTH=544>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Member information area here. Click on Home and then back on the Members Area again and you should still remain logged in.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">If you logged into this Members Area first, then clicking on the Employees Area will not gain you access, and you will loose your session even for the members area (meaning you will have to log back in).</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Now, click on logout below and then click on the Members Area again and you should be prompted for the username and password.</FONT></P>
                        </TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=7 HEIGHT=18></TD>
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
            <TD WIDTH=7 HEIGHT=110></TD>
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
