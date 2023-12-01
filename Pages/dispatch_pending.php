<?php
include('../includes/dbcon.php');
$financialYear = isset($_POST['financial_year']) ? $_POST['financial_year'] : '';
list($startYear, $endYear) = explode('-', $financialYear);
?>
<style>
    /* #reptable{
        width:50%;
    } */

</style>
<div class="divCss" style="overflow-y: scroll; max-height: 90vh;">
<table class="table table-bordered text-center table-striped table-hover mb-0" id="reptable">
    <thead class="bg-secondary text-light">
        <tr><th>Pending Bill No.</th></tr>
    </thead>

<tbody>
<?php
$sql="WITH NumberSeries AS (
    SELECT ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS Num
    FROM master.dbo.spt_values
  ),
  MinMaxValues AS (
    SELECT MIN(DBILLNO) AS MinValue, MAX(DBILLNO) AS MaxValue
    FROM Dispatch
    where
    DDATE >= CONVERT(DATE, CONCAT('01-04-', $startYear), 5) 
    AND DDATE <= CONVERT(DATE, CONCAT('31-03-', $endYear), 5) 
  ),
  MissingNumbers AS (
    SELECT
      ns.Num AS StartRange,
      LEAD(ns.Num, 1, (SELECT MaxValue + 1 FROM MinMaxValues)) OVER (ORDER BY ns.Num) - 1 AS EndRange
    FROM NumberSeries ns
    WHERE ns.Num <= (SELECT MaxValue FROM MinMaxValues)
      AND NOT EXISTS (SELECT 1 FROM Dispatch WHERE DBILLNO = ns.Num)
  )
  SELECT StartRange, EndRange
  FROM MissingNumbers
  WHERE StartRange <= EndRange;";
$run=sqlsrv_query($conn,$sql);
while($row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC)){

?>
   <tr>
    <td><?php echo $row['StartRange']  ?> </td> </tr>
    <?php
}

?>
 
</tbody>
</table>
</div>

<script>
      $(document).ready(function(){
		var table = $('#reptable').DataTable({   // initializes a DataTable using the DataTables library 
		    "processing": true,                  //This option enables the processing indicator to be shown while the table is being processed
			 dom: 'Bfrtip',                      // This option specifies the layout of the table's user interface B-buttons,f-flitering input control,T-table,I-informationsummary,P-pagination
			 ordering: false,                   //sort the columns by clicking on the header cells if true
			 destroy: true,                     //This option indicates that if this DataTable instance is re-initialized, 
                                                //the previous instance should be destroyed. This is useful when you need to re-create the table dynamically.            
		 	lengthMenu: [
            	[ 10, 50, -1 ],
            	[ '10 rows','50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
 	});

</script>