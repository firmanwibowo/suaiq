<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendFee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Status_model');
        $this->load->model('Transaksi/Send_Fee_model');
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
        $data['title'] = 'Worker Fee';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('transaksi/sendFee', $data);
        $this->load->view('templates/user_footer');
    }

    public function getDataUser(){
        echo "<option value='' hidden>Select User</option>";
        $worker = $this->Send_Fee_model->getDataUserAll();
        foreach ($worker as $key => $value) {
            echo "<option value='" . $value['wr_code'] . "'>" . $value['wr_nm'] . "</option>";
        }
        
    }

    public function SearchFee(){
        $combouser = isset($_POST['combouser']) ? $_POST['combouser'] : '';
        $comboworker = isset($_POST['comboworker']) ? $_POST['comboworker'] : '';
        
        if($combouser == 'develop'){
            $feedevelop = 'b.develop_fee as fee, (((b.price * b.qty) *  b.develop_fee ) / 100) AS total';
            $feedevelopsts = ' AND b.develop_fee_sts = 0';
            $data = [
                'fee' => $feedevelop,
                'feests' => $feedevelopsts,
            ];
        } else if($combouser == 'admin'){
            $feeadmin = 'b.admin_fee as fee, (((b.price * b.qty) *  b.admin_fee ) / 100) AS total';
            $feeadminsts = ' AND b.admin_fee_sts = 0';
            $data = [
                'fee' => $feeadmin,
                'feests' => $feeadminsts,
            ];
        } else if($combouser == 'worker'){
            $feeworker = '(100 - b.develop_fee - b.admin_fee) as fee, (((b.price * b.qty) * (100 - b.develop_fee - b.admin_fee)) / 100) AS total';
            $feeworkersts = ' AND b.worker_fee_sts = 0 and e.wr_code = "'.$comboworker.'"';
            $data = [
                'fee' => $feeworker,
                'feests' => $feeworkersts,
            ];
        }
        $result = $this->Send_Fee_model->getAllFee($data);
        if($result){
            $output = '';
            $grandtotal = 0;
            $output .= '<div class="table-responsive mt-3">
                <table id="allfee" class="table table-striped table-sm table-border">
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
                            <th scope="col">Worker Fee</th>
                            <th scope="col">Worker Commission</th> 
                        </tr>
                    </thead>
                    <tbody>';

                foreach ($result as $n => $row) {
                    $n += 1;
                    $output .= '<tr class="text-center text-secondary">
                                    <td>' . $n . '</td>  
                                    <td>' . $row["od_no"] . '</td>   
                                    <td>' . $row["wr_nm"]. '</td> 
                                    <td>' . $row["pd_code"] . '</td>
                                    <td>' . $row["pd_nm"] . '</td>  
                                    <td>' . $this->rupiah($row["price"], " ") . '</td>  
                                    <td>' . $row["qty"] . '</td>  
                                    <td>' . $this->rupiah($row["total_harga"], " ") . '</td>  
                                    <td>' . $row["fee"] . '</td>   
                                    <td>' . $this->rupiah($row["total"], " ") . '</td>                                      
                                </tr>';
                    $grandtotal += $row["total"];
                }
            $output .= '</tbody></table></div>';

            $output .= '<div class="row mt-4" style="float:left">
                            <div class="form-check mx-1">
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
        $detilorder = isset($_POST['detilorder']) ? $_POST['detilorder'] : '';
        $user = isset($_POST['user']) ? $_POST['user'] : '';
        $flag = 0;

        if($user == 'develop'){
            $status = [
                'develop_fee_sts' => 1,
            ];
        } elseif($user == 'admin'){
            $status = [
                'admin_fee_sts' => 1,
            ];
        } elseif($user == 'worker'){
            $status = [
                'worker_fee_sts' => 1,
            ];
        }
       
        foreach ($detilorder as $key => $value) {
           $res = $this->Send_Fee_model->updateDetilOrder($status, $value['od_no'], $value['pd_code']);
           $flag = 0;
           if($res == 1){
                $flag = 1;
           }else{
                $flag = 0;
           }
        }

        if ($flag == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        }
        
        
    }

    function rupiah($angka){
        $hasil_rupiah = "" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }


}
