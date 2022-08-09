<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#saveModal">Add New Menu</a>
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
                <h5 class="modal-title" id="saveModal">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="formsave">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Input Menu">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Input Icon">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="order" name="order" placeholder="Order">
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
                        <!-- <div class="form-group">
                            <input type="text" class="form-control" id="editmenu" name="editmenu" placeholder="Input Menu" hide>
                        </div> -->
                        <div class="form-group">
                            <input type="text" class="form-control" id="editmenu" name="editmenu" placeholder="Input Menu">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="editicon" name="editicon" placeholder="Input Icon">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="editorder" name="editorder" placeholder="Input Order">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editactive" name="status" value="1">
                            <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="editnotactive" name="status" value="0">
                            <label class="form-check-label" for="inlineRadio2">Not Active</label>
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
        showAllCategory();
    });

    function showAllCategory() {
        $.ajax({
            url: "menu/view",
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

    //DOM MENGHILANGKAN ELEMENT DAN MENGEDIT ATTRIBUT PADA MODAL EDIT
    $('#editclose').on('click', function() {
        //SELECT VALIDASI
        const editmenu = document.querySelector('#editmenu');
        const editicon = document.querySelector('#editicon');
        const editorder = document.querySelector('#editorder');
        const editmenuerror = document.querySelector('#editmenu-error');
        const editiconerror = document.querySelector('#editicon-error');
        const editordererror = document.querySelector('#editorder-error');

        //EXECUTION
        editmenu.setAttribute("class", "form-control");
        editicon.setAttribute("class", "form-control");
        editorder.setAttribute("class", "form-control");
        editmenuerror.remove();
        editiconerror.remove();
        editordererror.remove();
    });

    //DOM MENGHILANGKAN ELEMENT DAN MENGEDIT ATTRIBUT PADA MODAL SAVE
    $('#saveclose').on('click', function() {
        //SELECT VALIDASI
        const menu = document.querySelector('#menu');
        const icon = document.querySelector('#icon');
        const order = document.querySelector('#order');
        const menuerror = document.querySelector('#menu-error');
        const iconerror = document.querySelector('#icon-error');
        const ordererror = document.querySelector('#order-error');
        const statuserror = document.querySelector('#status-error');

        //EXECUTION
        menu.setAttribute("class", "form-control");
        icon.setAttribute("class", "form-control");
        order.setAttribute("class", "form-control");
        menuerror.remove();
        iconerror.remove();
        ordererror.remove();
        statuserror.remove();
    });

    //START INSERT
    $('#formsave').validate({ // initialize the plugin
        rules: {
            menu: {
                required: true,
                maxlength: 100
            },
            icon: {
                required: true,
                maxlength: 100
            },
            order: {
                required: true,
                maxlength: 1,
                digits: true
            },
            status: {
                required: true
            },
        },
        messages: {
            menu: {
                required: "Please enter menu",
                maxlength: "100 letters maximum"
            },
            icon: {
                required: "Please enter icon",
                maxlength: "100 letters maximum"
            },
            order: {
                required: "Please enter ordering",
                maxlength: "Please enter no more than 1 characters.",
                digits: "Only number"
            },
            status: {
                required: "Please select status"
            }
        },
        errorPlacement: function(error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents('.container'));
            } else { // This is the default behavior 
                error.insertAfter(element);
            }
        },
        submitHandler: function() {
            $('#saveModal').modal('hide');
            $.ajax({
                url: "<?= base_url('menu/insert') ?>",
                method: "POST",
                data: $("#formsave").serialize(),
                success: function(result) {
                    var resp = eval('(' + result + ')');
                    if (resp.success) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: resp.success,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        showAllCategory();
                        // $('#example').DataTable().ajax.reload();
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: resp.error,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllCategory();
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
            url: "<?= base_url('menu/getbyid') ?>",
            method: "POST",
            data: {
                id: edit_id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#editmenu").val(data.menu_nm);
                $("#editicon").val(data.icon);
                $("#editorder").val(data.ordering);
                if (data.is_active == 1)
                    $("#editactive").prop("checked", true);
                else
                    $("#editnotactive").prop("checked", true);
                const form = document.querySelector('#formedit');
                form.setAttribute('name', data.menu_id);
            }
        });
    });

    //START EDIT
    $('#formedit').validate({ // initialize the plugin
        rules: {
            editmenu: {
                required: true,
                maxlength: 100
            },
            editicon: {
                required: true,
                maxlength: 100
            },
            editorder: {
                required: true,
                maxlength: 1,
                digits: true
            },
        },
        messages: {
            editmenu: {
                required: "Please enter menu",
                maxlength: "100 letters maximum"
            },
            editicon: {
                required: "Please enter icon",
                maxlength: "100 letters maximum"
            },
            editorder: {
                required: "Please enter ordering",
                maxlength: "Please enter no more than 1 characters.",
                digits: "Only number"
            },
        },

        submitHandler: function(e) {
            $('#editModal').modal('hide');
            $.ajax({
                url: "<?= base_url('menu/edit') ?>",
                method: "POST",
                data: $("#formedit").serialize() + '&id=' + e.name,
                success: function(result) {
                    var resp = eval('(' + result + ')');
                    if (resp.success) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: resp.success,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        showAllCategory();
                        // $('#example').DataTable().ajax.reload();
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: resp.error,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        showAllCategory();
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
                    url: "<?= base_url('menu/delete') ?>",
                    method: "POST",
                    data: {
                        id: $(this).attr('id'),
                    },
                    success: function(result) {
                        var resp = eval('(' + result + ')');
                        if (resp.success) {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'success',
                                title: resp.success,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            showAllCategory();
                        } else if (resp.error) {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: resp.error,
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