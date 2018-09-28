<?PHP
// +----------------------------------------------------------------------+
// | index.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved   |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['security_level'] = 255;     // Security level for home page
$sess_param['gc_maxlifetime'] = 300;     // Inactivity timeout of 300 seconds (5 minutes)
$sess = new DB_eSession(&$sess_param);   // session_start() done.

// Retrieve $_SESSION['authenticated'] value if set, otherwise return FALSE.
// For security, don't use the same variable name as the session name
// (especially if you have register_globals turned on).
$logged_in = $sess->getSessVar('authenticated', FALSE);

if ($logged_in) {
    $message = 'You are logged in as: ' . $sess->getSessVar('username', 'member');
} else {
    $message = 'You are not currently logged in.';
    session_destroy();      // Delete session created (new DB_eSession)
}

$warning = $sess->getSiteWarn();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Home Page</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 42, 121, 42), L=(indexLayout, 656, 538))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=697 NOF=LY>
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
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=584 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=59 HEIGHT=21></TD>
                        <TD WIDTH=37></TD>
                        <TD WIDTH=428></TD>
                        <TD WIDTH=58></TD>
                        <TD WIDTH=2></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD WIDTH=428>
                            <H1 ALIGN=CENTER><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Welcome to our home page</FONT></TD>
                        <TD COLSPAN=2></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=5 HEIGHT=21></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=3 WIDTH=523>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">To test the DB_eSession class, make sure you have setup the database and table correctly, and then click on the 'Members Area' or 'Employees Area' links on the left.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">After you click on an area, If you're logged-in already, you will immediately see the appropriate area page. Otherwise, you will be transferred to a login page and prompted to enter a username and password. To log into the member area, use 'guest' for the username and 'demo' for the password. To log into the employee area, use 'empl' for the username and 'demo' for the password.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">When you login as a member, you <U>won't</U> have access to the Employees area (and you will loose your session if you try). But if you login as an Employee first, you will be able to have access to both areas. This aspect demonstrates the security level feature incorporated into the class. Try it out.</FONT></P>
                        </TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=5 HEIGHT=17></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=4 WIDTH=525>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><?PHP echo $message; ?></FONT></P>
                        </TD>
                    </TR>
                </TABLE>
            </TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=857 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=7 HEIGHT=163></TD>
            <TD WIDTH=850></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD></TD>
            <TD WIDTH=850>
                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><?PHP echo $warning; ?>&nbsp;</FONT></P>
            </TD>
        </TR>
    </TABLE>
</BODY>
</HTML>
