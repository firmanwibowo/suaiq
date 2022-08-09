<style>
.selected{
    color: red;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Page Heading -->
    <h1 class="h3 ml-4 text-gray-800">Pilih Menu</h1>
    <div class="row justify-content-md-center">
        <div class="col-12">
            <div class="container">
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
            </div>
        </div>
    </div>
         
    <h1 class="h3 mt-4 ml-4 text-gray-800">Input Sub Menu</h1>
     <!-- <form action="" id="formsave"> -->
        <div class="row mb-4 justify-content-md-center">
            <div class="col-12">
                <div class="container">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="nmsub" maxlength="100" name="nmsub" placeholder="Nama Sub Menu">
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="url" maxlength="100" name="url" placeholder="Controller">
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" id="icon" maxlength="100" name="icon" placeholder="Fontawesome Icon">
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control mb-2" onkeypress="return isNumber(event)" id="order" name="order" min="0" max="10" placeholder="Order">
                        </div>
                        <div class="test">
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="radio" id="editactive" name="status" value="1">
                                <label class="form-check-label" for="inlineRadio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="editnotactive" name="status" value="0">
                                <label class="form-check-label" for="inlineRadio2">Not Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-center">
            
        </div> -->
    <!-- </form> -->

    <div class="col-12">
        <div class="table-responsive " id="show" style="padding-top:50px">
        <div class="text-right mb-2"> 
            <button type="Submit" id="addtolist" class="btn btn-primary">Add To List</button>
            <button id="button" name="singlebutton" class="btn btn-danger">X</button> 
         </div>
            <table id="gridaccess" class="table table-striped table-bordered " style="width:100%; ">
                <thead>
                    <tr>
                        <th scope="col">Nomor</th>
                        <th scope="col">Menu Id</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Sub Menu</th>
                        <th scope="col">Controller</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Order</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <th>test</th>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center mb-4">
        <button type="button" id="insert" class="btn btn-primary mb-2">Insert Data</button>
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
                            <!-- <th scope="col">Icon</th>
                            <th scope="col">Ordering</th> -->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($menu as $n => $m) : ?>
                            <tr>
                                <td><?= $m['menu_id'] ?></td>
                                <td><?= $m['menu_nm'] ?></td>
                                <!-- <td><?= $m['icon'] ?></td>
                                <td><?= $m['ordering'] ?></td> -->
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


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        const t = $('#gridaccess').DataTable();
        let counter = 1;

        // const table = $('#tblGrid').DataTable({
        //     select: true,
        //     scrollY: true,
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

        $('.selectmenu').on('click', function(e){
            $.ajax({
                url: "<?= base_url('submenu/getMenuById') ?>",
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
        
        
        $('#addtolist').on('click',function(e){
            const menuid = $('#menuid').val();
            const menuname = $('#menuname').val();
            const nmsub = $('#nmsub').val();
            const url = $('#url').val();
            const icon = $('#icon').val();
            const order = $('#order').val();
            const getstatus = $('input[name="status"]:checked').val();
            // var checkstatus = '';
            // if (getstatus == 1) {
            //     checkstatus = 'Active';
            // } else {
            //     checkstatus = 'Not Active';
            // }
            if (menuid == "" || menuname == "" || nmsub == '' || url == '' || icon == '' || order == '' || getstatus == undefined ) {
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Menu Or Sub Menu Is Empty',
                    showConfirmButton: false,
                    timer: 2000
                    });
            } else {
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'success',
                    title: 'Add Data To List Successfully',
                    showConfirmButton: false,
                    timer: 1000
                })
                $('#menuid').val('');
                $('#menuname').val('');
                $('#nmsub').val('');
                $('#url').val('');
                $('#icon').val('');
                $('#order').val('');
                $('input[name="status"]').prop('checked', false);;
                t.row.add([
                    counter,
                    menuid,
                    menuname,
                    nmsub,
                    url,
                    icon,
                    order,
                    getstatus,
                ]).draw(false);
                counter++;
            }
        })

         //insert data;
        $('#insert').on('click', function(e) {
            ///console.log(t.rows().data().toArray());
            $.ajax({
                url: "<?= base_url('submenu/insertsubmenu') ?>",
                method: "POST",
                data: {
                    submenu: t.rows().data().toArray(), // array 2 dimensi
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

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ( (charCode > 31 && charCode < 48) || charCode > 57) {
                return false;
            }
            return true;
        }



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
    });
   

</script>