<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#saveModal">Add New Status</a>
            <div class="table-responsive" id="show">
                <!--USING INNER HTML-->
            </div>
        </div>
    </div>
</div>

<!-- Modal SAVE -->
<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saveModal">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="formsave">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="sts_code" name="sts_code" readonly placeholder="Status Code">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="sts_nm" name="sts_nm" placeholder="Status Name">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="Submit" id="insert" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" id="saveclose" data-dismiss="modal">Close</button>
                </div>
            </form>
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
                            <input type="text" class="form-control" id="edit_sts_code" name="edit_sts_code" readonly placeholder="Status Code">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit_sts_nm" name="edit_sts_nm" placeholder="Status Name">
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

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        showAllStatus();
        autoNumber();
    });

    function showAllStatus() {
        $.ajax({
            url: "status/view",
            method: "POST",
            success: function(response) {
                $('#show').html(response);
                $("table").DataTable({
                    order: [0, 'asc'],
                    select: true,
                    scrollY: 150,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }

    function autoNumber(){
        $.ajax({
            url: "status/autonumber",
            method: "POST",
            success: function(response) {
                $("#sts_code").val(response);
            }
        });
    }

    //START INSERT
    $('#formsave').validate({ // initialize the plugin
        rules: {
            sts_nm: {
                required: true,
                maxlength: 20
            },
        },
        messages: {
            sts_nm: {
                required: "Please enter divisi name",
                maxlength: "20 letters maximum"
            },
        },
        submitHandler: function() {
            $('#saveModal').modal('hide');
            $.ajax({
                url: "<?= base_url('status/insert') ?>",
                method: "POST",
                data: $("#formsave").serialize(),
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
                        showAllCategory();
                        autoNumber()
                        $("#sts_nm").val('');
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllCategory();
                        autoNumber()
                    }
                }
            });
        }
    });
    //END INSERT


    //UNTUK MENGINPUT NILAI DIDALAM TEXT MODAL EDIT
    $("body").on("click", ".editBtn", function(e) {
        //$("#editmenu").val(e.target.name);
        e.preventDefault();
        edit_id = $(this).attr('id');
        $.ajax({
            url: "<?= base_url('status/getbyid') ?>",
            method: "POST",
            data: {
                id: edit_id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#edit_sts_code").val(data.sts_code);
                $("#edit_sts_nm").val(data.sts_nm);
                const form = document.querySelector('#formedit');
                form.setAttribute('name', data.sts_code);
            }
        });
    });

    //START EDIT
    $('#formedit').validate({ // initialize the plugin
        rules: {
            edit_div_nm: {
                required: true,
                maxlength: 20
            },
        },
        messages: {
            edit_div_nm: {
                required: "Please enter divisi name",
                maxlength: "20 letters maximum"
            },
        },
        submitHandler: function(e) {
            $('#editModal').modal('hide');
            $.ajax({
                url: "<?= base_url('status/edit') ?>",
                method: "POST",
                data: $("#formedit").serialize() + '&id=' + e.name,
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
                        showAllCategory();
                        autoNumber()
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllCategory();
                        autoNumber()
                    }
                }
            });
        }
    });
    //END EDIT

    //START DELETE
    $('body').on('click','.delbtn',function(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('status/delete') ?>",
                    method: "POST",
                    data: {
                        id: $(this).attr('id'),
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
                            showAllCategory();
                            autoNumber()
                        } else if (resp.error) {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: result.msg,
                                showConfirmButton: false,
                                timer: 2000
                            })
                            showAllCategory();
                            autoNumber()
                        }
                    }
                });
            }
        }); 
    });
    //END DELETE
</script>