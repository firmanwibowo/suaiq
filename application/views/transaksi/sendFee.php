<!-- Begin Page Content -->
<div class="container-fluid">

    <form action="" id="formsearch">

        <div class="card mb-1" style="max-width: 550px; margin: 0 auto; float: none;">
            <div class="row no-gutters">
                <div class="card-body  mt-2">
                    
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <select class="form-control" name="combouser" id="combouser">
                                <option value='' hidden>Select User</option>
                                <option value='develop'>Develop</option>
                                <option value='admin'>Admin</option>
                                <option value='worker'>Worker</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <select class="form-control" name="comboworker" id="comboworker">
        
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="Submit" id="search" class="btn btn-primary">Search</button>
                        </div>
                    </div>
             
                </div>
            </div>
        </div>

    </form>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-12" id="workerfeedetail">
  
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" language="javascript">
	// $(document).ready(function(){
         
    // });

    $('#combouser').change(function() {
        var user = $("#combouser option:selected").val();
        if(user == 'worker'){
            $.ajax({
                url: "<?= base_url('SendFee/getDataUser') ?>",
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

    //START SEARCH
    $('#formsearch').validate({ // initialize the plugin
        rules: {
            combouser: {
                required: true
            },
        },
        messages: {
            combouser: {
                required: "Please select worker"
            },
        },
        submitHandler: function(e) {
            // e.preventDefault();
            var user = $("#combouser").val();
            var worker = $("#comboworker").val();
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
                    url: "<?= base_url('SendFee/SearchFee') ?>",
                    method: "POST",
                    data: $("#formsearch").serialize(),
                    success: function(response) {  
                        $('#workerfeedetail').html(response);
                        $("#allfee").DataTable({    
                            order: [0, 'asc'],
                            responsive: true,
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

    $("body").on("click", "#example-select-all", function(e) {
        //e.preventDefault();
        if($(this).prop("checked") == true){
            $("#example-select-all").attr("value", "1");
        }
        else if($(this).prop("checked") == false){
            $("#example-select-all").attr("value", "0");
        }
    });

    $("body").on('click', '#sendcommission', function(e){
        var table = document.getElementById('allfee');
        if (!table){
            Swal.fire({ //sweet alert
                position: 'center',
                icon: 'error',
                title: 'Data Is Not Found',
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            var odno = [{}];
            for (var r = 1, n = table.rows.length; r < n; r++) {
                odno.push(
                            {
                                'od_no':table.rows[r].cells[1].innerHTML,
                                'pd_code':table.rows[r].cells[3].innerHTML
                            } 
                        );
            }
            var approvefee = $("input[type='checkbox']").val();
            if(approvefee == 0){
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Please Checklist Approve Commission',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                $.ajax({
                    url: "<?= base_url('SendFee/updatedetilorder') ?>",
                    method: "POST",
                    data:  {
                            detilorder: odno,
                            user: $("#combouser").val()
                    }, // array 2 dimensi
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
                            reload();
                        } else {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: result.msg,
                                showConfirmButton: false,
                                timer: 2000
                            }) 
                            reload();
                        }
                    }
                });
            }   
        }                    
    });

    function reload(){
        $.ajax({
            url: "<?= base_url('SendFee/SearchFee') ?>",
            method: "POST",
            data: $("#formsearch").serialize(),
            success: function(response) {
                $('#workerfeedetail').html(response);
            }
        });
    }
</script>