<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Status extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Status_model');
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
        $data['title'] = 'Status';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/status', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{
        $autonumber = $this->Status_model->autoNumber();
        echo $autonumber ; 
	}


    public function view()
    {
        $totalRowcount = $this->Status_model->count();
        // print_r($data);
        $output = '';
        $data = $this->Status_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created By</th>
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
                                            <td>' . $row["created_at"] . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['sts_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['sts_code'] . '" title="Delete" class="text-danger delbtn">
                                                <i class="fas fa-trash fa-lg"></i></a>&nbsp;&nbsp;

                                            </td> 
                                        </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function insert()
    {
        $sts_code = isset($_POST['sts_code']) ? $_POST['sts_code'] : '';
        $sts_nm = isset($_POST['sts_nm']) ? $_POST['sts_nm'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $status = [
            'sts_code' => strtoupper($sts_code),
            'sts_nm' => strtoupper($sts_nm),
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        $data = $this->Status_model->insert($status);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
        
    }

    public function getbyid()
    {
        $data = $this->Status_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function edit()
    {
        $sts_code = isset($_POST['edit_sts_code']) ? $_POST['edit_sts_code'] : '';
        $sts_nm = isset($_POST['edit_sts_nm']) ? $_POST['edit_sts_nm'] : '';
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $divisi = [
            'sts_nm' => strtoupper($sts_nm),
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        
        $data = $this->Status_model->update($divisi, $sts_code);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
          
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $data = $this->Status_model->delete($id);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully delete data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }

}
