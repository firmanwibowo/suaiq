<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CekIncome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Status_model');
        $this->load->model('Report/Cek_Income_model');
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
        $data['title'] = 'Cek Income';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('report/cekIncome', $data);
        $this->load->view('templates/user_footer');
    }

    public function viewdetilorder()
    {
        $totalRowcount = count($this->Cek_Income_model->getWorkerFee($this->session->userdata('user_nm')));
        $output = '';
        $data = $this->Cek_Income_model->getWorkerFee($this->session->userdata('user_nm'));
        if ($totalRowcount > 0) {
            $grandtotal = 0;
            $output .= '<div class="table-responsive">
            <table id="detilorder" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Income</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' . $row["pd_code"] . '</td>  
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>' . $this->rupiah($row["income"]) . '</td>   
                                        </tr>';
                $grandtotal += $row["income"];
            }
            $output .= '</tbody></table></div>';
            $output .= '<div class="row mt-4" style="float:left">
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="checkbox" name="select_all" value="0" id="example-select-all">
                                <label class="form-check-label" for="gridCheck1">
                                    <b>Approve Income</b>
                                </label>
                            </div>
                            <div class="form-group" style="margin-top: -8px;">
                                <button type="button" id="sendcommission" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                            
                         <div class="row mt-3" style="float:right;">
                            <div class="form-group row">
                                <label style="margin-left:37px;"><b>Income Total</b></label>
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

        $status = [
            'worker_fee_sts' => 2,
        ];

        foreach ($detilorder as $key => $value) {
            $res = $this->Cek_Income_model->updatedetilorders($status, $value['od_no'], $value['pd_code']);
            
          
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
