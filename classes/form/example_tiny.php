<?php

/**
 * Tiny form example. Shows basic use of textarea, error, submit, isValid and
 * display.
 *
 * @author Thiemo Mättig (http://maettig.com/)
 */

require_once("Apeform.class.php");
$form = new Apeform();

$message = $form->textarea("Something");
if (! $message) $form->error("Please enter something");

$form->submit("Submit something");

if ($form->isValid()) echo "Thank you!";
else $form->display();

?>