<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FeeApproval extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Status_model');
        $this->load->model('Payment/Fee_Approval_model');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        // jika session tidak ada maka di kembalikan ke form login
        if (!$this->session->userdata('user_nm')) {
            redirect('auth');
        }

        $post = [
            'user_nm' => $this->session->userdata('user_nm'),
        ];
        
        $data['user'] = $this->Auth_model->search($post);
        $data['title'] = 'Fee Approval';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('payment/feeApproval', $data);
        $this->load->view('templates/user_footer');
    }

    public function viewdetilorder()
    {
        $totalRowcount = count($this->Fee_Approval_model->getDevelopFee());
        $output = '';
        $data = $this->Fee_Approval_model->getDevelopFee();
        if ($totalRowcount > 0) {
            $grandtotal = 0;
            $output .= '<div class="table-responsive">
            <table id="detilorder" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Develop Fee</th>
                                <th scope="col">Develop Commission</th> 
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' . $row["wr_nm"] . '</td>  
                                            <td>' . $row["pd_code"] . '</td>  
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>' . $this->rupiah($row["price"]) . '</td>  
                                            <td>' . $row["qty"] . '</td>  
                                            <td>' . $this->rupiah($row["total_harga"]) . '</td>  
                                            <td>' . $row["develop_fee"] . '</td>  
                                            <td>' . $this->rupiah($row["komisi_develop"]) . '</td>
                                            
                                        </tr>';
                $grandtotal += $row["komisi_develop"];
            }
            $output .= '</tbody></table></div>';
            $output .= '<div class="row mt-4" style="float:left">
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="checkbox" name="select_all" value="0" id="example-select-all">
                                <label class="form-check-label" for="gridCheck1">
                                    <b>Approve Commission</b>
                                </label>
                            </div>
                            <div class="form-group" style="margin-top: -8px;">
                                <button type="button" id="sendcommission" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                            
                         <div class="row mt-3" style="float:right;">
                            <div class="form-group row">
                                <label style="margin-left:10px;"><b>Commission Total</b></label>
                                <div class="col-sm-7">
                                    <input style="text-align: right; margin-top:-10px; margin-left:10px" type="text"  class="form-control" id="grn_ttl_fee" name="grn_ttl_fee" placeholder="Commission Total" value="'.$this->rupiah($grandtotal, "Rp. ").'" readonly>       
                                </div>
                            </div>
                        </div>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any data present in the database.!</h3>';
        }
    }


   public function updatedetilorder(){
        $listdatadetilorder = isset($_POST['detilorder']) ? $_POST['detilorder'] : '';
      
        for($row=1; $row<=count($listdatadetilorder); $row++) {
            $dataorderdetil[] = array(
                'od_no' => $listdatadetilorder[$row]['od_no'],
                'develop_fee_sts' => 2,
            );
            
        }
      
        $orderdetil = $this->Fee_Approval_model->updatedetilorders($dataorderdetil, 'od_no');
        if ($orderdetil == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($orderdetil != 0) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        }
   }

    function rupiah($angka){
        $hasil_rupiah = "" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }


}
