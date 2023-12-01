
<?php
include('../includes/dbcon.php');
$billno=$_POST['billno'];
$financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
list($startYear, $endYear) = explode('-', $financialYear);

?>
<style>
    #distable{
      
        max-height: 700px; /* Set your desired height */
        overflow-y: auto;
    }
</style>
<div id="distable">
    <table class="table table-bordered text-center table-striped table-hover mb-0">
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
                    <!-- <th>Date</th>
                    <th>Bill No.</th> -->
                </tr>
            </thead>
             <tbody?>
                <?php
                  
                  $sr=1;
                  $sql="SELECT i.ProcessDrum,i.Size1,i.Length1,i.InsLength,d.DDRUMSIZE,od.JobNo as value ,d.DQTY,d.GrossWeight, i.SrNo
                  FROM OrdDetail od 
                  INNER JOIN OrdMaster o ON o.OrdId = od.OrdId
                  INNER JOIN Inspection i ON i.JobNo = od.JobNo
                  FULL OUTER JOIN Dispatch d ON d.ProcessDrum=i.ProcessDrum
                  WHERE  d.DBILLNO = '$billno' AND d.DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
                  AND d.DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5)  ";   
             
                  $run=sqlsrv_query($conn,$sql);
              
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
                 
              </tr>
          <?php
              $sr++;     }      
          ?>   
            </tbody>
    </table>
</div>