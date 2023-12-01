<?php
include('../includes/dbcon.php');
include('../includes/header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        input{
        outline:none;
        border:none;
        background:transparent;
        width:100%;
        }
        .fl{
         margin:2rem;   
        }
        .divCss {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1rem 2rem rgba(132, 139,200,0.18) ;
        max-height: 700px; /* Set your desired height */
            overflow-y: auto;
        }
        th{
        font-weight:400 !important;
        }
         /* Set the table container to have a fixed height and overflow-y: auto */
    /* .table-container {
        max-height: 700px; /* Set your desired height */
            overflow-y: auto;
        } */

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

        th, td {
            padding: 8px;
          
            border-bottom: 1px solid #ddd; /* Add a border-bottom for styling */
        }
    </style>
</head>
<body>
    <div class="fl">
        <div class="row mb-3">
            <div class="col">
                <h4 class="pt-2 mb-0" id="textBtn">Dispatch Report</h4>
            </div>
            <div class="col">
                <button type="button" class="btn btn-rounded btn-success" id="verpending">Verify</button>
                <button type="button" class="btn btn-rounded btn-danger" id="searchBtn">Pending Invoice</button>
                <button type="button" class="btn btn-rounded btn-warning" id="verified">View Verified</button>
            </div>
            <!-- <div class="col">
                
            </div> -->
            <div class="col-auto">
                <select class="form-control" id="year" style="width: 150px;">
				   		<option disabled></option>
				   		<?php 
                            $y = date("y",strtotime("+1 year"));
                            for ($i = 0; $i <= 3; $i++) { 
                                $y1 = date("y",strtotime("-$i year"));
                                $y2 = date("Y",strtotime("-$i year"));
                        ?>
                        <option <?php if($y1.'-'.$y=='23-24') { ?> selected <?php } ?> value="<?php echo $y1.'-'.$y ?>"><?php echo $y2.'-'.$y ?></option>
                        <?php $y = $y1; } ?>
				</select>
            </div>
            
        </div>
        <div class="mb-3" id="showdata">

        </div>
        <div class="mb-3" id="showver">

        </div>
        <div class="mb-3" id="verpend">
            
        </div>

           
        <!-- <div class="divCss table-container " id="show">
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
                                    DDATE >= CONVERT(DATE, '01-04-23', 5) -- Assuming 'DDATE' is in the format 'dd-MM-yy'
                                    AND DDATE <= CONVERT(DATE,'31-03-24',5) -- Assuming 'DDATE' is in the format 'dd-MM-yy' 
                                    AND DBILLNO NOT IN(SELECT Billno FROM Verify)   
                                GROUP BY
                                    DBILLNO
                                ORDER BY
                                TRY_CAST(DBILLNO AS int) DESC
                                ";

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
        </div> -->
    </div>
    
         <!-- Modal -->
         <div class="modal fade" id="enqModal" tabindex="-1" aria-labelledby="enqModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content ">
                    <div class="modal-header  modal-xl">
                        <h5 class="modal-title">List of Dispatch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="resultTable">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary" name="save" form="catform">Save </button> -->
                    </div>
                </div>
            </div>
        </div> 
</body>
</html>

<script>


$(document).ready(function(){
		var table = $('#reptable1').DataTable({  
		    "processing": true,                  
			 dom: 'Bfrtip',                      
			 ordering: false,                  
			 destroy: true,                     
                                               
		 	lengthMenu: [
            	[ 15, 50, -1 ],
            	[ '15 rows','50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength','copy', 'excel'
        	]
    	});
});

    $(document).on('click','#verpending', function(){
        var year=$('#year').val();
        $.ajax({
            url:'dispatch_verfpend.php',
            type:'post',
            data:{financial_year:year},
            success:function(data){
                // $('#verpend').html(data);  
                $('#showdata').html(data);  
            },
            error:function(res){
                console.log(res);
            }
        })
    });


    $(document).on('click','#searchBtn', function(){
        var year=$('#year').val();
        $.ajax({
            url:'dispatch_pending.php',
            type:'post',
            data:{financial_year:year},
            success:function(data){
                $('#showdata').html(data);  
            },
            error:function(res){
                console.log(res);
            }
        })
    });

    $(document).on('click','#verified', function(){
        var year=$('#year').val();
        $.ajax({
            url:'dispatch_verified.php',
            type:'post',
            data:{financial_year:year},
            success:function(data){
                //$('#showver').html(data);  
                $('#showdata').html(data);  
            },
            error:function(res){
                console.log(res);
            }
        })
    });

    // $(document).on('change','#year', function(){
    //     var year=$('#year').val();
        
    //     $.ajax({
    //         url:'dispatch_year.php',
    //         type:'post',
    //         data:{financial_year:year},
    //         success:function(data){
    //             $('#show').html(data);  
    //         },
    //      error:function(res){
    //          console.log(res);
    //      }
    //     })
    // });

    
    $(document).on('click','.verify', function(){
     
        var id=$(this).attr('id');
        var billno=$(this).closest('tr').find('.billno').val();
        var date=$(this).closest('tr').find('.date').val();
       console.log(billno);
       console.log(date)
        $.ajax({
            url:'dispatch_db.php',
            type:'post',
            data:{billno:billno,date1:date},
            success:function(data){
              alert(data);
            //   location.reload();
            },
         error:function(res){
             console.log(res);
         }
        })
    });
    $(document).on('click','.billnov',function(){
    // $('.billnov').click(function () {
        var billno=$(this).val();
        var year=$('#year').val();
        console.log(billno)
         
         $.ajax({
             url:'dispatch_modal.php',
             type:'post',
             data:{billno:billno,financial_year:year},
             success:function(data){
                 $("#resultTable").html(data);
                 $("#enqModal").modal("show");
             }
         });
    }); 
   
           
</script>
<?php
include('../includes/footer.php');
?>