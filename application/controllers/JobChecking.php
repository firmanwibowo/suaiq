<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JobChecking extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Status_model');
        $this->load->model('Transaksi/Job_Checking_model');
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
        $data['title'] = 'Job Checking';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('transaksi/jobChecking', $data);
        $this->load->view('templates/user_footer');
    }

    public function view()
    {
        $totalRowcount = $this->Job_Checking_model->count();
        $output = '';
        $data = $this->Job_Checking_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="orders" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Status Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' . date('d-m-Y',strtotime($row["od_tgl"]))  . '</td>';

                                            if(strtoupper($row["sts_code"]) == "ST02"){
                                                
                                                $output .= '<td><b><p style="color:red;">' . $row["sts_nm"] . '</p></b></td>';
                                            } else {
                                                
                                                $output .= '<td>' . $row["sts_nm"] . '</td>';
                                            }  
                                    $output .=  '<td>
                                                <a href="#" id="' . $row['od_no'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg" id="' . $row['od_no'] . '"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['od_no'] . '" title="Info" class="text-danger infobtn">
                                                <i class="fas fa-info fa-lg" id="' . $row['od_no'] . '"></i></a>&nbsp;&nbsp;
                                            </td> 
                                        </tr>
                                        ';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }  


    public function viewjob()
    {
       

        $output = '';
        $data = $this->Job_Checking_model->getAllOrderByCode($_POST['id']);
     
        $output .= '<table id="job" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>';

         foreach ($data as $n => $row) {
                $n += 1;
            $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' . $row["wr_nm"] . '</td>  
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>' . $row["qty"] . '</td>  
                                            <td>' . $this->rupiah($row["price"]) . '</td>';
                                            if(strtoupper($row["sts_code"]) == "ST03"){
                                                
                                                $output .= '<td><b><p style="color:red;">' . $row["sts_nm"] . '</p></b></td>';
                                            } else {
                                                
                                                $output .= '<td>' . $row["sts_nm"] . '</td>';
                                            }
            $output .= '</tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    }  

    function rupiah($angka){
        $hasil_rupiah = "" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    public function getodbycode(){
        $data = $this->Job_Checking_model->getByCode($_POST['id']);
        echo json_encode($data);
    }

    public function status(){
        $totalRowcount = $this->Status_model->count();
        $output = '';
        $data = $this->Status_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="status" class="table table-striped table-sm table-border">
                        <thead>
                            <tr>
                                <th scope="col" style="width:95px">NO</th>
                                <th scope="col" style="width:95px">Status Code</th>
                                <th scope="col" style="width:137px">Status Name</th>
                                <th scope="col" style="width:87px">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= ' <tr>
                                <td>' . $n . '</td>  
                                <td>' . $row["sts_code"] . '</td>  
                                <td>' . $row["sts_nm"] . '</td>  
                                <td>
                                    <a href="#" class="badge badge-success selectstatus" id="'. $row['sts_code'] .'">Select</a>
                                </td>
                            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function getstatusbycode(){
        $data = $this->Status_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function updateorder(){
        $od_code = isset($_POST['edit_od_no']) ? $_POST['edit_od_no'] : '';
        $sts_code = isset($_POST['edit_sts_code']) ? $_POST['edit_sts_code'] : '';
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');

        $orders = [
            'sts_code' => strtoupper($sts_code),
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date
        ];

        $order_detil = [
            'sts_code' => strtoupper($sts_code),
        ];

        $dataorder = $this->Job_Checking_model->updateorders($orders, $od_code);
        $datadetilorder = $this->Job_Checking_model->updatedetilorders($order_detil, $od_code);

        if ($dataorder == 1 && $datadetilorder == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };

    }

}
