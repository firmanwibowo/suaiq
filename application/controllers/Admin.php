<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
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
        $data['title'] = 'My Profile';

        //cara yang lebih effisien bisa dengan fungsi
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('roles/index', $data);
        $this->load->view('templates/user_footer');
    }
}
