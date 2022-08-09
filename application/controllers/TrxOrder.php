<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TrxOrder extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Worker_model');
        $this->load->model('Master/Customer_model');
        $this->load->model('Master/Divisi_model');
        $this->load->model('Master/Products_model');
        $this->load->model('Master/Status_model');
        $this->load->model('Transaksi/Trx_Order_model');
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
        $data['title'] = 'Order';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('transaksi/trxOrder', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{

        $autonumber = $this->Trx_Order_model->autoNumber();
        echo $autonumber ;
        
	}

    public function viewcustomer()
    {
        $totalRowcount = $this->Customer_model->count();
        $output = '';
        $data = $this->Customer_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="customer" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["cs_code"] . '</td>  
                                            <td>' . $row["cs_nm"] . '</td>  
                                            <td>
                                                <a href="#" class="badge badge-success selectcustomer" id="'. $row['cs_code'] .'">Select</a>
                                            </td> 
                                        </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function viewworker()
    {
        $totalRowcount = count($this->Worker_model->getAll());
        // print_r($data);
        $output = '';
        $data = $this->Worker_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="worker" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
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
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    
    public function viewproduct()
    {
        $totalRowcount = count($this->Trx_Order_model->getAllProductActive());
        $output = '';
        $data = $this->Trx_Order_model->getAllProductActive();
        if ($totalRowcount > 0) {
            $output .= '<table id="product" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["pd_code"] . '</td>  
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>
                                                <a href="#" class="badge badge-success selectproduct" id="'. $row['pd_code'] .'">Select</a>
                                            </td> 
                                        </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function viewstatus()
    {
        $totalRowcount = $this->Status_model->count();
        $output = '';
        $data = $this->Status_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="status" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
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


    public function getByIdCS()
    {
        $data = $this->Customer_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function getByIdWK()
    {
        $data = $this->Worker_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function getByIdPD()
    {
        $data = $this->Products_model->getById($_POST['id']);
        echo json_encode($data);
    }
    public function getByIdSTS()
    {
        $data = $this->Status_model->getById($_POST['id']);
        echo json_encode($data);
    }
    public function insertOrder()
    {
        $dataorderdetil = array();
        $dataworkerdetil = array();
        $dataorder = array();
        $orderno = isset($_POST['orderno']) ? $_POST['orderno'] : '';
        $orderdate = isset($_POST['orderdate']) ? strtotime($_POST['orderdate']) : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
        $cscode = isset($_POST['cscode']) ? $_POST['cscode'] : '';
        $stscode = isset($_POST['stscode']) ? $_POST['stscode'] : '';
        $listdataorder = isset($_POST['order']) ? $_POST['order'] : '';

        $dataorder = [
            'od_no' => strtoupper($orderno),
            'od_tgl' => date('Y-m-d',$orderdate).date(' H:i:s'),
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
            'cs_code' => strtoupper($cscode),
            'sts_code' => strtoupper($stscode),
        ];
        
        for($row=0; $row<count($listdataorder); $row++) {
            $dateformat = new DateTime($listdataorder[$row][2]);
            $dataorderdetil[] = array(
                'od_no' => $orderno,
                'pd_code' => $listdataorder[$row][7],
                'price' => $listdataorder[$row][9],
                'qty' => $listdataorder[$row][10],
                'develop_fee' => $listdataorder[$row][11],
                'admin_fee' => $listdataorder[$row][12],
                'due_date' => $dateformat->format('Y-m-d H:i:s'),
                'sts_code' => $listdataorder[$row][5],
            );
            $dataworkerdetil[] = array(
                'od_no' => $orderno,
                'wr_code' => $listdataorder[$row][3],
                'pd_code' => $listdataorder[$row][7],
            );
        }

        $order = $this->Trx_Order_model->insertOrder($dataorder);
        $orderdetil = $this->Trx_Order_model->insertOrderDetil($dataorderdetil);
        $workerdetil = $this->Trx_Order_model->insertWorkerDetil($dataworkerdetil);
        if ($order == 1 && $orderdetil== 1 && $workerdetil) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }
    

}
