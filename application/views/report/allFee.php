<!-- Begin Page Content -->
<div class="container-fluid">
    <form action="" id="formsave">
        <div class="card" style="width:60%;  margin: 0 auto; float: none;  margin-bottom: 10px;">
            <!-- <div class="card"> -->
                <div class="card-body">
                    <div class="form-row" >
                        <div class='col-md-6 mt-2'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Select Start Date"  id="startdate" name="startdate" aria-label="Select Start Date" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                
                            </div>
                            <div class="pesanstartdate" style="margin-top: -20px;"></div>
                        </div>
                        <div class='col-md-6 mt-2'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Select End Date"  id="enddate" name="enddate" aria-label="Select End Date" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="pesanenddate" style="margin-top: -20px;"></div>
                        </div><br>
                        <div class='col-md-5 mt-3'>
                            <select class="form-control" name="combouser"  id="combouser">
                                <option value = "" hidden>Select User</option>
                                <option value="admin">Admin</option>
                                <option value="developer">Developer</option>
                                <option value="worker">Worker</option>
                            </select>
                        </div>
                        <div class='col-md-5 mt-3'>
                            <select class="form-control" name="comboworker" id="comboworker">
        
                            </select>
                        </div>
                        <div class='col-md-2 mt-3'>
                            <button type="Submit" id="insert" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </form>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-12" id="ordershow">
           
            </div>
        </div>
    </div>

</div>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        datecustome();
    });

    $('#combouser').change(function() {
        var user = $("#combouser option:selected").val();
        if(user == 'worker'){
            $.ajax({
                url: "<?= base_url('AllFee/getDataUser') ?>",
                type: "POST",
                cache: false, 
                success: function(response) {
                    $("#comboworker").html(response);
                }
            });
        } else {
            $("#comboworker").text('');
            $("#comboworker").val('');
        }
    }); 

    // $('body').on('search.dt', function() {
    //     var value = $('.dataTables_filter input').val();
    //     var table = document.getElementById('orders');
    //     console.log(table.rows.length)
    //     if(table.rows.length == 0){
    //         $("#grn_ttl_fee").val(0)
    //     } else if(table.rows.length == 2){ 
    //         let total = 0;
    //         for (var r = 0, n = table.rows.length; r < n; r++) {
    //             total += parseInt(table.rows[r].cells[9].innerHTML.replace(/[^,\d]/g, ''))
    //         }
    //         var feetotal = $("#grn_ttl_fee").val(total)
    //         var totalrupiah = document.getElementById('grn_ttl_fee');
    //         totalrupiah.value = formatRupiah($("#grn_ttl_fee").val(), 'Rp. ');  
    //     } else if(table.rows.length > 2){
    //         let total = 0;
    //         for (var r = 0, n = table.rows.length; r < n; r++) {
    //             total += parseInt(table.rows[r].cells[9].innerHTML.replace(/[^,\d]/g, ''))
    //         }
    //         var feetotal = $("#grn_ttl_fee").val(total)
    //         var totalrupiah = document.getElementById('grn_ttl_fee');
    //         totalrupiah.value = formatRupiah($("#grn_ttl_fee").val(), 'Rp. ');  
    //     }
    // }); 

    function datecustome(){
        var start_date=$('input[name="startdate"]'); //our date input has the name "date"
        var end_date = $('input[name="enddate"]');
        start_date.datepicker({
            format: 'mm/dd/yyyy',
            // minDate: ,
            maxDate: -1,
            todayHighlight: true,
            autoclose: true,
        })
        end_date.datepicker({
            format: 'mm/dd/yyyy',
            minDate: 0,
            todayHighlight: true,
            autoclose: true,
        })
    }

     //START SEARCH
    $('#formsave').validate({ // initialize the plugin
        rules: {
            startdate: {
                required: true
            },
            enddate: {
                required: true
            },
            combouser: {
                required: true
            },
        },
        messages: {
            startdate: {
                required: "Please select start date"
            },
            enddate: {
                required: "Please select end date"
            },
            combouser: {
                required: "Please select user"
            },
        },
        errorPlacement: function(error, element) {
            if (element.is("#startdate")) {
                error.appendTo('.pesanstartdate');
            } else if (element.is("#enddate")) { // This is the default behavior 
                error.appendTo('.pesanenddate');
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function() {
            var user = $("#combouser").val();
            var worker = $("#comboworker").val();
            $('#saveModal').modal('hide');
            if(user == 'worker' && worker == '') {
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Please Select Worker',
                    showConfirmButton: false,
                    timer: 2000
                }) 
            } else {
                $.ajax({
                    url: "<?= base_url('AllFee/SearchFee') ?>",
                    method: "POST",
                    data: $("#formsave").serialize(),
                    success: function(response) {
                        $('#ordershow').html(response);
                        $("#orders").DataTable({
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
        }
    });
    //END SEARCH

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

</script>


