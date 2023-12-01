<?php
include('../includes/dbcon.php');
session_start();

if(isset($_POST['pdrum'])){
    $gweight=$_POST['gweight'];
    $dsize=$_POST['dsize'];
    $date=$_POST['date'];
    $billno=$_POST['billno'];
    $dlength=$_POST['dlength'];
    // $column=$_POST['column'];
    // $value=$_POST['value'];
    $pdrum=$_POST['pdrum'];
    $jobno=$_POST['jobno'];
    $run='';

    


    foreach( $gweight as $key => $value){

        if(empty( $value) || empty( $date) || empty( $billno) || empty( $dsize[$key]) || empty( $dlength[$key])){   
            continue;
        } 
        $sql1="SELECT  count (*) as s  from Dispatch WHERE ProcessDrum= '".$pdrum[$key]."'  ";
        $run1=sqlsrv_query($conn,$sql1);
        $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
        if($row1['s']>=1){
            $sql="UPDATE Dispatch SET DDATE='$date',DBILLNO='$billno',GrossWeight='".$value."',DDRUMSIZE='".$dsize[$key]."',DQTY='".$dlength[$key]."',UpdatedAt='".date('Y-m-d')."',UpdatedBy='".$_SESSION['uname']."' WHERE ProcessDrum  = '".$pdrum[$key]."' AND JobNo='".$jobno[$key]."'  ";
            $run=sqlsrv_query($conn,$sql);
        }else{
         // $sql="UPDATE Inspection SET DDATE='$date',DBILLNO='$billno',GrossWeight='".$value."',DDRUMSIZE='".$dsize[$key]."',DQTY='".$dlength[$key]."' WHERE ProcessDrum  = '".$pdrum[$key]."' AND JobNo='".$jobno[$key]."'  ";
            $sql="INSERT INTO Dispatch (DDATE,DBILLNO,GrossWeight,DDRUMSIZE,DQTY,ProcessDrum,JobNo,CreatedBy) VALUES('$date','$billno','".$value."','".$dsize[$key]."','".$dlength[$key]."','".$pdrum[$key]."','".$jobno[$key]."','".$_SESSION['uname']."')";
            $run=sqlsrv_query($conn,$sql);
        //echo $sql;
       
        }

      
    }
    if($run){
        echo("saved successfully");
    }
    else{
    // echo("NOT SAVED");
    print_r(sqlsrv_errors());
    }       
}

//FOR INDIVIDUAL BUTTON
if(isset($_POST['id'])){
    $gweight=$_POST['gweight'];
    $dsize=$_POST['dsize'];
    $date=$_POST['date'];
    $billno=$_POST['billno'];
    $dlength=$_POST['dlength'];
    $id=$_POST['id'];
    $jobno=$_POST['jobno'];

    $sql1="SELECT  count (*) as s  from Dispatch WHERE ProcessDrum= '$id'  ";
    $run1=sqlsrv_query($conn,$sql1);
    $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);

    if($row1['s']>=1){
        $sql="UPDATE Dispatch SET  DDATE='$date',DBILLNO='$billno',GrossWeight='$gweight',DDRUMSIZE='$dsize',DQTY='$dlength' ,UpdatedAt='".date('Y-m-d')."',UpdatedBy='".$_SESSION['uname']."' WHERE ProcessDrum  = '$id' AND JobNo='$jobno'";
        $run=sqlsrv_query($conn,$sql);
    }else{
        //$sql="UPDATE Inspection SET  DDATE='$date',DBILLNO='$billno',GrossWeight='$gweight',DDRUMSIZE='$dsize',DQTY='$dlength' WHERE ProcessDrum  = '$id' AND JobNo='$jobno' ";
        $sql="INSERT INTO Dispatch (DDATE,DBILLNO,GrossWeight,DDRUMSIZE,DQTY,ProcessDrum,JobNo,CreatedBy) VALUES('$date','$billno','$gweight','$dsize','$dlength','$id','$jobno','".$_SESSION['uname']."')";
        $run=sqlsrv_query($conn,$sql);
        //echo $sql;
    }

    if($run){
      echo("saved successfully");
    }
     else{
        print_r(sqlsrv_errors());
    } 

}
//For calculating sum of qty ,weight.
// if(isset($_POST['job_no']) && !empty($_POST['job_no'])){
    if(isset($_POST['bill_no'])){
    $jobno=$_POST['job_no'];
    $billno=$_POST['bill_no'];
    $financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
    list($startYear, $endYear) = explode('-', $financialYear);
    $condition='';


    if(!empty($jobno)){
        $condition.=" AND JobNo='$jobno' ";
    }
   
   // $sql1="SELECT count(*) as s,SUM(CAST(DQTY AS INT)) AS dqty ,SUM(CAST(GrossWeight AS INT)) AS w from Inspection where JobNo='$jobno' and DDATE is not null ";
    $sql1="	SELECT count(*) as s,SUM(DQTY) AS dqty ,SUM(CAST(GrossWeight AS float)) AS w from Dispatch where DBILLNO = '$billno'  AND 
    DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
    AND DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) ".$condition;
    // $sql1="SELECT count(*) as s,SUM(DQTY) AS dqty ,SUM(CAST(GrossWeight AS float)) AS w from Inspection where JobNo='$jobno' and DDATE is not null".$condition ;\
    // ECHO $sql1;
    $run1=sqlsrv_query($conn,$sql1);

    $row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC);
    $dqty = ($row1['dqty']=='')?0:$row1['dqty'];
    $gweight = ($row1['w']=='')?0:$row1['w'];
    $array = array($row1['s'],$dqty,$gweight);

    echo json_encode($array);
}


//for verifying report data
if(isset($_POST['date1'])){
    $date=$_POST['date1'];
    $billno=$_POST['billno'];

    $sql="INSERT INTO Verify (Billno,Billdate,CreatedBy) VALUES('$billno','$date','".$_SESSION['uname']."') ";
    $run=sqlsrv_query($conn,$sql);
    if($run){
        echo ("saved successfully");
    }else{
        print_r(sqlsrv_errors());
    }
}

?>