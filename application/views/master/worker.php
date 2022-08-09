
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <a href="" class="btn btn-primary mb-3 btninsert" data-toggle="modal" data-target="#saveModal">Add New Worker</a>
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
                <h5 class="modal-title" id="saveModal">FORM WORKER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="form" id="form">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="wr_code" name="wr_code" readonly placeholder="Worker Code">
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-9">
                                <input type="text" class="form-control" id="user_id"  onkeypress="return isSelect(event)" name="user_id" placeholder="User Id">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="userselect" data-toggle="modal" data-target="#myUserModal" style="margin-left: -4px;">SelectUser</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="wr_name" onkeypress="return isSelect(event)" name="wr_name" placeholder="Worker Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" onkeypress="return isSelect(event)" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-4">
                                <input type="text" class="form-control" id="dv_code"  onkeypress="return isSelect(event)" name="dv_code" placeholder="Divisi Code">
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="dv_nm" onkeypress="return isSelect(event)" name="dv_nm" placeholder="Divisi Name" >
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="divisiselect" data-toggle="modal" data-target="#myDivisiModal" style="margin-left: -4px;">SelectDivisi</button>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="active" name="status" value="1">
                            <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="notactive" name="status" value="0">
                            <label class="form-check-label" for="inlineRadio2">Not Active</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="Submit" id="insert" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Role Modal-->
<div class="modal fade" id="myDivisiModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="divisishow">
  
            </div>
        </div><!-- /.modal-content-->
    </div><!--/.modal-dialog -->
</div><!-- /.modal -->

<!--Role Modal-->
<div class="modal fade"  id="myUserModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="usershow">
               
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!--.modal-->



<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        autoNumber();     
        showAllWorker();
        showAllDivisi();
        showAllUser();
    });
        
    function isSelect(evt) {
        return false;
    }

    function showAllWorker() {
        $.ajax({
            url: "worker/view",
            method: "POST",
            success: function(response) {
                $('#show').html(response);
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

    function showAllDivisi() {
        $.ajax({
            url: "worker/divisi",
            method: "POST",
            success: function(response) {
                $('#divisishow').html(response);
                $("#divisi").DataTable({
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

    function showAllUser() {
        $.ajax({
            url: "worker/user",
            method: "POST",
            success: function(response) {
                $('#usershow').html(response);
                $("#user").DataTable({
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

    function autoNumber(){
        $.ajax({
            url: "worker/autonumber",
            method: "POST",
            success: function(response) {
                $("#wr_code").val(response);
            }
        });
    }

    function textboxsearch(){
        const t = document.querySelector('#divisi_filter .form-control');
        t.style.display = "grid";
        const tt = document.querySelector('#user_filter .form-control');
        tt.style.display = "grid";
    }

    function clear(){
        $("#wr_code").val();
        $("#wr_name").val();
        $("#email").val();
        $("#phone").val();
        $("#dv_code").val();
        $("#dv_nm").val();// butuh inner join
        $("#user_id").val();
        $("#user_nm").val();
        $("#active").prop("checked", false);
        $("#notactive").prop("checked", false);
    }

    $("body").on('click', '.selectdivisi', function(e){
        $.ajax({
            url: "<?= base_url('worker/getDivisiById') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#dv_code").val(data.div_code);
                $("#dv_nm").val(data.div_nm);
                $('#myDivisiModal').modal('hide');
            }
        });
    });

    $("body").on('click','.selectuser', function(e){
        $.ajax({
            url: "<?= base_url('worker/getUserById') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#user_id").val(data.user_id);
                $("#wr_name").val(data.user_nm);
                $("#email").val(data.email);
                $('#myUserModal').modal('hide');
            }
        });
    });

    $('.btninsert').on('click',function(){
        var form = document.querySelector('.form');
        form.setAttribute("id", "formsave");
        autoNumber();
        clear();
    })
    
    $("body").on("click", ".editBtn", function(e){
        var form = document.querySelector('.form');
        form.setAttribute("id", "formedit");
        edit_id = $(this).attr('id');
        $.ajax({
            url: "<?= base_url('worker/getbyid') ?>",
            method: "POST",
            data: {
                id: edit_id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#wr_code").val(data.wr_code);
                $("#wr_name").val(data.wr_nm);
                $("#email").val(data.email);
                $("#phone").val(data.phone);
                $("#dv_code").val(data.div_code);
                $("#dv_nm").val(data.div_nm);// butuh inner join
                $("#user_id").val(data.user_id);
                $("#user_nm").val(data.user_nm);
                if (data.is_active == 1)
                    $("#active").prop("checked", true);
                else
                    $("#notactive").prop("checked", true);
                const form = document.querySelector('#formedit');
                form.setAttribute('name', data.wr_code);
            }
        });
    })

    
    //START INSERT
    $('#form').validate({ // initialize the plugin
        rules: {
            wr_name: {
                required: true,
                maxlength: 20
            },
            email: {
                required: true,
                email: true,
                maxlength: 30
            },
            phone: {
                required: true,
                digits: true,
                maxlength: 12
            },
            dv_code: {
                required: true
            },
            dv_nm: {
                required: true
            },
            user_id: {
                required: true,
                digits: true
            },
            user_nm: {
                required: true
            },
            status: {
                required: true
            },
        },
        messages: {
            wr_name: {
                required: "Please enter worker name",
                maxlength: "20 letters maximum"
            },
            email: {
                required: "Please enter email",
                email: "Please enter valid email",
                maxlength: "30 letters maximum"
            },
            phone: {
                required: "Please enter phone",
                digits: "Only Number",
                maxlength: "12 letters maximum"
            },
            dv_code: {
                required: "Please enter divisi"
            },
            dv_nm: {
                required: "Please enter divisi",
            },
            user_id: {
                required: "Please enter user",
                digits: "Only Number"
            },
            user_nm: {
                required: "Please enter user"
            },
            status: {
                required: "Please select status"
            },
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents('.container'));
            } else { // This is the default behavior 
                error.insertAfter(element);
            }
        },
        submitHandler: function(e) {
            var formtype = e.id;
            var url;
            var form;
            if(formtype == 'formsave'){
                var url = '<?= base_url('worker/insert') ?>';
                var form = $("#formsave").serialize();
            } else {
                var url =  '<?= base_url('worker/edit') ?>';
                var form = $("#formedit").serialize();
            }
            $('#saveModal').modal('hide');
            $.ajax({
                url: url,
                method: "POST",
                data: form,
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
                        showAllDivisi();
                        showAllUser();
                        autoNumber()
                        clear()
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: result.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllCategory();
                        showAllDivisi();
                        showAllUser();
                        autoNumber()
                        clear()
                    }
                }
            });
        }
    });
    //END INSERT


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
                    url: "<?= base_url('worker/delete') ?>",
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
                            showAllDivisi();
                            showAllUser();
                            autoNumber();
                        } else if (resp.error) {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: result.msg,
                                showConfirmButton: false,
                                timer: 2000
                            })
                            showAllCategory();
                            showAllDivisi();
                            showAllUser();
                            autoNumber();
                        }
                    }
                });
            }
        }); 
    });
    // //END DELETE
</script>