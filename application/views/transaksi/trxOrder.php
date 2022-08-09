<style>
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: grid;
    width: auto;
}
.selected{
    color: red;
    cursor: pointer;
    }
tbody tr {
cursor: pointer;
}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">


    <form>
        <hr>
        <h3><center>DATA ORDER</center></h3>
        <hr>
        <div class="form-row" >
        
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="od_no" name="od_no" placeholder="Order No" readonly>
            </div>
            
            <div class='col-md-6'>
                <div class="input-group mb-3">
                    <input type="text" class="form-control date-pick" placeholder="Select Date" value="<?= date('d-m-Y')?>"  id="date" name="date" aria-label="Select Date" readonly>
                    
                    <!-- <input type="text" class="form-control date-pick" placeholder="Select Date"  id="date" name="date" aria-label="Select Date" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </div> -->
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" style="margin-bottom:8px" class="form-control" id="cs_code" name="cs_code" placeholder="Customer Code" readonly> 
                <input type="text" class="form-control" id="cs_nm" name="cs_nm" placeholder="Customer Name" readonly>
            </div>
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary btncs" data-toggle="modal" data-target="#myCustomerModal">Select</button>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" style="margin-bottom:8px" id="sts_code" name="sts_code" placeholder="Status Code" readonly> 
                <input type="text" class="form-control" id="sts_nm" name="sts_nm" placeholder="Status Name" readonly>
            </div>
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myStatusModal">Select</button>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-5">
                <input type="text" style="" class="form-control" id="pd_code" name="pd_code" placeholder="Product Code" readonly> 
            </div>
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="pd_nm" name="pd_nm" placeholder="Product Name" readonly>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myProductModal">Select</button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="develop_fee" name="develop_fee" placeholder="Develop Fee %" readonly>
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="admin_fee" name="admin_fee" placeholder="Admin Fee %" readonly>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="pd_price" name="pd_price" placeholder="Product Price" readonly>
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="pd_qty" name="pd_qty" max="10" placeholder="Product QTY" >
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="pd_total_price" name="pd_total_price" placeholder="Total Harga" readonly>
            </div> 
            <div class='col-md-4'>
                <div class="input-group mb-3">
                    <input type="text" class="form-control date-pick" placeholder="Select DaedLine"  id="daedline" name="daedline" aria-label="Select Date" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </from>
        <hr>
        <h3><center>DATA WORKER</center></h3>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-5">
                <input type="text" style="margin-bottom:8px" class="form-control" id="wr_code" name="wr_code" placeholder="Worker Code" readonly>       
            </div>
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="wr_nm" name="wr_nm" placeholder="Worker Name" readonly>
            </div>
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myWorkerModal">Select</button>
            </div>   
        </div>

        <div class="form-row">
            <div class="form-group col-12 pl-10">
                <div class="table-responsive " id="show" style="padding-top:10px">
                    <div class="text-right mb-2"> 
                        <button type="button" id="addtolist" class="btn btn-primary">Add To List</button>
                        <button id="buttondelete" name="singlebutton" class="btn btn-danger">X</button> 
                    </div>
                    <table id="gridaccess" class="table table-striped table-bordered " style="width:100%; ">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Dead Line</th>
                                <th scope="col">Worker Code</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Status Code</th>
                                <th scope="col">Status Name</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Product QTY</th>
                                <th scope="col">Develop Fee</th>
                                <th scope="col">Admin Fee</th>
                                <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                                
                        </tbody>
                    </table>
                </div>
            </div>  
        </div>
    
    <div class="form-row"> 
        <div class="form-group col-md-9">
            <button type="button" id="insert" class="btn btn-primary mb-2">Insert Data</button>
        </div>
        <div class="form-group col-md-3"> 
            <input type="text"  class="form-control" id="grn_ttl" name="grn_ttl" placeholder="Grand Total" readonly>
        </div>
    </div>
   
</div>


<div class="modal fade"  id="myCustomerModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="customershow">
              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->

<div class="modal fade"  id="myWorkerModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="workershow">
              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->


<div class="modal fade"  id="myProductModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="productshow">
              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->


<div class="modal fade"  id="myStatusModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="statusshow">
              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->




<script type="text/javascript" language="javascript">

$(function()
{
	$('.date-pick').datePicker()
	$('#start-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
});
    $(document).ready(function() {
        const t = $('#gridaccess').DataTable({
                    //destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
        let counter = 1;
        
        
        autoNumber();
        showAllCustomer();
        showAllWorker();
        showAllProduct();
        showAllStatus();
   
        $('#daedline').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: 2,
            todayHighlight: true,
            autoclose: true,
        })

        $('#addtolist').on('click',function(e){
            var listview = t.rows().data().toArray();
            var od_no = $('#od_no').val();
            var date = $('#date').val();
            var daed_line = $('#daedline').val();
            var cs_code = $("#cs_code").val();
            var cs_nm = $("#cs_nm").val();
            var sts_code = $("#sts_code").val();
            var sts_nm = $("#sts_nm").val();
            var wr_code = $("#wr_code").val();
            var wr_nm =  $("#wr_nm").val();
            var pd_code =  $("#pd_code").val();
            var pd_nm = $("#pd_nm").val();
            var pd_price = $("#pd_price").val().substr(4).replace(/[^,\d]/g, '');
            var pd_qty = $("#pd_qty").val();
            var develop_fee = $("#develop_fee").val();
            var admin_fee = $("#admin_fee").val();
            var pd_total_price = $("#pd_total_price").val().substr(4).replace(/[^,\d]/g, '');
 
            if (date == "" || cs_code == "" || wr_code == "" || pd_code == "" || pd_qty == "" || sts_code == "" || daed_line == "" ) {
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'there is still empty data',
                    showConfirmButton: false,
                    timer: 2000
                    });
            } else {
                var validasi = 'false'; //false
                for(let r = 0; r<listview.length; r++){
                    for(let c = 0; c<listview[r].length; c++){
                        if(listview[r][1] == od_no  && listview[r][7] == pd_code){
                            validasi = 'true'; //true
                        }
                    }
                }
                if(validasi == 'true'){
                    Swal.fire({ //sweet alert
                        position: 'center',
                        icon: 'error',
                        title: 'Already In The List',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else{
                    Swal.fire({ //sweet alert
                        position: 'center',
                        icon: 'success',
                        title: 'Add Data To List Successfully',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    t.row.add([
                        counter,
                        od_no,
                        daed_line,
                        wr_code,
                        wr_nm,
                        sts_code,
                        sts_nm,
                        pd_code,
                        pd_nm,
                        pd_price,
                        pd_qty,
                        develop_fee,
                        admin_fee,
                        pd_total_price,
                    ]).draw(false);
                    counter++;
                }
                $("#wr_code").val('');
                $("#wr_nm").val('');
                $("#pd_code").val('');
                $("#pd_nm").val('');
                $("#pd_price").val('');
                $("#pd_qty").val('');
                $("#develop_fee").val('');
                $("#admin_fee").val('');
                $("#pd_total_price").val('');
                $("#daedline").val('');
  
                var grandtotal = 0;
                var data = t.rows().data().toArray();
                for(var i = 0; i < data.length; i++){
                    grandtotal += parseInt(data[i][13]);
                }
                $('#grn_ttl').val(grandtotal);
                var grandtotal = document.getElementById('grn_ttl');
                grandtotal.value = formatRupiah($("#grn_ttl").val(), 'Rp. ');
            }  
        })

       //start delete row
       $('#gridaccess tbody').on('click','tr',function () {
            if ($(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
            } else {
                t.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#buttondelete').click( function (event) {
            event.preventDefault();
            t.row('.selected').remove().draw(false);
        });

    //--------------------------------------FUNCTION TO CONTROLLER--------------------------------------------------------------------------------------//
    //insert data;
    $('#insert').on('click', function(e) {
        var datalist = t.rows().data().toArray();
        if( datalist.length == 0){
            Swal.fire({ //sweet alert
                position: 'center',
                icon: 'error',
                title: 'Please Insert Data To List',
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            $.ajax({
                url: "<?= base_url('TrxOrder/insertOrder') ?>",
                method: "POST",
                data: {
                    orderno: $('#od_no').val(),
                    orderdate: $('#date').val(),
                    cscode: $('#cs_code').val(),
                    stscode: $('#sts_code').val(),
                    order: t.rows().data().toArray(), // array 2 dimensi   
                },
                success: function(result) {
                    var result = eval('(' + result + ')');
                    if (result.success) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        autoNumber();
                        showAllCustomer();
                        showAllWorker();
                        showAllProduct();
                        showAllStatus();
                        $("#daedline").val('');
                        $("#cs_code").val('');
                        $("#cs_nm").val('');
                        $("#sts_code").val('');
                        $("#sts_nm").val('');
                        $("#wr_code").val('');
                        $("#wr_nm").val('');
                        $("#pd_code").val('');
                        $("#pd_nm").val('');
                        $("#pd_price").val('');
                        $("#pd_qty").val('');
                        $("#develop_fee").val('');
                        $("#admin_fee").val('');
                        $("#pd_total_price").val('');
                        $("#grn_ttl").val('');
                        t.rows().remove().draw();
                    } else {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        autoNumber();
                        showAllCustomer();
                        showAllWorker();
                        showAllProduct();
                        showAllStatus();
                        $('#date').val('');
                        $("#cs_code").val('');
                        $("#cs_nm").val('');
                        $("#sts_code").val('');
                        $("#sts_nm").val('');
                        $("#wr_code").val('');
                        $("#wr_nm").val('');
                        $("#pd_code").val('');
                        $("#pd_nm").val('');
                        $("#pd_price").val('');
                        $("#pd_qty").val('');
                        $("#develop_fee").val('');
                        $("#admin_fee").val('');
                        $("#pd_total_price").val('');
                        $("#grn_ttl").val('');
                        t.rows().remove().draw();
                    }
                }
            });
        } 
    }); 
      
});

    function autoNumber(){
        $.ajax({
            url: "TrxOrder/autonumber",
            method: "POST",
            success: function(response) {
                $("#od_no").val(response);
            }
        });
    }
 
    function showAllCustomer() {
        $.ajax({
            url: "TrxOrder/viewcustomer",
            method: "POST",
            success: function(response) {
                $('#customershow').html(response);
                $("#customer").DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }
    function showAllWorker() {
        $.ajax({
            url: "TrxOrder/viewworker",
            method: "POST",
            success: function(response) {
                $('#workershow').html(response);
                $("#worker").DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }
    function showAllProduct() {
        $.ajax({
            url: "TrxOrder/viewproduct",
            method: "POST",
            success: function(response) {
                $('#productshow').html(response);
                $("#product").DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }
 function showAllProduct() {
        $.ajax({
            url: "TrxOrder/viewproduct",
            method: "POST",
            success: function(response) {
                $('#productshow').html(response);
                $("#product").DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }
    function showAllStatus() {
        $.ajax({
            url: "TrxOrder/viewstatus",
            method: "POST",
            success: function(response) {
                $('#statusshow').html(response);
                $("#status").DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }
    $("body").on('click', '.selectcustomer', function(e){
        $.ajax({
            url: "<?= base_url('TrxOrder/getByIdCS') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#cs_code").val(data.cs_code);
                $("#cs_nm").val(data.cs_nm);
                $('#myCustomerModal').modal('hide');
            }
        });
    });

    $("body").on('click', '.selectworker', function(e){
        $.ajax({
            url: "<?= base_url('TrxOrder/getByIdWK') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#wr_code").val(data.wr_code);
                $("#wr_nm").val(data.wr_nm);
                $('#myWorkerModal').modal('hide');
            }
        });
    });

    $("body").on('click', '.selectproduct', function(e){
        $.ajax({
            url: "<?= base_url('TrxOrder/getByIdPD') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#pd_code").val(data.pd_code);
                $("#pd_nm").val(data.pd_nm);
                $("#pd_price").val(data.price);
                $("#develop_fee").val(data.develop_fee);
                $("#admin_fee").val(data.admin_fee);
                var rupiah = document.getElementById('pd_price');
                rupiah.value = formatRupiah($("#pd_price").val(), 'Rp. ');
                //$("#pd_price").val(data.price);
                $('#myProductModal').modal('hide');
            }
        });
    });

    $("body").on('click', '.selectstatus', function(e){
        $.ajax({
            url: "<?= base_url('TrxOrder/getByIdSTS') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#sts_code").val(data.sts_code);
                $("#sts_nm").val(data.sts_nm);
                $('#myStatusModal').modal('hide');
            }
        });
    });


    $("#pd_qty").on('keyup', function (params) {
        var price = $("#pd_price").val().substr(4).replace(".","");
        var qty  =   $("#pd_qty").val();
        if(price == ''){
            Swal.fire({ //sweet alert
                position: 'center',
                icon: 'error',
                title: 'Mohon input data product terlebih dahulu',
                showConfirmButton: false,
                timer: 2000
            })
            $("#pd_qty").val('');
        } else {
            $("#pd_total_price").val(price * qty);
            var totalrupiah = document.getElementById('pd_total_price');
            totalrupiah.value = formatRupiah($("#pd_total_price").val(), 'Rp. ');
        }
    })

	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
 
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

    jQuery('#pd_qty').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

</script>