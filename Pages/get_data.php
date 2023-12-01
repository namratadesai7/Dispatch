<?php 
include('../includes/dbcon.php');
/*----------------------- code for get autocomplete pono-----------------------*/
if (isset($_POST['pono'])) {
    $ii = $_POST['pono'];
    $query = "SELECT DISTINCT PONO FROM OrdMaster where PONO LIKE '%$ii%'";
	$result = sqlsrv_query($conn,$query);
	while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
		$response[] = array("label"=>$row['PONO']);
	}
	echo json_encode($response);
}
/*----------------------- code for get autocomplete jobno-----------------------*/
if (isset($_POST['jobno'])) {
    $ii = $_POST['jobno'];
    $query = "SELECT JobNo FROM OrdDetail where JobNo LIKE '%$ii%'";
	$result = sqlsrv_query($conn,$query);
	while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
		$response[] = array("label"=>$row['JobNo']);
	}
	echo json_encode($response);
}
/*----------------------- code for get autocomplete pdrum-----------------------*/
// if (isset($_POST['pdrum'])) {
//     $ii = $_POST['pdrum'];
//     $query = "SELECT DrumNo as ProcessDrum from Conductor where step = 'Dispatch' 
//                 UNION ALL
//                 SELECT DrumNo as ProcessDrum from LaidUp where step = 'Dispatch'
//                 UNION ALL
//                 SELECT DrumNo as ProcessDrum from OuterSth where step = 'Dispatch'
//                 UNION ALL
//                 SELECT DrumNo as ProcessDrum from FinalRW where step = 'Dispatch' ";
// 	$result = sqlsrv_query($conn,$query);
// 	while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
// 		$response[] = array("label"=>$row['ProcessDrum']);
// 	}
// 	echo json_encode($response);
// }

/*----------------------- code for get autocomplete dsize-----------------------*/
if (isset($_POST['dsize'])) {
    $ii = $_POST['dsize'];
    $query = "SELECT code FROM Dmaster where code LIKE '%$ii%'";
	$result = sqlsrv_query($conn,$query);
	while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){
		$response[] = array("label"=>$row['code']);
	}
	echo json_encode($response);
}
?>