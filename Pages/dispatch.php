<?php
include('../includes/dbcon.php');
include('../includes/header.php'); 
$date=date('Y-m-d'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatch</title>
    
    <style>
    .fl{
        margin:2rem;
         
     }
    .divCss {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 1rem 2rem rgba(132, 139,200,0.18) ;
    }
    /* .save{
        display:flex;
        justify-content:center;
        align-items:center;        
    } */
    .ui-autocomplete {
        font-size: 15px !important;
        max-width: 430px;
        max-height: 180px;
        overflow-y: auto;
        overflow-x: hidden;
        border-radius: 5px;
        padding: 10px;
        z-index: 21500000 !important;
        }
      /* .common-btn{
         background-color: #62bdae;
         border:none;
         color:white !important;
     } */
     /* .row{
         
     }
     #sumTable th{
         white-space: nowrap !important;
          font-size:1rem; 
         padding: 8px 6px;
         width:100px !important;
     }
     #sumTable td{
         white-space:nowrap; */
        /* // font-size:0.8rem; */
         /* padding: 6px; */

 </style>
</head>
<body>
    <div class="fl" >
        <div class="row mb-3">
            <div class="col"><h4 class="pt-2 mb-0">Dispatch From Update</h4></div>
            <!-- <div class="col-auto"> <a class="btn btn-warning p-2" href="summary_add.php">+Add</a></div> -->
        </div>
        <form id="disform">
            <div class="divCss ">
                <div class="row px-2">
                    <!-- <label class="form-label col-lg-3 col-md-6 " for="cp">Core/Pair
                        <select  class="form-select cp" name="cp" id="cp" required>
                            <option disabled selected value="">--Select--</option>
                            <option value="core pair">Core Pair</option>
                            <option value="c">C</option>
                            <option value="p">P</option>
                            <option value="q">Q</option>
                            <option value="t">T</option>
                        </select>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="nocore">No. of Core
                        <input type="text"  class="form-select nocore" name="nocore" id="nocore"></input>
                    </label>

                    <label class="form-label col-lg-3 col-md-6" for="sqmm">SQMM
                        <input type="text" class="form-select sqmm" name="sqmm" id="sqmm"></input>
                    </label> -->

                    <label class="form-label col-lg-3 col-md-6" for="PONO">PO No.
                        <input type="text" class="form-control searchInput pono" name="pono" id="PONO" onFocus="SearchPONO(this)" placeholder="PONo"></input>
                    </label>    

                    <label class="form-label col-lg-3 col-md-6" for="JobNo">Job No.
                        <input type="text" class="form-control searchInput jobno" name="jobno" id="JobNo" onFocus="Searchjobno(this)" placeholder="Job Name"></input>
                    </label> 
                    
                     <!-- <label class="form-label col-lg-3 col-md-6" for="ProcessDrum">Process Drum
                        <input type="text" class="form-control searchInput pdrum" id="ProcessDrum" onFocus="Searchpdrum(this)" placeholder="process drum"></input>
                    </label>  -->
                     
                    <label class="form-label col-lg-3 col-md-6" for="billno">Bill No.
                        <input type="text" class="form-control billno" name="billno" id="billno" placeholder="Bill No."  oninput="validateInput(this)"></input>
                        <p id="alertMessage" style="color: red;"></p>
                    </label> 

                    <label class="form-label col-lg-3 col-md-6" for="date">Date
                        <input type="date" class="form-control date" name="date" id="date" value="<?php echo $date ?>"></input>
                    </label> 

                    <label class="form-label col-lg-3 col-md-6" for="tdrum">Total Drum
                        <input type="number" class="form-control tdrum" name="tdrum" id="tdrum"></input>
                    </label> 

                    <label class="form-label col-lg-3 col-md-6" for="dqty">Drum Qty
                        <input type="number" class="form-control dqty" name="dqty" id="dqty"></input>
                    </label> 

                    <label class="form-label col-lg-3 col-md-6" for="dweight">Drum Weight
                        <input type="number"  step="0.01" class="form-control dweight" name="dweight" id="dweight" ></input>
                    </label> 
                    <label class="form-label col-lg-3 col-md-6" for="dweight">Financial Year
                        <select class="form-control" id="year" name="year">
                           
                            <?php   
                                $y = date("y",strtotime("+1 year"));
                                for ($i = 0; $i <= 7; $i++) { 
                                    $y1 = date("y",strtotime("-$i year"));
                                    $y2 = date("Y",strtotime("-$i year"));
                            ?>
                            <option  value="<?php echo $y1.'-'.$y ?>"><?php echo $y2.'-'.$y ?></option>
                            <?php $y = $y1; } ?>
                        </select>
                    </label> 
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-auto">
                            <button type="button" class="btn btn-rounded btn-danger search">Search</button>
                            <!-- <div class="save"> -->
                                <button type="button" class="btn btn-success rounded-pill mt-4 py-2 mb-4 submit" name="submit">Save</button>
                            <!-- </div> -->
                    </div>
                </div>
            </div><br>
           
            <div class="divCss" id="showdata" >
                <table class="table table-bordered text-center table-striped table-hover mb-0" id="distable">
                    <thead>
                        <tr class="bg-secondary text-light">
                            <th>Sr</th>
                            <th>Job No.</th>
                            <th>Size & Type</th>
                            <th>Process Drum</th>
                            <th>Length</th>
                            <th>Ins.Length</th>
                            <th>Dispatch Length</th>
                            <th>Drum Size</th>
                            <th>Gross Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                                    
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>
</html>

<script>
  $('#dispatch').addClass('active');

    function SearchPONO(txtBoxRef) {
      
      	var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13'){
                f = false;
            }
        });
       	$(txtBoxRef).autocomplete({      
	        source: function( request, response ){
	       		$.ajax({
	         		url: "get_data.php",
	          		type: 'post',
	          		dataType: "json",
	          		data: { pono: request.term },
	          		success: function( data ) {
	            		response( data );
	            	},
                    error:function(data){
                        console.log(data);
                    }
	          	});
	        },
	        select: function (event, ui) {
	           	$('#PONO').val(ui.item.label);
	           	return false;
	      	},
	      	change: function (event, ui) {
	          	if (f){
	              	if (ui.item == null){
	                	$(this).val('');
	                	$(this).focus();
	              	}
	            }
	        }
      	});
    }

    function Searchjobno(txtBoxRef) {
      
      	var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13'){
                f = false;
            }
        });
       	$(txtBoxRef).autocomplete({      
	        source: function( request, response ){
	       		$.ajax({
	         		url: "get_data.php",
	          		type: 'post',
	          		dataType: "json",
	          		data: { jobno: request.term },
	          		success: function( data ) {
	            		response( data );
	            	},
                    error:function(data){
                        console.log(data);
                    }
	          	});
	        },
	        select: function (event, ui) {
	           	$('#JobNo').val(ui.item.label);
	           	return false;
	      	},
	      	change: function (event, ui) {
	          	if (f){
	              	if (ui.item == null){
	                	$(this).val('');
	                	$(this).focus();
	              	}
	            }
	        }
      	});
    }

    function Searchdsize(txtBoxRef) {
      
      	var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13'){
                f = false;
            }
        });
       	$(txtBoxRef).autocomplete({      
	        source: function( request, response ){
	       		$.ajax({
	         		url: "get_data.php",
	          		type: 'post',
	          		dataType: "json",
	          		data: { dsize: request.term },
	          		success: function( data ) {
	            		response( data );
	            	},
                    error:function(data){
                        console.log(data);
                    }
	          	});
	        },
	        select: function (event, ui) {
	           	$(this).val(ui.item.label);
	           	return false;
	      	},
	      	change: function (event, ui) {
	          	if (f){
	              	if (ui.item == null){
	                	$(this).val('');
	                	$(this).focus();
	              	}
	            }
	        }
      	});
    }


  $(document).on('click','.search', function(){
 
    var pono=$('#PONO').val();
    var jobno=$('#JobNo').val();
    var billno=$('#billno').val();
    var year=$('#year').val();

    // if(billno!='' && (pono== '' && jobno=='' )){
    //         alert("Pleae fill JobNo. or PONo.");
    //         return false;

    // }else{
    $.ajax({
        url:'dispatch_data.php',
        type:'post',
        data:{pono:pono,jobno:jobno,billno:billno,financial_year:year},
        success:function(data){
            $('#showdata').html(data);
            $.ajax({
                url:'dispatch_db.php',
                type:'post',
                dataType:'json',
                data:{job_no:jobno,bill_no:billno,financial_year:year},
                success:function(response){
                // console.log(response);
                    $('#tdrum').val((response[0]).toFixed(2));
                    $('#dqty').val((response[1]).toFixed(2));
                    $('#dweight').val((response[2]).toFixed(2));
                },
                error:function(res){
                    console.log(res);
                }
            });
        },
        error:function(res){
            console.log(res);
        }
    })
// }

  });

  $(document).on('click','.submit',function(){

    // if(billno==''|| dlength== '' ||dsize=='' || gweight=='' ||date==''){
    //           //  alertMessage.textContent = "'Please fill Bill No. and update date'";
    //             alert("Pleae fill all the fields");
    //                             return false;

    // }
    // else{
        $.ajax({
            url:'dispatch_db.php',
            type:'post',
            data:$('#disform').serialize(),
            success:function(response){
            //  $('#showdata').html('<table class="table table-bordered text-center table-striped table-hover mb-0" ><thead><tr class="bg-secondary text-light"><th>Sr</th><th>Job No.</th>  <th>Size & Type</th> <th>Process Drum</th><th>Length</th> <th>Ins.Length</th><th>Dispatch Length</th> <th>Drum Size</th> <th>Gross Weight</th> </tr></thead></table>');
            alert(response);
            }
        })
    // }
  })

  
$(document).on("click",".submit1",function(){
            var id=$(this).attr('id');
            var dlength = $(this).closest('tr').find('.dlength').val();
            var dsize= $(this).closest('tr').find('.dsize').val();
            var gweight=$(this).closest('tr').find('.gweight').val();
            var jobno=$(this).closest('tr').find('.jobno').val();
            var date=$('#date').val();
            var billno=$('#billno').val();
            if(billno==''|| dlength== '' ||dsize=='' || gweight=='' ||date==''){
              //  alertMessage.textContent = "'Please fill Bill No. and update date'";
                alert("Pleae fill all the fields");
                                return false;

            }
            else{
               
                $.ajax({
                url:'dispatch_db.php',
                type:'post',
                data:{id:id,dlength:dlength,dsize:dsize,gweight:gweight,date:date,billno:billno,jobno:jobno},
                success:function(data){
                    alert(data);
                   // $('#showdata').html('<table class="table table-bordered text-center table-striped table-hover mb-0" ><thead><tr class="bg-secondary text-light"><th>Sr</th><th>Job No.</th>  <th>Size & Type</th> <th>Process Drum</th><th>Length</th> <th>Ins.Length</th><th>Dispatch Length</th> <th>Drum Size</th> <th>Gross Weight</th> </tr></thead></table>');
         
                },
                error:function(res){
                    console.log(res);
                }
            });
            }
            
      });

      
//to update records without the button for date on change of billno
$(document).on('input','.billno',function(){
        
        var billno = $(this).val();
        var pono = $('#PONO').val();
        var jobno = $('#JobNo').val();
        var year=$('#year').val();
       

        // if(billno!='' && (pono== '' && jobno=='')){
        //     //alert("Pleae fill JobNo. or PONo.");
        //                         return false;

        // }else{
            $.ajax({
            url:'dispatch_getdate.php',
            type:'post',
            dataType:'json',
            data:{billno:billno,pono:pono,jobno:jobno,financial_year:year},
            success:function(data){
                // console.log(data);
                 // Access individual values
                 var dateValue = data.date;
                 var financialYearValue = data.financial_year;
                $('#date').val(dateValue);
                $('#year').val(financialYearValue);
            },
            error:function(res){
               // console.log(res);
            }
        });

        // }
         // If billno is empty, set default date to today's date
    if (billno === '') {
        var today = new Date();
        var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        $('#date').val(formattedDate);

           // Calculate financial year based on the selected date
        var fiscalYear;
        if (today.getMonth() + 1 < 4) {
        // If the current month is before April, then the financial year is in the previous year
        fiscalYear = (today.getFullYear() - 1).toString().slice(-2) + '-' + today.getFullYear().toString().slice(-2);
        } else {
        // If the current month is April or later, then the financial year is in the current year
        fiscalYear = today.getFullYear().toString().slice(-2) + '-' + (today.getFullYear() + 1).toString().slice(-2);
         }

        // Set the calculated financial year to the respective field
        $('#year').val(fiscalYear);
    }
        
    })
    // $(document).on('keydown','.billno',function(){
    //     const d=new Date();
    //     console.log(d);
    //     $('#date').val(d);


    // });



      //to update records without the button
//   $(document).on('keyup','.searchInput',function(){
//     var colunm = $(this).attr('id');
//     var value = $(this).val();
//     $.ajax({
//         url:'dispatch_data.php',
//         type:'post',
//         data:{colunm:colunm,value:value},
//         success:function(data){
//             $('#showdata').html(data);
//         },
//         error:function(res){
//             console.log(res);
//         }
//     });
//   })


function validateInput(input) {
    // Regular expression to allow only numeric characters
    var regex = /^[0-9]*$/;

    // Get the value entered by the user
    var inputValue = input.value;

    // Check if the entered value matches the regular expression
    if (!regex.test(inputValue)) {
        // Display an error message and clear the input
        document.getElementById('alertMessage').innerText = 'Only numeric characters are allowed.';
        input.value = inputValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    } else {
        // Clear the error message
        document.getElementById('alertMessage').innerText = '';
    }
}
$(document).on('change','#year',function(){
    var year=$('#year').val();
   var billno=$('#billno').val();
 
//    if(billno!=''){
     $.ajax({
            url:'dispatch_getdate.php',
            type:'post',
            data:{bill_no:billno,financial_year:year},
            success:function(data){          
                $('#date').val(data);
            },
            error:function(res){
               console.log(res);
            }
    });
// }
// else{
//     return false;
// }
});
// $(document).on('input','.jobno',function(){
//     $('#billno').val('');
//     var today = new Date();
//     var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
//     $('#date').val(formattedDate);

           
//     var fiscalYear;
//     if (today.getMonth() + 1 < 4) {
    
//     fiscalYear = (today.getFullYear() - 1).toString().slice(-2) + '-' + today.getFullYear().toString().slice(-2);
//     } else {

//     fiscalYear = today.getFullYear().toString().slice(-2) + '-' + (today.getFullYear() + 1).toString().slice(-2);
//     }

//     $('#year').val(fiscalYear);

// });

</script>
<?php

include('../includes/footer.php');
?>


