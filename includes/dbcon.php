<?php
$server = "192.168.1.162";
$connection = array("Database"=>"TRADEZ","UID"=>"sa","PWD"=>"12345","CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect($server,$connection);

if($conn){
    //echo 'Connection done';
}else{
    die(print_r(sqlsrv_errors(),true));
}
?>