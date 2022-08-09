<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AllFee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Report/All_Fee_model');
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
        $data['title'] = 'All Fee';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('report/allFee', $data);
        $this->load->view('templates/user_footer');
    }

    public function SearchFee(){

        $startdate = isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '';
        $enddate = isset($_POST['enddate']) ? date('Y-m-d', strtotime($_POST['enddate'])) : '';
        $combouser = isset($_POST['combouser']) ? $_POST['combouser'] : '';
        $comboworker = isset($_POST['comboworker']) ? $_POST['comboworker'] : '';

        $data = array();
        if($combouser == 'admin'){
            $feeadmin = 'd.admin_fee as fee, ((d.price * d.qty * d.admin_fee) / 100) as total';
            $feeadminsts = ' and d.admin_fee_sts = 1';
            $data = [
                'fee' => $feeadmin,
                'feests' => $feeadminsts,
                'startdate' => $startdate,
                'enddate' => $enddate,
            ];
        } else if($combouser == 'developer'){
            $feedevelop = 'd.develop_fee as fee, ((d.price * d.qty * d.develop_fee) / 100) as total';
            $feedevelopsts = ' and d.develop_fee_sts = 2';
            $data = [
                'fee' => $feedevelop,
                'feests' => $feedevelopsts,
                'startdate' => $startdate,
                'enddate' => $enddate,
            ];
        } else {
            $margin = '(100 - d.admin_fee - d.develop_fee) as fee, ((d.price * d.qty * (100 - d.admin_fee - d.develop_fee )) / 100) as total';
            $marginsts = ' and d.worker_fee_sts = 2 and c.wr_code = "'.$comboworker.'"';
            $data = [
                'fee' => $margin,
                'feests' => $marginsts,
                'startdate' => $startdate,
                'enddate' => $enddate,
            ];
        }
       

        if($data){
            $result = $this->All_Fee_model->getMargin($data);
            $output = '';
            $grandtotal = 0;
            $output .= '<div class="table-responsive">
            <table id="orders" class="table table-striped table-sm table-border">
                <thead>
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Order</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Worker</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Fee %</th>
                        <th scope="col">Fee Total</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($result as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' .  date('d-m-Y',strtotime($row["od_tgl"])) . '</td>  
                                            <td>' . $row["sts_nm"]. '</td>  
                                            <td>' . $row["wr_nm"]. '</td> 
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>' . $this->rupiah($row["price"], " ") . '</td>  
                                            <td>' . $row["qty"] . '</td>  
                                            <td>' . $row["fee"] . '</td>  
                                            <td>' . $this->rupiah($row["total"], " ") . '</td>                                         
                                        </tr>';
                $grandtotal += $row["total"];
            }
            $output .= '</tbody></table></div>';

            $output .= '
                        
                        <div class="row mt-3" style="float:right;">
                            <div class="form-group row">
                                <label style="margin-left:10px; margin-top:8px"><b>Commission Total</b></label>
                                <div class="col-sm-7">
                                    <input style="text-align: right;" type="text"  class="form-control" id="grn_ttl_fee" value="'.$this->rupiah($grandtotal, "Rp. ").'" name="grn_ttl_fee" placeholder="Commission Total" readonly>    
                                </div>
                            </div>
                        </div>';

            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any data present in the database.!</h3>';
        }
    
       
    }

    public function getDataUser(){
        echo "<option value='' hidden>Select User</option>";
        $worker = $this->All_Fee_model->getDataUserAll();
        foreach ($worker as $key => $value) {
            echo "<option value='" . $value['wr_code'] . "'>" . $value['wr_nm'] . "</option>";
        }
        
    }

    function rupiah($angka, $prefix){
        $hasil_rupiah = $prefix . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

}
