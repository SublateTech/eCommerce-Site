<?php

// including the class & mysql-connection..
require("session.inc.php");
require("connection.php");

// so now (2nd page), we'll resume the current session..
// take a look at the link, you have to pass the $sid..
// when resuming, the constructor needs no values..
$s = new Sessionara();
// no login()-call!

// as we passed the sid, it's already defined..
echo "<p>Resumed Session: {$sid}</p>\n\n";

// get and print out the saved array and variable..
$arr = $s->var_get("testarr");
echo "<p>Content of saved array: ";
echo $s->p_array($arr);
echo "</p>\n\n";

$testvar = $s->var_get("testvar");
echo "<p>Testvar value: {$testvar}</p>\n\n";

// let's see what's saved all over..
echo "<p>Print out all session data:</p>";
echo $s->p_array($s->data);
?>