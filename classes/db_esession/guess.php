<?PHP
// +----------------------------------------------------------------------+
// | guess.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved   |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['gc_maxlifetime'] = 1800;      // Inactivity timeout
$sess_param['timeout'] = 1800;             // Absolute timeout
$sess = new DB_eSession(&$sess_param);     // session_start() done.

$secret       = $sess->getSessVar('rand_nbr', 0);
$tries        = $sess->getSessVar('nbr_tries', 0);
$past_guesses = $sess->getSessVar('guesses', "You've already attempted:<br>");
$submitted    = IsSet($_REQUEST['Submit']) ? TRUE : FALSE;
$guess        = IsSet($_REQUEST['guess'])  ?
                      strip_tags($_REQUEST['guess']) : '';

if ($submitted) {                                        // Form submitted yet?

    if (($guess > 0) &&
        ($guess < 11)) {

        $tries++;

        if ($guess == $secret) {
            $message = "Well done! You guessed my number of: $secret on try # $tries.";
            if ($tries < 3)
                $message .= " You're good at this.";

            $message .= " Play again.<br>";
            setSecretNumber();

        } else
        if ($tries > 2) {
            $message = "You've had 3 guesses and you didn't guess my secret number of: $secret. I'm sure you'll guess it in the next game.<br>";
            setSecretNumber();

        } else {
            $past_guesses .= "Guess # $tries was $guess.<br>";
            $message = "No, that's not it. Try again. " . $past_guesses;
            $sess->setSessVar('guesses', $past_guesses);
            $sess->setSessVar('nbr_tries', $tries);

        }

    } else
        $message = "Enter a number between 1 and 10 and click on 'Submit Guess' to try your luck.<br>";


} else
    if (0 == $secret) {
        $message = '';
        setSecretNumber();

    } else
        $message = "Hurry up and guess my number! You must click on the 'Submit Guess' button.<br>";


function pick_number($_min = 1, $_max = 10) {

    return mt_rand($_min, $_max);

}


function setSecretNumber() {

    global $sess, $message, $guess;

    $sess->setSessVar('rand_nbr', pick_number());   // Save picked number

    $sess->setSessVar('nbr_tries', 0);              // Init. number tries
    $sess->setSessVar('guesses', "You've already attempted:<br>");

    $message .= "I'm thinking of a number between 1 and 10. You have three chances to guess what it is.<br>";
    $guess = '';

    return TRUE;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>guess</TITLE>
</HEAD>
<BODY NOF="(MB=(ZeroMargins, 0, 0, 0, 0), L=(guessLayout, 902, 430))" BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099" ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
    <CENTER>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=248 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=248 HEIGHT=20></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=248>
                <H1><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><FONT COLOR="#FF0000" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Guessing Game</FONT></TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=852 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=852 HEIGHT=20></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=CENTER>
            <TD WIDTH=852>
                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif" COLOR="#0000CC"><?PHP echo $message; ?></FONT></P>
            </TD>
        </TR>
    </TABLE>
    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 NOF=LY>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD HEIGHT=55></TD>
        </TR>
        <TR VALIGN=TOP ALIGN=LEFT>
            <TD WIDTH=385>
                <FORM NAME="GuessForm" ACTION="<?PHP echo $_SERVER['PHP_SELF']; ?>" METHOD=POST>
                    <TABLE ID="Table1" BORDER=0 CELLSPACING=3 CELLPADDING=1 WIDTH="100%">
                        <TR>
                            <TD WIDTH=230>
                                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"></FONT><FONT COLOR="#0000CC" FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">Guess the number I'm thinking of:</FONT></P>
                            </TD>
                            <TD WIDTH=142>
                                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><INPUT ID="FormGuess" TYPE=TEXT NAME="guess" VALUE="<?PHP echo $guess; ?>" SIZE=4 MAXLENGTH=2></FONT></TD>
                        </TR>
                        <TR>
                            <TD>
                                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif">&nbsp;</FONT></P>
                            </TD>
                            <TD WIDTH=142>
                                <P><FONT FACE="Arial,Helvetica,Geneva,Sans-serif,sans-serif"><INPUT TYPE=SUBMIT NAME="Submit" VALUE="Submit Guess" ID="SubmitButton"></FONT></TD>
                        </TR>
                    </TABLE>
                </FORM>
            </TD>
        </TR>
    </TABLE>
    </CENTER>
</BODY>
</HTML>
