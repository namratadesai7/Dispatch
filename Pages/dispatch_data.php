<?php
include('../includes/dbcon.php');
if(isset($_POST['pono']) || isset($_POST['jobno']) || isset($_POST['billno']) ){
$pono=$_POST['pono'];
$jobno=$_POST['jobno'];
$billno=$_POST['billno'];
$financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
list($startYear, $endYear) = explode('-', $financialYear);

// $pdrum=$_POST['pdrum'];
$condition="";

if(!empty($pono)){
    $condition.=" AND PONO= '$pono'";
}
if(!empty($billno) && (!empty($pono) || !empty($jobno)) ){
    $condition.=" AND (  i.ProcessDrum not in (select ProcessDrum FROM Dispatch)  OR
    (d.DBILLNO = '$billno' AND d.DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
     AND d.DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) ) )";
}
if(!empty($billno) && empty($pono) && empty($jobno)){
    $condition.="AND d.DBILLNO = '$billno' AND d.DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
    AND d.DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) ";

}
if(!empty($jobno)){
    $condition.=" AND od.JobNo= '$jobno'";
}
if(empty($billno)){
    $condition.=" AND i.ProcessDrum not in (select ProcessDrum FROM Dispatch)";
}
?>
<style>
    input{
        outline:none;
        border:none;
        background:transparent;
        width:100%;
    }
    th{
    font-weight:400 !important;
    }
    /* Set the table container to have a fixed height and overflow-y: auto */
    .table-container {
        max-height: 700px; /* Set your desired height */
        overflow-y: auto;
        }

    /* Make the table header fixed */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        position: sticky;
        top: 0;
        background-color: #f2f2f2; /* Add a background color if needed */
    }

    th,td {
        padding: 8px;   
        border-bottom: 1px solid #ddd; /* Add a border-bottom for styling */
    }
</style>
<div class="table-container">   
    <table class="table table-bordered text-center table-striped table-hover mb-0" id="distable">
        <thead>
            <tr class="bg-secondary text-light" >
                <th >Sr</th>
                <th >Job No.</th>
                <th >Size & Type</th>
                <th >Process Drum</th>
                <th >Length</th>
                <th >Ins. Length</th>
                <th >Dispatch Length</th>
                <th >Drum Size</th>
                <th >Gross Weight</th>
                <th >Action</th>
                <!-- <th>Date</th>
                <th>Bill No.</th> -->
            </tr>
        </thead>
        <tbody>
            <?php                 
                $sr=1;
                $sql="SELECT distinct(od.OrdID),o.customer,i.ProcessDrum,i.Size1,i.Length1,i.InsLength,d.DDRUMSIZE,od.JobNo as value ,d.DQTY,d.GrossWeight, i.SrNo
                FROM OrdDetail od 
                INNER JOIN OrdMaster o ON o.OrdId = od.OrdId
                INNER JOIN Inspection i ON i.JobNo = od.JobNo
                FULL OUTER JOIN Dispatch d ON d.ProcessDrum=i.ProcessDrum
                WHERE od.OrdID > 0 ".$condition."  
                ORDER BY od.JobNo";   
                // AND i.ProcessDrum NOT IN (select ProcessDrum from Dispatch)
                $run=sqlsrv_query($conn,$sql);
                // ECHO $sql;
                // $sql1="SELECT DDRUMSIZE,DQTY,GrossWeight FROM Inspection where DBILLNO='' ";
                while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
            ?>
            <tr>                            
                <th><?php echo $sr ?></th>
                <th><input type="text" name="jobno[]" class="jobno" value="<?php echo $row['value'] ?>" readonly></th>
                <th><?php echo $row['Size1']  ?></th>
                <th><input type="text" name="pdrum[]" value="<?php echo $row['ProcessDrum'] ?>" readonly></th>
                <th><?php echo $row['Length1']  ?></th>
                <th><?php echo $row['InsLength'] ?></th>
                <th><input type="text" name="dlength[]" class="dlength" value="<?php echo $row['DQTY']  ?>" ></th>      
                <th><input type="text" name="dsize[]" class="dsize" onFocus="Searchdsize(this)" value="<?php echo $row['DDRUMSIZE']  ?>" ></th>
                <th><input type="number" name="gweight[]" class="gweight" value="<?php echo $row['GrossWeight']  ?>" ></th>
                <td><button type="button" class="btn btn-sm btn-success rounded-pill submit1" id="<?php echo $row['ProcessDrum']  ?>">Save</button>
                    <!-- <button type="button" class="btn btn-sm btn-danger rounded-pill delete" id="<?php $row['ProcessDrum']  ?>"> Delete</button>                   -->
                </td>
                <!-- <th><input type="date"  name="date" class="date"></th>
                <th><input type="number"  name="billno"></th> -->
            </tr>
        <?php
            $sr++;     }      
        ?>                                
        </tbody>
    </table>
</div>    
<?php
}
?>