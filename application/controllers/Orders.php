<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Report/Orders_model');
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
        $data['title'] = 'Orders Report';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('report/orders', $data);
        $this->load->view('templates/user_footer');
    }

    public function SearchOrder(){

        $startdate = isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '';
        $enddate = isset($_POST['enddate']) ? date('Y-m-d', strtotime($_POST['enddate'])) : '';
        $data = [  
            'startdate' => $startdate,
            'enddate' => $enddate,
        ];
        $result = $this->Orders_model->getFinishOrders($data);
        if($result){ 
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
                        <th scope="col">Total</th>
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

    function rupiah($angka, $prefix){
        $hasil_rupiah = $prefix . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

}
