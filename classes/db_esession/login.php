<?PHP
// +----------------------------------------------------------------------+
// | login.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved   |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');

// See if relevant fields have been set.
$submitted = IsSet($_REQUEST['Submit'])   ? TRUE : FALSE;
$user      = IsSet($_REQUEST['username']) ?
                   cleanValue($_REQUEST['username']) : '';
$pswd      = IsSet($_REQUEST['password']) ?
                   cleanValue($_REQUEST['password']) : '';


if($submitted) {                                        // Form submitted yet?

    if (empty($user) || empty($pswd)) {                 // Are Form fields empty?

        // Display error message when fields are not filled in.
        $message = 'Make sure you enter both a username and password.';

    } else {

        // Authenticate username and password (i.e. match against a database).
        // Start a session only after username and password have been verified.
        if ((!strcmp($user, 'guest')) &&                // Does username match 'guest'?
            (!strcmp($pswd, 'demo'))) {                 // Does password match 'demo'?

            $sess_param['new_sid'] = TRUE;              // Create new session ID to be safe.
            $sess_param['security_level'] = 200;        // Security level for Members area
            $sess_param['gc_maxlifetime'] = 300;        // Inactivity timeout of 300 seconds (5 minutes)
            $sess = new DB_eSession(&$sess_param);      // session_start() done.
            $sess->setSessVar('authenticated', TRUE);   // Set that authentication occurred.
            // Save the username for displaying and encrypt
            $sess->setSessVar('username', $user, ENCRYPT_VALUE, EXTRA_FIELD);

            $URI = $sess->setSessURI('members.php');    // Optional - pass session ID in URI. Not as safe.

            header("Location: $URI");                   // Go to members area.
            exit;

        } else {

            // Incorrect information entered. Display an error message.
            $message = 'The username and/or password are invalid. Try again.';
        }
    }

} else {                                                // Form not submitted yet.

    $message  = '';                                     // Initialize message display field/area.
}

$warning = '';


function cleanValue($_value) {

    $_value = stripslashes(strip_tags($_value));

    $_value = str_replace(array('delete',
                                'DELETE',
                                'rm -',
                                ' ',
                                '!',
                                '|',
                                '?',
                                '&',
                                '=',
                                '-',
                                '`',
                                "'",
                                '"',
                                '\\\\',
                                '\\',
                                '//',
                                '/',
                                ',',
                                ';',
                                ':',
                                '*',
                                '>',
                                '<'
                               ), '', $_value);

    return trim($_value);
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Members Login Page</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 42, 121, 42), L=(loginLayout, 734, 555))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0 WIDTH=766 NOF=LY>
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
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=497 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=63 HEIGHT=19></TD>
                        <TD WIDTH=41></TD>
                        <TD WIDTH=330></TD>
                        <TD WIDTH=63></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=2></TD>
                        <TD WIDTH=330>
                            <H1><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Members Login Page</FONT></TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD COLSPAN=4 HEIGHT=37></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD COLSPAN=3 WIDTH=434>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Please enter your username and password to gain access to the private Members Area. </FONT></P>
                        </TD>
                    </TR>
                </TABLE>
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=586 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=63 HEIGHT=21></TD>
                        <TD WIDTH=523></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD WIDTH=523>
                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif" COLOR="#FF0000"><?PHP echo $message; ?></FONT></P>
                        </TD>
                    </TR>
                </TABLE>
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 NOF=LY>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD WIDTH=63 HEIGHT=24></TD>
                        <TD></TD>
                    </TR>
                    <TR VALIGN=TOP ALIGN=LEFT>
                        <TD></TD>
                        <TD WIDTH=431>
                            <FORM NAME="LoginForm" ACTION="<?PHP echo $_SERVER['PHP_SELF']; ?>" METHOD=POST>
                                <TABLE ID="Table1" BORDER=0 CELLSPACING=3 CELLPADDING=1 WIDTH="100%">
                                    <TR>
                                        <TD WIDTH=91>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Username:</FONT></P>
                                        </TD>
                                        <TD WIDTH=282>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><INPUT ID="usernamefield" TYPE=TEXT NAME="username" VALUE="<?PHP echo $user; ?>" SIZE=35 MAXLENGTH=35></FONT></TD>
                                        <TD WIDTH=40>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">guest</FONT></P>
                                        </TD>
                                    </TR>
                                    <TR>
                                        <TD WIDTH=91>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                        <TD WIDTH=282>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                        <TD WIDTH=40>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                    </TR>
                                    <TR>
                                        <TD WIDTH=91>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Password:</FONT></P>
                                        </TD>
                                        <TD WIDTH=282>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><INPUT ID="passwordfield" TYPE=PASSWORD NAME="password" VALUE="<?PHP echo $pswd; ?>" SIZE=35 MAXLENGTH=35></FONT></TD>
                                        <TD WIDTH=40>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">demo</FONT></P>
                                        </TD>
                                    </TR>
                                    <TR>
                                        <TD WIDTH=91>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                        <TD WIDTH=282>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                        <TD WIDTH=40>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                    </TR>
                                    <TR>
                                        <TD WIDTH=91>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                        <TD WIDTH=282>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><INPUT TYPE=SUBMIT NAME="Submit" VALUE="Login" ID="SubmitButton"></FONT></TD>
                                        <TD WIDTH=40>
                                            <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                                        </TD>
                                    </TR>
                                </TABLE>
                            </FORM>
                        </TD>
                    </TR>
                </TABLE>
            </TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=766 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=7 HEIGHT=231></TD>
            <TD WIDTH=759></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD></TD>
            <TD WIDTH=759>
                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><?PHP echo $warning; ?></FONT></P>
            </TD>
        </TR>
    </TABLE>
</BODY>
</HTML>
