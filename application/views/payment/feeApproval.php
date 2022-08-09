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
        <div class="col-12" id="detilordershow">
            
        </div>
    </div>
    <!-- <div class="form-row mt-3"> 
        <div class="form-group col-md-9">
            <input style="" type="checkbox" name="select_all" value="0" id="example-select-all">
            <label style="display: block; margin-left:20px; margin-top:-23px;"><b>Approve Commission</b></label>
            <button type="button" id="sendcommission" class="btn btn-primary mt-2">Send Commission</button>
        </div>
        <div class="form-group col-md-3"> 
            <label style="display: block; text-align: center;"><b><h5>Commission Total</h5></b></label><input type="text" class="form-control" id="grn_ttl_fee" name="grn_ttl_fee" placeholder="Commission Total" readonly>
        </div>
    </div> -->
</div>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        showAllDetilOrder();
    });

    function showAllDetilOrder() {
        $.ajax({
            url: "FeeApproval/viewdetilorder",
            method: "POST",
            success: function(response) {
                $('#detilordershow').html(response);
                var table = $('#detilorder').DataTable({
                    destroy: true,
                    order: [0, 'asc'],
                    select: true,
                    scrollY: true,
                    scrollX: true,
                    bAutoWidth: false
                });
                // var grandtotal = 0;
                // var data = table.rows().data().toArray();
                // for(var i = 0; i < data.length; i++){
                //     grandtotal += parseInt(data[i][9].replace(/\./g,''));
                // }
                // $('#grn_ttl_fee').val(grandtotal)
                // var grandtotal = document.getElementById('grn_ttl_fee');
                // grandtotal.value = formatRupiah($("#grn_ttl_fee").val(), 'Rp ');
            }
        });
    }

    $("body").on("click", "#example-select-all", function(e) {
        //e.preventDefault();
        if($(this).prop("checked") == true){
            $("#example-select-all").attr("value", "1");
        }
        else if($(this).prop("checked") == false){
            $("#example-select-all").attr("value", "0");
        }
    });

    $("body").on('click', '#sendcommission', function(e){
        var table = document.getElementById('detilorder');
        if (!table){
            Swal.fire({ //sweet alert
                position: 'center',
                icon: 'error',
                title: 'Data Is Not Found',
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            
            var odno = [{}];
            for (var r = 1, n = table.rows.length; r < n; r++) {
                odno.push(
                            {
                                'od_no':table.rows[r].cells[1].innerHTML,
                                'pd_code':table.rows[r].cells[3].innerHTML
                            } 
                        );
            }
            // console.log(odno)
            var approvefee = $("input[type='checkbox']").val();
            if(approvefee == 0){
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Please Checklist Approve Commission',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                $.ajax({
                    url: "<?= base_url('FeeApproval/updatedetilorder') ?>",
                    method: "POST",
                    data:  {
                            detilorder: odno,
                    }, // array 2 dimensi
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
                            showAllDetilOrder();
                        } else {
                            Swal.fire({ //sweet alert
                                position: 'center',
                                icon: 'error',
                                title: result.msg,
                                showConfirmButton: false,
                                timer: 2000
                            }) 
                            showAllDetilOrder(); 
                        }
                    }
                });
            }   
        }
        
        
             
    });

    /* Fungsi formatRupiah */
	// function formatRupiah(angka, prefix){
	// 	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	// 	split   		= number_string.split(','),
	// 	sisa     		= split[0].length % 3,
	// 	rupiah     		= split[0].substr(0, sisa),
	// 	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
	// 	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	// 	if(ribuan){
	// 		separator = sisa ? '.' : '';
	// 		rupiah += separator + ribuan.join('.');
	// 	}
 
	// 	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	// 	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	// }


</script>