<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Customer_model');
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
        $data['title'] = 'Customer';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/customer', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{
        $autonumber = $this->Customer_model->autoNumber();
        echo $autonumber ;
        
	}


    public function view()
    {
        $totalRowcount = $this->Customer_model->count();
        // print_r($data);
        $output = '';
        $data = $this->Customer_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Created By</th>
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
                                            <td>' . $row["email"] . '</td> 
                                            <td>' . $row["phone"] . '</td> 
                                            <td>' . $row["created_at"] . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['cs_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['cs_code'] . '" title="Delete" class="text-danger delbtn">
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
        $cs_code = isset($_POST['cs_code']) ? $_POST['cs_code'] : '';
        $cs_nm = isset($_POST['cs_nm']) ? $_POST['cs_nm'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $customer = [
            'cs_code' => strtoupper($cs_code),
            'cs_nm' => strtoupper($cs_nm),
            'email' => strtoupper($email),
            'phone' => $phone,
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        $data = $this->Customer_model->insert($customer);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
        
    }

    public function getbyid()
    {
        $data = $this->Customer_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function edit()
    {
        $cs_code = isset($_POST['edit_cs_code']) ? $_POST['edit_cs_code'] : '';
        $cs_nm = isset($_POST['edit_cs_nm']) ? $_POST['edit_cs_nm'] : '';
        $email = isset($_POST['edit_email']) ? $_POST['edit_email'] : '';
        $phone = isset($_POST['edit_phone']) ? $_POST['edit_phone'] : '';
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $customer = [
            'cs_nm' => strtoupper($cs_nm),
            'email' => strtoupper($email),
            'phone' => $phone,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        
        $data = $this->Customer_model->update($customer, $cs_code);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
          
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

}
