<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <div class="table-responsive" id="show">
                <!--USING INNER HTML-->
            </div>
        </div>
    </div>
</div>


<!-- Modal EDIT -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">EDIT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formedit" name="">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="od_no" name="od_no" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="status" name="status" readonly>
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-9">
                                <input type="text" class="form-control" id="worker_code" name="worker_code" readonly>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="userselect" data-toggle="modal" data-target="#myWorkerModal" style="margin-left: -4px;">Select</button>
                            </div>
                        </div>
                        <div class="form-group">
                                <input type="text" class="form-control" id="worker_code_2"  name="worker_code_2" readonly hidden>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="worker_name" name="worker_name" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="product_code" name="product_code" readonly hidden>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="product_name" name="product_name" readonly>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="Submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" id="editclose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Role Modal-->
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


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        showAllOrder();
        showAllWorker();
    });

    function showAllOrder() {
        $.ajax({
            url: "ChangeWorker/view",
            method: "POST",
            success: function(response) {
                $('#show').html(response);
                $("#order").DataTable({
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
            url: "ChangeWorker/worker",
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


    //UNTUK MENGINPUT NILAI DIDALAM TEXT MODAL EDIT
    $("body").on("click", ".editBtn", function(e) {
        e.preventDefault();
        od_no = $(this).attr('id');
        pd_code = $(this).attr('name');
        $.ajax({
            url: "<?= base_url('ChangeWorker/getbyid') ?>",
            method: "POST",
            data: {
                od_no: od_no,
                pd_code: pd_code
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#od_no").val(data.od_no);
                $("#status").val(data.sts_nm);
                $("#worker_code").val(data.wr_code);
                $("#worker_code_2").val(data.wr_code);
                $("#worker_name").val(data.wr_nm);
                $("#product_code").val(data.pd_code);
                $("#product_name").val(data.pd_nm);
                const form = document.querySelector('#formedit');
                form.setAttribute('name', data.cs_code);
            }
        });
    });

    $("body").on('click', '.selectworker', function(e){
        $.ajax({
            url: "<?= base_url('ChangeWorker/getWorkerById') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#worker_code").val(data.wr_code);
                $("#worker_name").val(data.wr_nm);
                $('#myWorkerModal').modal('hide');
            }
        });
    });

    //START EDIT
    $('#formedit').validate({ // initialize the plugin
        rules: {
            reason: {
                required: true,
                maxlength: 200
            },
        },
        messages: {
            reason: {
                required: "Please enter reason",
                maxlength: "200 letters maximum"
            },
        },
        submitHandler: function(e) {
            $('#editModal').modal('hide');
            $.ajax({
                url: "<?= base_url('ChangeWorker/edit') ?>",
                method: "POST",
                data: $("#formedit").serialize(),
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
                        showAllOrder();
                    } else {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllOrder();
                    }
                }
            });
        }
    });
    //END EDIT

</script>