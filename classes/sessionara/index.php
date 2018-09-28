<?php

// including the class & mysql-connection..
require("session.inc.php");
require("connection.php");

// ok, now let's open a session with our placeholder keyword.. (no real query)
$s = new Sessionara("W/MYSQL");
// don't forget, when opening a session, call login()
$s->login();

// get Session-ID
$sid = $s->get_sid();

// give some output
echo "<p>Session opened, Session-ID: {$sid}</p>\n";

// now we'll save an array to the session..
// define it first..
$arr = array("first thing", "another one", "hmm...");
// save it as variable, name it..
$s->var_set("testarr", $arr);

// output
echo "<p>Saved array ";
echo $s->p_array($arr);
echo "</p>";

// save normal variable
$s->var_set("testvar", "testvalue");

// output
echo "<p>saved var testvar, value testvalue</p>";

// ok, view the testsite in your browser, then click on the link
// on the next page, we'll receive this values and use it..
echo "<p><a href=\"printout.php?sid={$sid}\">Next  Page</a>\n\n</p>";


?>