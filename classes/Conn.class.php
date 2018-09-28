<?php
Class Conn {
    var $_server; //database server
    var $_user; //database username
    var $_pwd; //database password
    var $_db; //database name
    var $conn;

    var $totalcols; //total no of cols returned by the query
    var $totalrows; //total no of rows returned by the query
    var $maxrow; //total no of rows displayed in a page
    var $sql; //the main query
    var $errMsg;
    var $totalpages;
    var $fieldName;
    var $fieldRequire;

    function connect($sql, $maxrow)
    {
        $this->sql = $sql;
        $this->maxrow = $maxrow;
        if ($this->maxrow <= 0) {
            $this->errMsg = "Max results in a page is not a valid entry";
            return;
        } 
        $this->conn = mysql_connect($this->_server, $this->_user, $this->_pwd)
        or die("Error: " . mysql_error() . "<br>");
        mysql_select_db($this->_db, $this->conn)
        or die("Error: " . mysql_error() . "<br>");
        $result = mysql_query($sql);
        if (!$result) {
            $this->errMsg = "ERROR: " . mysql_error() . "<br>";
            return;
        } 

        $fieldCount = mysql_num_fields($result);
        for ($i = 0; $i < $fieldCount; $i++) {
            $fieldName[$i] = mysql_field_name($result, $i);
        } 
        $this->fieldName = $fieldName; 
        // echo $this -> fieldName[0];
        $this->totalrows = mysql_num_rows($result);
        if ($this->totalrows == 0) { // total rows=0
            $this->errMsg = "No Result returned";
            return;
        } 
        $this->totalcols = mysql_num_fields($result); 
        // Get the number of pages
        $this->totalpages = (int)(($this->totalrows-1) / $this->maxrow + 1);
        return;
    } 

    function getQuery($page) // in this method only the present page to be displayed will be passed
    {
        if (($page == "") || ($page <= 0)) { // if the page passed is null, show the first page
            $min = 0;
        } else {
            if ($page > $this->totalpages) { // go to the last page
                $min = $this->maxrow * ($this->totalpages-1);
            } else { // Calulate the max and min limit for the page
                $page = $page-1;
                $min = $page * $this->maxrow;
                $max = $this->maxrow;
            } 
        } 
        // generate the query with the limits
        $sqlimit = $this->sql . " limit " . $min . "," . $this->maxrow;
        $outputdisplay = mysql_query($sqlimit)or die("ERROR" . mysql_error());
        if (mysql_num_rows($outputdisplay) == 0) {
            $this->errMsg = "No results";
            return;
        } else {
            return $outputdisplay;
        } 
    } 

    function showTable($rows, $fieldRequire)
    {
        echo "<table border='1'><tr>"; 
        // echo "show field:".$fieldRequire."<br>";
        $this->fieldRequire = $fieldRequire;
        if ($fieldRequire) {
            foreach($this->fieldName as $name) {
                echo "<th>" . $name . "</th>";
            } 
            echo "</tr>";
        } while ($row = mysql_fetch_row($rows)) {
            // print the results over here
            for($i = 0;$i < $this->totalcols;$i++) {
                echo "<td>" . "$row[$i]" . "</td>";
            } 
            echo "</tr>";
        } 
        echo "</table>";
        return;
    } 

    function pageFooter($page)
    {
        $line = $this->maxrow;
        if (($page == "") || ($page <= "0")) { // first page
            $page = 1;
        } 
        if ($page > $this->totalpages) { // stop at last page
            $page = $this->totalpages;
        } 
        if ($page > 1) { // insert the back link
            $backpage = $page-1;
            echo "<a href=db_reps_scroll.php?page=$backpage&fieldRequire=$this->fieldRequire" . SID . ">Back</a>&nbsp;&nbsp;" ;
        } 
        for($j = 1;$j <= $this->totalpages;$j++) { // insert the page links
            if ($j == $page) {
                echo $j . "&nbsp;&nbsp;";
            } else {
                echo "<a href=db_reps_scroll.php?page=$j&fieldRequire=$this->fieldRequire" . SID . ">" . $j . "</a>&nbsp;&nbsp;" ;
            } 
        } 
        if ($page < $this->totalpages) { // insert the next link
            $nextpage = $page + 1;
            echo "<a href=db_reps_scroll.php?page=$nextpage&fieldRequire=$this->fieldRequire" . SID . ">Next</a>&nbsp;&nbsp;" ;
        } 
        return;
    } 
} 

?>
