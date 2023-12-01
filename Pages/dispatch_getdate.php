<?php
include('../includes/dbcon.php');


if(isset($_POST['billno'])){

    $billno=$_POST['billno'];
    $pono=$_POST['pono'];
    $jobno=$_POST['jobno'];
    $financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
    list($startYear, $endYear) = explode('-', $financialYear);
    $condition='';

    if(!empty($pono)){
        $condition.="AND PONO= '$pono'";
    }
    if(!empty($jobno)){
        $condition.="AND d.JobNo= '$jobno'";
    }
    if(empty($pono) && empty($jobno)){
        $condition.="AND d.DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
        AND d.DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5)";
    }

    $sql="SELECT DISTINCT( d.DDATE) as date
    FROM OrdDetail od 
    INNER JOIN OrdMaster o ON o.OrdId = od.OrdId
    INNER JOIN Inspection i ON i.JobNo = od.JobNo
    FULL OUTER JOIN Dispatch d ON d.ProcessDrum=i.ProcessDrum
    WHERE  d.DBILLNO= '$billno' ".$condition ;   
          
    $run=sqlsrv_query($conn,$sql);
    if($run){
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
    
    if($row) {
         
    $date=$row['date'];

    $timestamp = $date->getTimestamp();
    $y = date("y", $timestamp);
    $y1 = date("y", strtotime($date->format('Y-m-d') . "+1 year"));
    $year= $y.'-'.$y1;
    $array=array('date' => $date->format('Y-m-d'), 'financial_year' => $year);
    echo json_encode($array);
            // echo $date->format('Y-m-d');
        } else {
            $date1=date('Y-m-d'); 
            echo $date1;
        }
    } else {
        print_r(sqlsrv_errors());
    }
}

if(isset($_POST['bill_no'])){
    $billno=$_POST['bill_no'];
    $financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
    list($startYear, $endYear) = explode('-', $financialYear);

    $sql="SELECT distinct(DDATE) as date FROM Dispatch where  DBILLNO = '$billno' AND DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
    AND DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) ";
    // echo $sql;
    $run=sqlsrv_query($conn,$sql);
    
 
    if($run){
        $row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

    if($row){
        $date=$row['date']->format('Y-m-d');
        echo $date;

    }else{
        $date1=date('Y-m-d'); 
        echo $date1;

    }
       
    }else{
        print_r(sqlsrv_errors());
    }
}


?>
