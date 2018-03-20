<?php
$myroot=$_SERVER['DOCUMENT_ROOT'] ;
//echo $myroot; 
$dir = $myroot;
// Sort in ascending order - this is default
$a = scandir($dir);
echo "<pre>"; print_r($a); echo"</pre>";
?>