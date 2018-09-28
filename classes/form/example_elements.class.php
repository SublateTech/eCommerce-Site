<?php

// Include the original TM::Apeform class to be extended.
require_once("Apeform.class.php");

/**
 * Extended TM::Apeform class providing some special form elements.
 */
class ExtendedApeform extends Apeform
{
    /**
     * Creates an ISO-date input field, e.g. "2003-12-31".
     *
     * @param label string
     * @param help string
     * @param defaultValue string
     * @return string
     */
    function &date($label = "<u>D</u>ate", $help = "Year-Month-Day",
        $defaultValue = "")
    {
        // Use the actual date as defaultValue.
        if (! $defaultValue) $defaultValue = date("Y-m-d");
        // Calculate default element maxLength (and size too).
        $maxLength = strlen($defaultValue);
        // Call the parent method.
        $date = &$this->text($label, $help, $defaultValue, $maxLength);
        // Try to fetch three numbers from the string, the year first.
        if (! preg_match('/(\d+)\D+(\d+)\D+(\d+)/', $date, $m))
        {
            $this->error("Please enter a date");
        }
        else
        {
            // Extend years with missing century.
            if ($m[1] <= 38) $m[1] += 2000;
            elseif ($m[1] <= 99) $m[1] += 1900;
            // Check validity, e.g. 2003-02-29 is forbidden.
            if (! checkdate($m[2], $m[3], $m[1]))
            {
                $this->error("Please enter a valid <u>d</u>ate");
            }
            else
            {
                // Well-form the value.
                $date = sprintf("%04s-%02s-%02s", $m[1], $m[2], $m[3]);
            }
        }
        return $date;
    }

    /**
     * Creates an email input field, e.g. "name@domain.tld".
     *
     * @param label string
     * @param help string
     * @param defaultValue string
     * @param isRequired bool
     * @return string
     */
    function &email($label = "<u>E</u>mail", $help = "", $defaultValue = "",
        $isRequired = true)
    {
        // Call the parent method.
        $email = &$this->text($label, $help, $defaultValue);
        if ($isRequired && ! $email)
        {
            $this->error("Please enter your <u>e</u>mail adress");
        }
        // Check for a single At sign, no spaces, top level domain and so on.
        elseif ($email &&
            ! preg_match('/^[^@\s<>]+@[^@\s<>]+\.[a-z]{2,4}$/i', $email))
        {
            $this->error("Please enter a valid <u>e</u>mail adress");
        }
        return $email;
    }

    /**
     * Creates a price input field, e.g. "99.95".
     *
     * @param label string
     * @param help string
     * @param defaultValue float
     * @param min float
     * @param max float
     * @return string
     */
    function &price($label = "<u>P</u>rice", $help = "\tEuro",
        $defaultValue = "0.00", $min = 0.01, $max = 999999.99)
    {
        // Calculate maximum string length.
        $maxLength = max(strlen(sprintf("%.2f", $min)),
            strlen(sprintf("%.2f", $max)));
        // Call the parent method.
        $price = &$this->text($label, $help, $defaultValue, $maxLength,
            $maxLength);
        // Remove any special character.
        $price = preg_replace('/[^\d.-]+/', '', $price);
        // Check boundaries.
        if ($price < $min)
        {
            $this->error("Please enter a larger <u>p</u>rice");
        }
        elseif ($price > $max)
        {
            $this->error("Please enter a lower <u>p</u>rice");
        }
        else
        {
            // Well-form the value.
            $price = sprintf("%.2f", $price);
        }
        return $price;
    }

    /**
     * Creates an extended file upload field.
     *
     * @param label string
     * @param help string
     * @param allowedType string
     * @param maxKB int
     * @param isRequired bool
     * @return array
     */
    function &filetype($label = "<u>F</u>ile", $help = "", $allowedType = "*/*",
        $maxKB = 2048, $isRequired = false)
    {
        // Call the parent method.
        $file = &$this->file($label, $help);
        $pattern = '{^' . str_replace("*", '.*', $allowedType) . '$}i';
        if ($isRequired && ! $file)
        {
            $this->error("Please select a file");
        }
        elseif ($file && $allowedType && ! preg_match($pattern, $file['type']))
        {
            $this->error("Please select a file of another type");
        }
        elseif ($file && $maxKB && $file['size'] > $maxKB * 1024)
        {
            $this->error("Please select a smaller file (max. " .
                number_format($maxKB) . "KB)");
        }
        return $file;
    }
}

?>