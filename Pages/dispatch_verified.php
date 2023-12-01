<?php
include('../includes/dbcon.php');
$financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
list($startYear, $endYear) = explode('-', $financialYear);
?>
<style>
      .divCss {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1rem 2rem rgba(132, 139,200,0.18) ;
        max-height: 700px; /* Set your desired height */
            overflow-y: auto;
        }
     .billnov{
 
     color:blue !important;
     background:transparent;
     cursor: pointer;
   }
</style>

<div class="divCss" style="overflow-y: scroll; max-height: 90vh;">
    <table class="table table-bordered text-center table-striped mb-0" id="vertable">
        <thead>
            <tr class="bg-secondary text-light">
                <th>Sr</th>
                <th>Bill No.</th>
                <th>Date</th>
                <th>No. of Drums</th>
                <th>Total Qty</th>
                <th>Total Wt(KG)</th>
              
            </tr>
        </thead>
        <tbody>
            <?php
                $sql="SELECT
                DBILLNO,
                FORMAT(MAX(DDATE), 'yyyy-MM-dd') AS Date,
                COUNT(*) AS s,
                SUM(DQTY) AS dqty,
                SUM(TRY_CAST(GrossWeight AS float)) AS w
                FROM
                    Dispatch where DBILLNO IN(SELECT Billno FROM Verify) AND DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
                AND DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) 
                group by DBILLNO";
           
                    $sr=1;
                    $run=sqlsrv_query($conn,$sql);
                    while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                    ?>
                    <tr>        
                        <td><?php echo $sr ?></td>
                        <td ><input type="text" class="billnov" value="<?php echo $row['DBILLNO']   ?>" readonly>   
                        </td>
                        <td><input type="date" class="date" value="<?php echo $row['Date'] ?>" readonly></td>
                        <td><?php echo $row['s'] ?></td>
                        <td><?php echo $row['dqty'] ?></td>
                        <td><?php echo $row['w'] ?></td>
                       
                    </tr>
                <?php
                $sr++;  }    
                ?> 
        </tbody>
    </table>

</div>