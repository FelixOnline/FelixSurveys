<?php
    $dbname = "DATABASE";
    $host = "localhost";
    $user = "USERNAME";
    $pass = "PASSWORD";
    $cid = mysql_connect($host,$user,$pass);
    $dbok = mysql_select_db($dbname,$cid);

    $local = true;
?>	
