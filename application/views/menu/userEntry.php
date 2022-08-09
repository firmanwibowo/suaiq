<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#saveModal">Add New User</a>
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
                <h5 class="modal-title" id="saveModal">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formsave" name="formsave">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" name="imgupload" id="imgupload">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-4">
                                <input type="text" class="form-control" id="roleid"  onkeypress="return isSelect(event)" name="roleid" placeholder="Role Id">
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="rolename" onkeypress="return isSelect(event)" name="rolename" placeholder="Role Name" >
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="saveselect" data-toggle="modal" data-target="#myRoleModal" style="margin-left: -4px;">SelectRole</button>
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
                    <button type="button" class="btn btn-secondary" id="saveclose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Role Modal-->
<div class="modal fade" id="myRoleModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table id="tblGrid" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width:95px">Role_Id</th>
                            <th scope="col" style="width:137px">Role_Name</th>
                            <th scope="col" style="width:87px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($role as $n => $m) : ?>
                            <tr>
                                <td><?= $m['role_id'] ?></td>
                                <td><?= $m['role_nm'] ?></td>
                                <td>
                                    <a href="#" class="badge badge-success selectrole" id="<?= $m['role_id'] ?>">Select</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal EDIT -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formedit" name="">
                <div class="modal-body">
                    <div class="container">
                        <input type="text" class="form-control" id="edituserid" name="edituserid" placeholder="id" hidden>
                        <div class="form-group">
                            <input type="text" class="form-control" id="editusername" name="editusername" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="editemail" name="editemail" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="editcustom-file">
                                <input type="file" name="editimgupload" id="editimgupload">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="editpassword" name="editpassword" placeholder="Password">
                        </div>
                        <div class="form-row align-items-center mb-3">
                            <div class="col-4">
                                <input type="text" class="form-control" id="editoleid"  onkeypress="return isSelect(event)" name="editroleid" placeholder="Role Id">
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" id="editrolename" onkeypress="return isSelect(event)" name="editrolename" placeholder="Role Name" >
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="editselect" data-toggle="modal" data-target="#myeditRoleModal" style="margin-left: -4px;">SelectRole</button>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editactive" name="editstatus" value="1">
                            <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editnotactive" name="editstatus" value="0">
                            <label class="form-check-label" for="inlineRadio2">Not Active</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="Submit" id="edit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" id="saveclose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Role Modal-->
<div class="modal fade" id="myeditRoleModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content"  style="background-color:#efefef">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table id="tblGrid" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width:95px">Role_Id</th>
                            <th scope="col" style="width:137px">Role_Name</th>
                            <th scope="col" style="width:87px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($role as $n => $m) : ?>
                            <tr>
                                <td><?= $m['role_id'] ?></td>
                                <td><?= $m['role_nm'] ?></td>
                                <td>
                                    <a href="#" class="badge badge-success editselectrole" id="<?= $m['role_id'] ?>">Select</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" language="javascript">

    $(document).ready(function() {
        showAllCategory(); 
    });

    function showAllCategory() {
        $.ajax({
            url: "userentry/view",
            method: "POST",
            success: function(response) {
                $('#show').html(response);
                $("#firsttblGrid").DataTable({
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
            }
        });
    }

    $('.selectrole').on('click', function(e){
        $.ajax({
            url: "<?= base_url('userentry/getrolebyid') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#roleid").val(data.role_id);
                $("#rolename").val(data.role_nm);
                $('#myRoleModal').modal('hide');
            }
        });
    });

    $('.editselectrole').on('click', function(e){
        $.ajax({
            url: "<?= base_url('userentry/getrolebyid') ?>",
            method: "POST",
            data: {
                id: e.target.id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#editroleid").val(data.role_id);
                $("#editrolename").val(data.role_nm);
                $('#myeditRoleModal').modal('hide');
            }
        });
    });

    //START INSERT
    $('#formsave').validate({ // initialize the plugin
        rules: {
            username: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            imgupload: {
                required: true,
            },
            password: {
                required: true
            },
            roleid: {
                required: true
            },
            rolename: {
                required: true
            },
            status: {
                required: true
            },
        },
        messages: {
            username: {
                required: "Please enter user name",
            },
            email: {
                required: "Please enter email",
                email: "Email invalid"
            },
            imgupload: {
                required: "",
            },
            password: {
                required: "Please input password"
            },
            roleid: {
                required: "Please enter role",
            },
            rolename: {
                required: "Please enter role",
            },
            status: {
                required: "Please select status",
            },
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents('.container'));
            } else { // This is the default behavior 
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                url: "<?= base_url('userentry/insert') ?>",
                type: "POST",
                data: formData,
                success: function (respon) {
                    $('#saveModal').modal('hide');
                    var respon = JSON.parse(respon);
                    if(respon.success){ //success true
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: respon.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        showAllCategory(); 
                    }else{ //success false
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: respon.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
    //END INSERT
    
    function isSelect(evt) {
        return false;
    }

 //UNTUK MENGINPUT NILAI DIDALAM TEXT MODAL EDIT
    $("body").on("click", ".editBtn", function(e) {
        const image = document.querySelector('.editcustom-file');
        $( "img" ).remove( ".img" );

        e.preventDefault();
        edit_id = $(this).attr('id');
        $.ajax({
            url: "<?= base_url('userentry/getbyid') ?>",
            method: "POST",
            data: {
                id: edit_id
            },
            success: function(result) {
                const data = JSON.parse(result)

                $("#edituserid").val(data.user_id);
                $("#editusername").val(data.user_nm);
                $("#editemail").val(data.email);
                $( '<img class="img" src="./uploads/users/'+data.image+'" width="50" height="50"></img>').insertAfter( ".editcustom-file" );
                $("#editpassword").val(data.password);
                $("#editoleid").val(data.role_id);
                $("#editrolename").val(data.role_nm);


                if (data.is_active == 1)
                    $("#editactive").prop("checked", true);
                else
                    $("#editnotactive").prop("checked", true);
                // const form = document.querySelector('#formedit');
                // form.setAttribute('name', data.user_id);
            }
        });
    });

    //START EDIT
    $('#formedit').validate({ // initialize the plugin
        rules: {
            editusername: {
                required: true,
            },
            editemail: {
                required: true,
                email: true
            },
            // editimgupload: {
            //     required: true,
            // },
            editpassword: {
                required: true
            },
            editroleid: {
                required: true
            },
            editrolename: {
                required: true
            },
            editstatus: {
                required: true
            },
        },
        messages: {
            editusername: {
                required: "Please enter user name",
            },
            editemail: {
                required: "Please enter email",
                email: "Email invalid"
            },
            // imgupload: {
            //     required: "",
            // },
            editpassword: {
                required: "Please input password"
            },
            editroleid: {
                required: "Please enter role",
            },
            editrolename: {
                required: "Please enter role",
            },
            editstatus: {
                required: "Please select status",
            },
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents('.container'));
            } else { // This is the default behavior 
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            //console.log(form);
            var formData = new FormData(form);
            //var id = form.name;
            $.ajax({
                url: "<?= base_url('userentry/edit') ?>",
                type: "POST",
                data: formData,
                success: function (respon) {
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
                        showAllCategory(); 
                    }else{ //success false
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: respon.msg,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                cache: false,
                contentType: false,
                processData: false
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
                    url: "<?= base_url('userentry/delete') ?>",
                    method: "POST",
                    data: {
                        id: $(this).attr('id'),
                    },
                    success: function(result) {
                        var respon = JSON.parse(result);
                        if (respon.success) {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'success',
                                title: respon.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            showAllCategory();
                        } else {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: respon.msg,
                                showConfirmButton: false,
                                timer: 2000
                            })
                            showAllCategory();
                        }
                    }
                });
            }
        });
    });
    //END DELETE
</script>