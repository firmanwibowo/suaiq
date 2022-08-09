<!-- Begin Page Content -->
<div class="container-fluid">
    <form action="" id="formsave">
        <div class="card" style="width:60%;  margin: 0 auto; float: none;  margin-bottom: 10px;">
            <!-- <div class="card"> -->
                <div class="card-body">
                    <div class="form-row" >
                        <div class='col-md-5 mt-2'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Select Start Date"  id="startdate" name="startdate" aria-label="Select Start Date" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                
                            </div>
                            <div class="pesanstartdate" style="margin-top: -20px;"></div>
                        </div>
                        <div class='col-md-5 mt-2'>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Select End Date"  id="enddate" name="enddate" aria-label="Select End Date" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" ><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="pesanenddate" style="margin-top: -20px;"></div>
                        </div>
                        <div class='col-md-2 mt-2'>
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
        },
        messages: {
            startdate: {
                required: "Please select start date"
            },
            enddate: {
                required: "Please select end date"
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
            $.ajax({
                url: "<?= base_url('AllWorker/SearchOrder') ?>",
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
    });
    //END SEARCH

</script>


