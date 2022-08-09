<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

    <div class="row justify-content-md-center">
        <div class="col-12">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#saveModal">Add New Products</a>
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
                            <input type="text" class="form-control" id="pd_code" name="pd_code" readonly placeholder="Products Code">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="pd_nm" name="pd_nm" placeholder="Products Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <select name="developfee" class="browser-default custom-select developfee">
                                <option selected="">DevelopFee</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                            </select>
                        </div>
                        <div class="form-group mr-8">
                            <select name="adminfee" class="browser-default custom-select adminfee">
                                <option selected="">AdminFee</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                            </select>
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
                    <div class="form-group">
                            <input type="text" class="form-control" id="edit_pd_code" name="edit_pd_code" readonly placeholder="Products Code">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit_pd_nm" name="edit_pd_nm" placeholder="Products Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit_price" name="edit_price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <select name="editdevelopfee" class="browser-default custom-select editdevelopfee">
                                <option selected="">DevelopFee</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                            </select>
                        </div>
                        <div class="form-group mr-8">
                            <select name="editadminfee" class="browser-default custom-select editadminfee">
                                <option selected="">AdminFee</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                                <option value="20">20%</option>
                                <option value="25">25%</option>
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                            </select>
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
        showAllProducts();
        autoNumber();
    });

    function showAllProducts() {
        $.ajax({
            url: "products/view",
            method: "POST",
            success: function(response) {
                $('#show').html(response);
                $("table").DataTable({
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
            url: "products/autonumber",
            method: "POST",
            success: function(response) {
                $("#pd_code").val(response);
            }
        });
    }


    //START INSERT
    $('#formsave').validate({ // initialize the plugin
        rules: {
            pd_nm: {
                required: true,
                maxlength: 20
            },
            price: {
                required: true,
                maxlength: 30
            },
            developfee: {
                required: true,
                digits: true
            },
            adminfee: {
                required: true,
                digits: true
            },
            status: {
                required: true
            },
        },
        messages: {
            pd_nm: {
                required: "Please enter product name",
                maxlength: "20 letters maximum"
            },
            price: {
                required: "Please enter product price",
                maxlength: "30 letters maximum"
            },
            developfee: {
                required: "Please enter develop fee",
                digits: "Only Number"
            },
            adminfee: {
                required: "Please enter admin fee",
                digits: "Only Number"
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
        submitHandler: function() {
            $('#saveModal').modal('hide');
            $.ajax({
                url: "<?= base_url('products/insert') ?>",
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
                        $("#pd_nm").val('');
                        $("#sts_nm").val('');
                        $("#price").val('');
                        $(".developfee").val('');
                        $(".admin").val('');
                        $("#active").prop("checked", false);
                        $("#notactive").prop("checked", false);
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
        e.preventDefault();
        edit_id = $(this).attr('id');
        $.ajax({
            url: "<?= base_url('products/getbyid') ?>",
            method: "POST",
            data: {
                id: edit_id
            },
            success: function(result) {
                const data = JSON.parse(result)
                $("#edit_pd_code").val(data.pd_code);
                $("#edit_pd_nm").val(data.pd_nm);
                $("#edit_price").val(data.price);
                formatRupiah($("#edit_price").val(), 'Rp. ');
                $(".editdevelopfee").val(data.develop_fee);
                $(".editadminfee").val(data.admin_fee);
                if (data.status == 1)
                    $("#editactive").prop("checked", true);
                else
                    $("#editnotactive").prop("checked", true);
                const form = document.querySelector('#formedit');
                form.setAttribute('name', data.pd_code);
                var editrupiah = document.getElementById('edit_price');
                editrupiah.value = formatRupiah($("#edit_price").val(), 'Rp. ');
            }
        });
    });

    //START EDIT
    $('#formedit').validate({ // initialize the plugin
        rules: {
            edit_pd_nm: {
                required: true,
                maxlength: 20
            },
            edit_price: {
                required: true,
                maxlength: 30
            },
            editdevelopfee: {
                required: true,
                digits: true
            },
            editadminfee: {
                required: true,
                digits: true
            },
            status: {
                required: true
            },
        },
        messages: {
            edit_pd_nm: {
                required: "Please enter product name",
                maxlength: "20 letters maximum"
            },
            edit_price: {
                required: "Please enter product price",
                maxlength: "30 letters maximum"
            },
            editdevelopfee: {
                required: "Please enter develop fee",
                digits: "Only Number"
            },
            editadminfee: {
                required: "Please enter admin fee",
                digits: "Only Number"
            },
            status: {
                required: "Please select status"
            },
        },
        submitHandler: function(e) {
            $('#editModal').modal('hide');
            $.ajax({
                url: "<?= base_url('products/edit') ?>",
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
                    url: "<?= base_url('products/delete') ?>",
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


    //RUPIAH FUNCTION
    var rupiah = document.getElementById('price');
    var editrupiah = document.getElementById('edit_price');
    
	rupiah.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		rupiah.value = formatRupiah(this.value, 'Rp. ');
	});
    editrupiah.addEventListener('keyup', function(e){
		editrupiah.value = formatRupiah($("#edit_price").val(), 'Rp. ');
	});
 
	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
 
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
</script>