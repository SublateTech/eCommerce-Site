<?PHP
// +----------------------------------------------------------------------+
// | monitor.php, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// +----------------------------------------------------------------------+
require_once('config.DB_eSession.php');
require_once('class.DB_eSession.php');
$sess_param['stop_on_warn']  = FALSE;
$sess_param['session_start'] = FALSE;       // Don't need to do
$sess = new DB_eSession(&$sess_param);

$db = $sess->getDBResource();               // Get DB resource link

// Example of using the DB resource link for your own query. Or you could add
// results from nbrActiveSess() and nbrInactiveSess() to get total rows in table
function totalRows() {

    global $db, $sess;

    // Could use SELECT count(*)
    $_sql = 'SELECT ' . $sess->getLockName() .  // Specify field instead of *
            '  FROM ' . $sess->getTableName();

    $_result = @mysql_query($_sql, $db);

    if (!$_result) {
        echo 'totalRows() query error<br>';

        return 0;

    } else {

        return @mysql_num_rows($_result);

    }

}

// Returns TRUE when a session row is still valid/active
function isSessActive($_expiry, $_timeout, $_lock_mode) {

    $_time = time();

    if (($_expiry  > $_time) &&
        ($_timeout > $_time) &&
        (0 == $_lock_mode))

        return TRUE;                        // Session still active
    else
        return FALSE;

}

function makeLink($_col_name, $_desc = NULL) {

    global $sess, $offset, $max_rows, $asc_desc;

    $_desc = (empty($_desc)) ? $_col_name : $_desc;

    return $sess->createLink($_SERVER['PHP_SELF'] .
              "?sort=$_col_name&order=$asc_desc&start=$offset&limit=$max_rows",
                             $_desc,
                             NULL,
                             FALSE);

}

// Displays all the main session data and form
function display(&$data) {

    global $sess, $order_by, $asc_desc, $offset, $max_rows;


    if ($asc_desc) {
        $asc_desc = 0;
        echo "<CENTER><H3>sorted by $order_by column in ascending order",
             "&nbsp;(", makeLink($order_by, "change to descending order"),
             ")</H3>\n";
        $asc_desc = 1;
        echo "</CENTER>\n";

    } else {
        $asc_desc = 1;
        echo "<CENTER><H3>sorted by $order_by column in descending order",
             "&nbsp;(", makeLink($order_by, "change to ascending order"),
             ")</H3>\n";
        $asc_desc = 0;
        echo "</CENTER>\n";
    }

    $_now = getdate(time());
    echo "<CENTER><STRONG>Current Server time - date: ",
         $_now['hours'], ":", $_now['minutes'], ":",
         $_now['seconds'], " - ", $_now['mon'], "/",
         $_now['mday'], "/", $_now['year'], "</STRONG></CENTER>\n";

    echo "<TABLE BORDER>\n";
    echo '<FORM METHOD="post" ACTION="', $_SERVER['PHP_SELF'], '">', "\n";
    echo "<TR>\n";
    echo "<TH>#</TH>\n";
    echo "<TH>Action</TH>\n";
    echo "<TH>Status</TH>\n";
    echo "<TH>", makeLink($sess->getSessIDName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getSecLevelName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getCreateName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getExpiryName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getTimeoutName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getLockName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getSessValueName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getEncIVName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getSecIDName()), "</TH>\n";
    echo "<TH>", makeLink($sess->getTraceName()), "</TH>\n";
    echo "</TR>\n";

    if (!$data) {

        echo "</FORM></TABLE><br><br>\n";
        echo "<br><STRONG>Currently, there's no session data in the table.",
             "</STRONG><br><br>\n";
        return FALSE;
    }

    $cnt = count($data);

    for ($i = 0; $i < $cnt; $i++) {

        $created = getdate($data[$i][$sess->getCreateName()]);
        $expiry  = getdate($data[$i][$sess->getExpiryName()]);
        $timeout = getdate($data[$i][$sess->getTimeoutName()]);

        $active  = isSessActive($data[$i][$sess->getExpiryName()],
                                $data[$i][$sess->getTimeoutName()],
                                $data[$i][$sess->getLockName()]);

        echo "<TR>\n";
        echo "<TD>\n";
        echo $offset + $i + 1;
        echo "</TD>\n";

        if (0 == $data[$i][$sess->getLockName()]) {
            echo "<TD>\n";
            echo '<INPUT NAME="action[',$i,']" TYPE="radio" VALUE="lock">Lock';
            echo "<BR><BR>\n";
            echo '<INPUT NAME="action[',$i,']" TYPE="radio" VALUE="delete">Delete';
            echo "<BR>\n";
            echo "</TD>\n";

        } else {
            echo "<TD>\n";
            echo '<INPUT NAME="action[',$i,']" TYPE="radio" VALUE="unlock">Unlock';
            echo "<BR><BR>\n";
            echo '<INPUT NAME="action[',$i,']" TYPE="radio" VALUE="delete">Delete';
            echo "<BR>\n";
            echo "</TD>\n";

        }

        echo '<INPUT NAME="sid[', $i, ']" TYPE="hidden" VALUE="',
             $data[$i][$sess->getSessIDName()], '">', "\n";

        if ($active)
            echo "<TD>Active</TD>\n";
        else
            echo "<TD>Inactive</TD>\n";

        echo "<TD>", $data[$i][$sess->getSessIDName()], "</TD>\n";
        echo "<TD>", $data[$i][$sess->getSecLevelName()], "</TD>\n";

        echo "<TD>", $data[$i][$sess->getCreateName()],
             " (", $created['hours'], ":", $created['minutes'], ":",
             $created['seconds'], " - ", $created['mon'], "/",
             $created['mday'], "/", $created['year'], ")</TD>\n";

        echo "<TD>", $data[$i][$sess->getExpiryName()],
             " (", $expiry['hours'], ":", $expiry['minutes'], ":",
             $expiry['seconds'], " - ", $expiry['mon'], "/",
             $expiry['mday'], "/", $expiry['year'], ")</TD>\n";

        echo "<TD>", $data[$i][$sess->getTimeoutName()],
             " (", $timeout['hours'], ":", $timeout['minutes'], ":",
             $timeout['seconds'], " - ", $timeout['mon'], "/",
             $timeout['mday'], "/", $timeout['year'], ")</TD>\n";

        if (0 == $data[$i][$sess->getLockName()])
            echo "<TD>", $data[$i][$sess->getLockName()], " (unlocked)</TD>\n";
        else
            echo "<TD>", $data[$i][$sess->getLockName()], " (locked)</TD>\n";

        echo "<TD>", htmlentities($data[$i][$sess->getSessValueName()]),
             "&nbsp;</TD>\n";
        echo "<TD>", $data[$i][$sess->getEncIVName()], "&nbsp;</TD>\n";
        echo "<TD>", $data[$i][$sess->getSecIDName()], "</TD>\n";
        echo "<TD>", $data[$i][$sess->getTraceName()], "</TD>\n";
        echo "</TR>\n";

    }

    echo "<BR><BR>\n";
    echo "<TR>\n";
    echo "<TD COLSPAN=3>\n";
    echo '<INPUT NAME="allaction" TYPE="radio" VALUE="lock">Lock All<br><br>';
    echo '<INPUT NAME="allaction" TYPE="radio" VALUE="unlock">Unlock All',
         '<br><br>';
    echo '<INPUT NAME="allaction" TYPE="radio" VALUE="delete">Delete All',
         '<br><br>';
    echo "</TD>\n";

    echo "<TD>\n";
    echo "<CENTER>\n";
    echo '<INPUT NAME="confirm" TYPE="checkbox"> Confirm "All" request<br><br>';
    echo '<INPUT NAME="start" TYPE="hidden" VALUE="', $offset, '">', "\n";
    echo '<INPUT NAME="sort" TYPE="hidden" VALUE="', $order_by, '">', "\n";
    echo '<INPUT NAME="order" TYPE="hidden" VALUE="', $asc_desc, '">', "\n";
    echo '<INPUT NAME="limit" TYPE="hidden" VALUE="', $max_rows, '">', "\n";
    echo '<INPUT TYPE="Submit" NAME="Submit" VALUE="Submit Request(s)">',
         "<BR><BR>\n";
    echo '<INPUT TYPE="Reset" NAME="Reset" VALUE="Reset/Clear">',  "<BR>\n";
    echo "</CENTER>\n";
    echo "</TD>\n";

    echo "<TD COLSPAN=3>\n";
    echo "<CENTER>\n";
    $total_rows = totalRows();
    echo "<STRONG>", $total_rows, " row(s) in table<BR>";
    echo $sess->nbrActiveSess(), " active and ";
    echo $sess->nbrInactiveSess(), " inactive<BR><BR>";
    echo "</STRONG>\n";

    echo '<INPUT NAME="limit" TYPE="text" SIZE=3 MAXLENGTH=3',
         ' VALUE="', $max_rows, '"> Rows per page<BR><BR>';


    if ($offset > 0) {

        $temp = (int) $offset;
        $offset = $offset - $max_rows;
        $offset = ($offset < 0) ? 0 : $offset;
        echo makeLink($order_by, "Previous Page");
        $offset = $temp;
    }

    if (($offset + $max_rows) < $total_rows) {

        $temp = (int) $offset;
        $offset = abs($offset + $max_rows);
        echo "&nbsp;&nbsp;&nbsp;&nbsp;", makeLink($order_by, "Next Page");
        $offset = $temp;
   }

    echo "<BR><BR>\n";
    echo "</CENTER>\n";
    echo "</TD>\n";

    echo "<TD COLSPAN=6 ALIGN=LEFT>\n";
    echo "<STRONG>Current Server time - date: ",
         $_now['hours'], ":", $_now['minutes'], ":",
         $_now['seconds'], " - ", $_now['mon'], "/",
         $_now['mday'], "/", $_now['year'], "</STRONG><BR>\n";
    echo "</TD>\n";

    echo "</TR>\n";

    echo "</FORM></TABLE><br><br>\n";

    return TRUE;

}


function process_requests() {

    global $sess, $sess_param;


    if (isSet($_REQUEST['allaction'])) {    // Process for whole table request

        $confirm = isSet($_REQUEST['confirm']) ? $_REQUEST['confirm'] : 'off';

        if ('on' == $confirm) {

            switch ($_REQUEST['allaction']) {

                case 'lock' :
                     $sess->changeAllSessLocks($sess_param['confirm_pswd'], TRUE);
                     break;

                case 'unlock' :
                     $sess->changeAllSessLocks($sess_param['confirm_pswd'], FALSE);
                     break;

                case 'delete' :
                     $sess->deleteAllSessions($sess_param['confirm_pswd']);
                     break;
            }

        } else {
            echo "<STRONG>Confirm was not selected. It must be selected when",
                 " requesting changes to be made to the whole table.",
                 "</STRONG><BR>";
        }


    } else
    if (isSet($_REQUEST['action'])) {       // Process individual row requests
        foreach($_REQUEST['action'] as $i => $value) {

            switch ($value) {

                case 'lock' :
                     $sess->changeSessLock($_REQUEST['sid'][$i], TRUE);
                     break;

                case 'unlock' :
                     $sess->changeSessLock($_REQUEST['sid'][$i], FALSE);
                     break;

                case 'delete' :
                     $sess->deleteSession($_REQUEST['sid'][$i]);
                     break;
            }

        }
    }

    return TRUE;
}

?>

<HTML>
<HEAD>
<TITLE>Session Monitoring and Maintenance Page</TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF" TEXT="#000000" LINK="#0033CC" VLINK="#990099"
ALINK="#FF0000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<CENTER><H2>Session Table Data</H2></CENTER>

<?PHP

$submitted= isSet($_REQUEST['Submit'])? TRUE : FALSE;
$offset   = (int) isSet($_REQUEST['start']) ?
                  intval(strip_tags($_REQUEST['start']))  : 0;
$max_rows = (int) isSet($_REQUEST['limit']) ?
                  intval(strip_tags($_REQUEST['limit']))  : 15;
$max_rows = (0 == $max_rows) ? 15 : $max_rows;
$order_by = isSet($_REQUEST['sort'])  ?
                  strip_tags($_REQUEST['sort']) : $sess->getExpiryName();
$asc_desc = (int) isSet($_REQUEST['order']) ?
                  intval(strip_tags($_REQUEST['order'])) : 0;


if ($submitted)
    process_requests();


$sort_order = (1 == $asc_desc) ? TRUE : FALSE;

$data = $sess->getAllSessInfo($offset, $max_rows,
                              $order_by, $sort_order,
                              $sess_param['confirm_pswd']);

display($data);

?>

</BODY>
</HTML>