<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
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

        $data['divisi'] = $this->Divisi_model->getAll();
        $data['user'] = $this->Auth_model->search($post);
        $data['title'] = 'Divisi';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/divisi', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{
        $autonumber = $this->Divisi_model->autoNumber();
        echo $autonumber ;    
	}


    public function view()
    {
        $totalRowcount = $this->Divisi_model->count();
        $output = '';
        $data = $this->Divisi_model->getAll();
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
                                            <td>' . $row["div_code"] . '</td>  
                                            <td>' . $row["div_nm"] . '</td>  
                                            <td>' . $row["created_at"] . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['div_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['div_code'] . '" title="Delete" class="text-danger delbtn">
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
        $div_code = isset($_POST['div_code']) ? $_POST['div_code'] : '';
        $div_nm = isset($_POST['div_nm']) ? $_POST['div_nm'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $divisi = [
            'div_code' => strtoupper($div_code),
            'div_nm' => strtoupper($div_nm),
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        
        $data = $this->Divisi_model->insert($divisi);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
        
    }

    public function getbyid()
    {
        $data = $this->Divisi_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function edit()
    {
        $div_code = isset($_POST['edit_div_code']) ? $_POST['edit_div_code'] : '';
        $div_nm = isset($_POST['edit_div_nm']) ? $_POST['edit_div_nm'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $divisi = [
            'div_nm' => strtoupper($div_nm),
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        
        $data = $this->Divisi_model->update($divisi, $div_code);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
          
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $data = $this->Divisi_model->delete($id);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully delete data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }

}
