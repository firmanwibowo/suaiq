<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AllWorker extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Report/All_Worker_model');
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
        $data['title'] = 'All Worker Report';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('report/allWorker', $data);
        $this->load->view('templates/user_footer');
    }

    public function SearchOrder(){

        $startdate = isset($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : '';
        $enddate = isset($_POST['enddate']) ? date('Y-m-d', strtotime($_POST['enddate'])) : '';
        $data = [  
            'startdate' => $startdate,
            'enddate' => $enddate,
        ];
        $result = $this->All_Worker_model->getNewWorker($data);
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
                        <th scope="col">Product</th>
                        <th scope="col">Worker</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Created Date</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($result as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                            <td style="text-color:red">' . $n . '</td>  
                            <td style="text-color:red">' . $row["od_no"] . '</td>  
                            <td style="text-color:red">' .  date('d-m-Y', strtotime($row["od_tgl"])) . '</td>  
                            <td style="text-color:red">' . $row["pd_nm"] . '</td>  
                            <td style="text-color:red">' . $row["wr_nm"] . '</td> 
                            <td style="text-color:red">' . $row["reason"] . '</td>  
                            <td style="text-color:red">' .  $row["created_date"] . '</td>                                        
                        </tr>';
            }
            $output .= '</tbody></table></div>';

            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any data present in the database.!</h3>';
        }
    
       
    }

}
