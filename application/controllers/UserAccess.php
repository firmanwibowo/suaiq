<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserAccess extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Menu/User_access_model');
    }
    public function index()
    {
        // jika session tidak ada maka di kembalikan ke form login
        if (!$this->session->userdata('user_nm')) {
            redirect('auth');
        }       

        // $data['title'] = 'My Profile';

        // // cara yang lebih effisien bisa dengan fungsi
        // // memanggin funsgi di core class CI_Controller
        // $this->template('user/index', $data);
        $post = [
            'user_nm' => $this->session->userdata('user_nm'),
        ];

        $data['menu'] = $this->User_access_model->getAllMenu();
        $data['role'] = $this->User_access_model->getAllRole();
        $data['user'] = $this->Auth_model->search($post);
        $data['title'] = 'User Access';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('menu/userAccess', $data);
        $this->load->view('templates/user_footer');
    }

    
    public function getMenuById()
    {
        $data = $this->User_access_model->getMenuById($_POST['id']);
        echo json_encode($data);
    }

    
    public function getRoleById()
    {
        $data = $this->User_access_model->getRoleById($_POST['id']);
        echo json_encode($data);
    }

    public function accessValidasiById()
    {
        $data = $this->User_access_model->accessValidasi($_POST['role_id'], $_POST['menu_id']);
        if (empty($data)) {
            echo json_encode(array('success' => 'Added Successfully.'));
        } else {
            echo json_encode(array('error' => 'Role Already Has A Menu'));
        };
    }

    public function insertAccess(){
        $access = isset($_POST['access']) ? $_POST['access'] : '';
        $data = array();
        if(empty($access)){
            echo json_encode(array('error' => 'Please Input Data'));
        }else{
            for($row=0; $row<count($access); $row++) {
                $data[] = array(
                    'role_id' => $access[$row][1],
                    'menu_id' => $access[$row][3],
                );
            }
           $result =  $this->User_access_model->insertAll($data);
           if ($result != '') {
                echo json_encode(array('success' => 'Added Successfully.'));
            } else {
                echo json_encode(array('error' => 'Failed To Save'));
            };
        }  
    }
}
