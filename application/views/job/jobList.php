<style>
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: grid;
    width: auto;
}

</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-12">
            <div class="table-responsive" id="joblistshow">
                <!--USING INNER HTML-->
            </div>
        </div>
    </div>
</div>

<!--Role Modal-->
<div class="modal fade"  id="myJobModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="jobshow">
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">EDIT STATUS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formedit" name="">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-5">
                            <input type="text" class="form-control" id="edit_od_no" name="edit_od_no" readonly placeholder="Order No">
                        </div>
                        <div class="form-group col-2">
                            <input type="text" class="form-control" id="edit_pd_code" name="edit_pd_code" readonly placeholder="Product Code">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" class="form-control" id="edit_pd_nm" name="edit_pd_nm"  readonly placeholder="Product Name">
                        </div>
                        <div class="form-group col-2">
                            <input type="text" class="form-control" id="edit_qty" name="edit_qty"  readonly placeholder="Product QTY">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" class="form-control" id="edit_sts_code" name="edit_sts_code"  readonly placeholder="Status Code">
                        </div>
                        <div class="form-group col-3">
                            <input type="text" class="form-control" id="edit_sts_nm" name="edit_sts_nm"  readonly placeholder="Status Name">
                        </div>
                        <div class="form-group col-1">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myStatusModal">Select</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="editjobliststatus" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" id="editclose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Role Modal-->
<div class="modal fade"  id="myStatusModal">
    <div class="modal-dialog modal-lg">
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
    $(document).ready(function() {
        showAllJobList();
        showAllStatus();
    });
 
    function showAllJobList() {
        $.ajax({
            url: "JobList/view",
            method: "POST",
            success: function(response) {
                $('#joblistshow').html(response);
                $("#joblist").DataTable({
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

    function showAllStatus(){
        $.ajax({
            url: "JobList/status",
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

    $("body").on('click', '.editBtn', function(e){
        $.ajax({
            url: "<?= base_url('JobList/getOrderByOdNoPdCode') ?>",
            method: "POST",
            data: {
                od_no: e.target.id,
                pd_code: e.target.attributes.name.value,
            },
            success: function(result) {

                const data = JSON.parse(result);
                $("#edit_od_no").val(data.od_no);
                $("#edit_pd_code").val(data.pd_code);
                $("#edit_pd_nm").val(data.pd_nm);
                $("#edit_qty").val(data.qty);
                $("#edit_sts_code").val(data.sts_code);
                $("#edit_sts_nm").val(data.sts_nm);
            }
        });
    });

    $("body").on('click', '.selectstatus', function(e){
        $.ajax({
            url: "<?= base_url('JobChecking/getstatusbycode') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result);
                $("#edit_sts_code").val(data.sts_code);
                $("#edit_sts_nm").val(data.sts_nm);
                $('#myStatusModal').modal('hide');
            }
        });
    });

    $('#editjobliststatus').on('click',function (params) {
        $.ajax({
            url: "<?= base_url('JobList/updatejobliststatus') ?>",
            method: "POST",
            data: $("#formedit").serialize(),
            success: function(respon) {
                $('#editModal').modal('hide');
                var respon = JSON.parse(respon);
                if(respon.success){ //success true
                    Swal.fire({ //sweet alert
                        position: 'center',
                        icon: 'success',
                        title: respon.msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    showAllJobList();
                    showAllStatus(); 
                }else{ //success false
                    Swal.fire({ //sweet alert
                        position: 'center',
                        icon: 'error',
                        title: respon.msg,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    showAllJobList();
                    showAllStatus(); 
                }   
            }
        }); 
    });



</script>