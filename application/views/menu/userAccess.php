<style>
.selected{
    color: red;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-6">
            <div class="container">
                <form>
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="roleid" name="roleid" placeholder="Role Id" Disabled>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="rolename" name="rolename" placeholder="Role Name" Disabled>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myRoleModal">Select Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-6">
            <div class="container">
                <form>
                    <div class="form-row align-items-center">

                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="menuid" name="menuid" placeholder="Menu Id" Disabled>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="menuname" name="menuname" placeholder="Menu Name" Disabled>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#myMenuModal">Select Menu</button>
                        </div>
                        <!-- <div class="col-auto">
                            <button type="button" id="addtolist" class="btn btn-primary mb-2">Add To List</button>
                        </div> -->
                    </div>

                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="table-responsive " id="show" style="padding-top:50px">
                <div class="text-right mb-2"> 
                    <button type="button" id="addtolist" class="btn btn-primary">Add To List</button>
                    <button id="button" name="singlebutton" class="btn btn-danger">X</button> 
                </div>
                <table id="gridaccess" class="table table-striped table-bordered " style="width:100%; ">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Role Id</th>
                            <th scope="col">Role Name</th>
                            <th scope="col">Menu Id</th>
                            <th scope="col">Menu Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-auto">
            <button type="button" id="insert" class="btn btn-primary mb-2">Insert Data</button>
        </div>
    </div>
</div>

<!--Menu Modal-->
<div class="modal fade" id="myMenuModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table id="tblGrid" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Menu Id</th>
                            <th scope="col">Menu Name</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Ordering</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($menu as $n => $m) : ?>
                            <tr>
                                <td><?= $m['menu_id'] ?></td>
                                <td><?= $m['menu_nm'] ?></td>
                                <td><?= $m['icon'] ?></td>
                                <td><?= $m['ordering'] ?></td>
                                <td>
                                    <a href="#" class="badge badge-success selectmenu" id="<?= $m['menu_id'] ?>">Select</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Role Modal-->
<div class="modal fade" id="myRoleModal">
    <div class="modal-dialog" style="width: 150%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table id="tblGridd" class="table table-striped table-bordered" style="width:100%">
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

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        const t = $('#gridaccess').DataTable();
        let counter = 1;

        // const table = $('#tblGrid').DataTable({
        //     select: true,
        //     scrollY: 300,
        //     scrollX: true
        // });
        // const tabel = document.querySelector('#tblGrid_filter .form-control');
        // tabel.style.display = "grid";

        // const tbl = $('#tblGridd').DataTable({
        //     select: true,
        //     scrollY: 100,
        //     scrollX: true
        // });
        // const tt = document.querySelector('#tblGridd_filter .form-control');
        // tt.style.display = "grid";
    //-------------------------------------------------------------------START FUNTION-----------------------------------------------------------------//
        $('.selectmenu').on('click', function(e){
            $.ajax({
                url: "<?= base_url('useraccess/getmenubyid') ?>",
                method: "POST",
                data: {
                    id: e.target.id
                },
                success: function(result) {
                    const data = JSON.parse(result)
                    $("#menuid").val(data.menu_id);
                    $("#menuname").val(data.menu_nm);
                    $('#myMenuModal').modal('hide');
                }
            });
        });

        $('.selectrole').on('click', function(e){
            $.ajax({
                url: "<?= base_url('useraccess/getrolebyid') ?>",
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


        //add list
        $('#addtolist').on('click', function(e) {
            //get value textbox
            const menuid = $('#menuid').val();
            const menuname = $('#menuname').val();
            const roleid = $('#roleid').val();
            const rolename = $('#rolename').val();

            if (menuid == "" || menuname == "" || roleid == "" || rolename == "") {
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Menu Or Role Is Still Empty',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {  
                //cek dulu
                var validasi = 'false'; //false
                let data = t.rows().data().toArray()
                for(let r = 0; r<data.length; r++){
                    for(let c = 0; c<data[r].length; c++){
                        if(data[r][1] == $('#roleid').val() && data[r][3] == $('#menuid').val()){
                            validasi = 'true'; //true
                        }
                    }
                }  
                //jika sudah ada di list hapus             
                if(validasi == 'true'){
                    Swal.fire({ //sweet alert
                        position: 'center',
                        icon: 'error',
                        title: 'Already In The List',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else{
                    //jika belum ada cek apakah dia sudah punya data yang sama di database
                    $.ajax({
                    url: "<?= base_url('useraccess/accessvalidasibyid') ?>",
                    method: "POST",
                    data: {
                        role_id: roleid,
                        menu_id: menuid
                    },
                    success: function(result) {
                        const resp = eval('(' + result + ')');
                        //jika success masukan ke list
                        if (resp.success) {
                            Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: resp.success,
                            showConfirmButton: false,
                            timer: 1000
                            })
                            t.row.add([
                                counter,
                                roleid,
                                rolename,
                                menuid,
                                menuname,
                            ]).draw(false);
                            counter++;
                            $('#menuid').val('');
                            $('#menuname').val('');
                            $('#roleid').val('');
                            $('#rolename').val('');
                            //jika gagal hapus 
                        } else if (resp.error) {
                                Swal.fire({ //sweet alert
                                    position: 'center',
                                    icon: 'error',
                                    title: resp.error,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            }
                        }
                    });
                }
            }
        });

        //start delete row
        $('#gridaccess tbody').on('click','tr',function (e) {
            if ($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
                t.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#button').click( function () {
            t.row('.selected').remove().draw(false);
        });
        //end delete row

        //insert data;
        $('#insert').on('click', function() {
            $.ajax({
                url: "<?= base_url('useraccess/insertaccess') ?>",
                method: "POST",
                data: {
                    access: t.rows().data().toArray(), // array 2 dimensi
                },
                success: function(result) {
                    const resp = eval('(' + result + ')');
                    if (resp.success) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'success',
                            title: resp.success,
                            showConfirmButton: false,
                            timer: 1000
                        })
                    t.rows().remove().draw();
                    } else if (resp.error) {
                        Swal.fire({ //sweet alert
                            position: 'center',
                            icon: 'error',
                            title: resp.error,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            });
        });
    //-------------------------------------------------------------------END FUNTION-----------------------------------------------------------------//
    });

    
    
   
    
</script>