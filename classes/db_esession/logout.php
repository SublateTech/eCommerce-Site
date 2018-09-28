<?PHP
// +----------------------------------------------------------------------+
// | logout.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved  |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['security_level'] = 200;     // Security level for logout page
$sess_param['gc_maxlifetime'] = 300;     // Inactivity timeout of 300 seconds (5 minutes)
$sess = new DB_eSession(&$sess_param);   // session_start() done.
$warning = $sess->getSiteWarn();
session_destroy();                       // Logout by destroying session data.

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>You have been logged off</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 42, 121, 42), L=(logoutLayout, 645, 555))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=709 NOF=LY>
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
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=596 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=52 HEIGHT=27></TD>
                        <TD WIDTH=91></TD>
                        <TD WIDTH=317></TD>
                        <TD WIDTH=136></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD WIDTH=317>
                            <H2><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">You have been logged out.</FONT></TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=4 HEIGHT=54></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=3 WIDTH=544>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Thank you for using our services.</FONT></P>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">You may click on the 'Members Area' or 'Employees Area' links to log in again.</FONT></P>
                        </TD>
                    </TR>
                </TABLE>
            </TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=857 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=7 HEIGHT=253></TD>
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
