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
</div>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        showAllDetilOrder();
    });

    function showAllDetilOrder(){
        $.ajax({
            url: "CekIncome/viewdetilorder",
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
                                'pd_code':table.rows[r].cells[2].innerHTML
                            } 
                        );
            }
            // console.log(odno)
            var approvefee = $("input[type='checkbox']").val();
            if(approvefee == 0){
                Swal.fire({ //sweet alert
                    position: 'center',
                    icon: 'error',
                    title: 'Please Checklist Approve Income',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                $.ajax({
                    url: "<?= base_url('CekIncome/updatedetilorder') ?>",
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


</script>