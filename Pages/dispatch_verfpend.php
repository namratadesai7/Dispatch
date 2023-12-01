<?php
include('../includes/dbcon.php');
$financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
list($startYear, $endYear) = explode('-', $financialYear);

?>
  
        <div class="divCss table-container " id="show">
            <table class="table table-bordered text-center table-striped table-hover mb-0" id="reptable1">
                <thead>
                    <tr class="bg-secondary text-light">
                        <th>Sr</th>
                        <th>Bill No.</th>
                        <th>Date</th>
                        <th>No. of Drums</th>
                        <th>Total Qty</th>
                        <th>Total Wt(KG)</th>
                        <th>Verify</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sr=1;
                        $sql = "SELECT
                                    DBILLNO,
                                    FORMAT(MAX(DDATE), 'yyyy-MM-dd') AS Date,
                                    COUNT(*) AS s,
                                    SUM(DQTY) AS dqty,
                                    SUM(TRY_CAST(GrossWeight AS float)) AS w
                                FROM
                                    Dispatch                              
                                WHERE
                                     DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
                                     AND DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) 
                                    AND DBILLNO NOT IN(SELECT Billno FROM Verify)   
                                GROUP BY
                                    DBILLNO
                                ORDER BY
                                TRY_CAST(DBILLNO AS int) DESC ";

                        $run=sqlsrv_query($conn,$sql);
                        while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){
                    ?>
                    <tr>        
                        <th><?php echo $sr ?></th>
                        <th><input type="text" class="billno"  value="<?php echo $row['DBILLNO']   ?>" readonly></th>
                        <th><input type="date" class="date" value="<?php echo $row['Date'] ?>" readonly></th>
                        <th><?php echo $row['s'] ?></th>
                        <th><?php echo $row['dqty'] ?></th>
                        <th><?php echo $row['w'] ?></th>
                        <th><button type="button" class="btn btn-sm btn-success rounded-pill verify" id="<?php echo $row['DBILLNO']  ?>">Verify</button></th>
                    </tr>
                <?php
                $sr++;  }    
                ?> 
                </tbody>
            </table>
        </div>
        <SCRIPT>
                $(document).ready(function(){
		var table = $('#reptable1').DataTable({  
		    "processing": true,                  
			 dom: 'Bfrtip',                    
			 ordering: false,                   
			 destroy: true,                    
                                                
            
		 	lengthMenu: [
            	[ 10, 50, -1 ],
            	[ '10 rows','50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
 	});
        </SCRIPT>