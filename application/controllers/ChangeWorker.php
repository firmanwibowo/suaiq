<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChangeWorker extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Transaksi/Change_Worker_model');
        $this->load->model('Master/Worker_model');
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
        $data['title'] = 'Change Worker';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('transaksi/changeWorker', $data);
        $this->load->view('templates/user_footer');
    }


    public function view()
    {
        $totalRowcount = count($this->Change_Worker_model->getAll());
        $output = '';
        $data = $this->Change_Worker_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="order" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Order No</th>
                                <th scope="col">Status</th>
                                <th scope="col">Worker</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Fee</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["od_no"] . '</td>  
                                            <td>' . $row["sts_nm"] . '</td>  
                                            <td>' . $row["wr_nm"] . '</td> 
                                            <td>' . $row["pd_nm"] . '</td> 
                                            <td>' .  $this->rupiah($row["price"], "") . '</td> 
                                            <td>' . $row["qty"] . '</td> 
                                            <td>' . $row["fee"] . '</td> 
                                            <td>' . $this->rupiah( $row["total"], "") . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['od_no'] . '" name="' . $row['pd_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                            </td> 
                                        </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function worker()
    {
        $totalRowcount = $this->Worker_model->count();
        $output = '';
        $data = $this->Worker_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="worker" class="table table-striped table-sm table-border">
                        <thead>
                            <tr>
                                <th scope="col" style="width:95px">No</th>
                                <th scope="col" style="width:95px">User Code</th>
                                <th scope="col" style="width:137px">User Name</th>
                                <th scope="col" style="width:87px">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= ' <tr>
                                <td>' . $n . '</td>  
                                <td>' . $row["wr_code"] . '</td>  
                                <td>' . $row["wr_nm"] . '</td>  
                                <td>
                                    <a href="#" class="badge badge-success selectworker" id="'. $row['wr_code'] .'">Select</a>
                                </td>
                            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any data present in the database.!</h3>';
        }
    }

    public function getWorkerById()
    {
        $data = $this->Worker_model->getById($_POST['id']);
        echo json_encode($data);
    }


    public function getbyid()
    {
        $data = $this->Change_Worker_model->getById($_POST['od_no'], $_POST['pd_code']);
        echo json_encode($data);
    }


    public function edit()
    {
 
        $od_no = isset($_POST['od_no']) ? $_POST['od_no'] : '';
        $worker_code = isset($_POST['worker_code']) ? $_POST['worker_code'] : '';
        $worker_code_2 = isset($_POST['worker_code_2']) ? $_POST['worker_code_2'] : '';
        $product_code = isset($_POST['product_code']) ? $_POST['product_code'] : '';
        $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
    
        $worker = [
            'wr_code' => strtoupper($worker_code)
        ];
        
        $workerchange = [
            'od_no' => strtoupper($od_no),
            'pd_code' => strtoupper($product_code),
            'wr_code' => strtoupper($worker_code_2),
            'reason' => strtolower($reason),
            'created_at' => $created_at,
            'created_date' => $created_date
        ];

        if($worker_code == $worker_code_2) {
            echo json_encode(array('success'=>false, 'msg'=>' Worker must be different'));
        } else {
            $select =  $this->Change_Worker_model->getWorkerSame($od_no, $product_code, $worker_code);
            if($select){
                echo json_encode(array('success'=>false, 'msg'=>' Worker data has been changed'));
            } else {
                $datadetilworker = $this->Change_Worker_model->update($worker, $od_no, $product_code);
                $datachangeworker = $this->Change_Worker_model->insert($workerchange);
                if ($datadetilworker == 1 && $datachangeworker == 1) {
                    echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
                } else if ($data != 1 || $data == "") {
                    echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
                };
            }
        }
                                    
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $data = $this->Customer_model->delete($id);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully delete data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }


    function rupiah($angka, $prefix){
        $hasil_rupiah = $prefix . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
}
