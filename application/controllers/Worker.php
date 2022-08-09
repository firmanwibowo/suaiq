<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Worker extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Worker_model');
        $this->load->model('Master/Divisi_model');
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
        $data['title'] = 'Worker';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/worker', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{
        $autonumber = $this->Worker_model->autoNumber();
        echo $autonumber ;
        
	}

    public function view()
    {
        $totalRowcount = $this->Worker_model->count();
        $output = '';
        $data = $this->Worker_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="worker" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created By</th>
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
                                            <td>' . $row["email"] . '</td>  
                                            <td>' . $row["phone"] . '</td>  
                                            <td>' . $row["is_active"] . '</td>  
                                            <td>' . $row["created_at"] . '</td>  
                                            <td>
                                                <a href="#" id="' . $row['wr_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#saveModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['wr_code'] . '" title="Delete" class="text-danger delbtn">
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

    public function divisi()
    {
        $totalRowcount = $this->Divisi_model->count();
        $output = '';
        $data = $this->Divisi_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="divisi" class="table table-striped table-sm table-border">
                        <thead>
                            <tr>
                                <th scope="col" style="width:95px">NO</th>
                                <th scope="col" style="width:95px">Divisi Code</th>
                                <th scope="col" style="width:137px">Divisi Name</th>
                                <th scope="col" style="width:87px">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= ' <tr>
                                <td>' . $n . '</td>  
                                <td>' . $row["div_code"] . '</td>  
                                <td>' . $row["div_nm"] . '</td>  
                                <td>
                                    <a href="#" class="badge badge-success selectdivisi" id="'. $row['div_code'] .'">Select</a>
                                </td>
                            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function user()
    {
        $totalRowcount = count($this->Worker_model->getUser());
        $output = '';
        $data = $this->Worker_model->getUser();
        if ($totalRowcount > 0) {
            $output .= '<table id="user" class="table table-striped table-sm table-border">
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
                                <td>' . $row["user_id"] . '</td>  
                                <td>' . $row["user_nm"] . '</td>  
                                <td>
                                    <a href="#" class="badge badge-success selectuser" id="'. $row['user_id'] .'">Select</a>
                                </td>
                            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h3 class="text-center text-secondary mt-5">:( No any user present in the database.!</h3>';
        }
    }

    public function getById()
    {
        $data = $this->Worker_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function getDivisiById()
    {
        $data = $this->Worker_model->getDivisiById($_POST['id']);
        echo json_encode($data);
    }

    public function getUserById()
    {
        $data = $this->Worker_model->getUserById($_POST['id']);
        echo json_encode($data);
    }

    public function insert()
    {
        $wr_code = isset($_POST['wr_code']) ? $_POST['wr_code'] : '';
        $wr_nm = isset($_POST['wr_name']) ? $_POST['wr_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
        $div_code = isset($_POST['dv_code']) ? $_POST['dv_code'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        
        $worker = [
            'wr_code' => strtoupper($wr_code),
            'wr_nm' => strtoupper($wr_nm),
            'email' => $email,
            'phone' => $phone,
            'is_active' => $status,
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
            'div_code' => strtoupper($div_code),
            'user_id' => $user_id,
        ];
        
        $data = $this->Worker_model->insert($worker);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
        
    }

    public function edit()
    {
        $wr_code = isset($_POST['wr_code']) ? $_POST['wr_code'] : '';
        $wr_nm = isset($_POST['wr_name']) ? $_POST['wr_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
        $div_code = isset($_POST['dv_code']) ? $_POST['dv_code'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        
        $worker = [
            'wr_nm' => strtoupper($wr_nm),
            'email' => $email,
            'phone' => $phone,
            'is_active' => $status,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
            'div_code' => strtoupper($div_code),
            'user_id' => $user_id,
        ];
        
        $data = $this->Worker_model->update($worker, $wr_code);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
          
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $data = $this->Worker_model->delete($id);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully delete data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }

}
