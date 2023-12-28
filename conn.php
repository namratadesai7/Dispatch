<?php
    $servername = "192.168.1.162";
    $connectionInfo = array("Database"=>"EWP","UID"=>"sa","PWD"=>"12345","CharacterSet" => "UTF-8");
    $conn =sqlsrv_connect($servername,$connectionInfo);

    if($conn) {
        // echo "connection established.<br />";
        
    }else{
        echo "connection could not be established.<br/>";
        die(print_r( sqlsrv_errors(), true));
        
    }
?>