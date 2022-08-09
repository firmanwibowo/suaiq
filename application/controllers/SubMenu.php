<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class SubMenu extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
            // $this->load->library('form_validation');
            $this->load->model('Auth/Auth_model');
            $this->load->model('Menu/Sub_Menu_model');
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

            $data['menu'] = $this->Sub_Menu_model->getAllMenu();
            $data['user'] = $this->Auth_model->search($post);
            $data['title'] = 'Sub Menu';
    

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/subMenu', $data);
            $this->load->view('templates/user_footer');
        }

        public function getMenuById(){
            $data = $this->Sub_Menu_model->getById($_POST['id']);
            echo json_encode($data);
        }

        public function insertSubMenu(){
            $submenu = isset($_POST['submenu']) ? $_POST['submenu'] : '';
            if(empty($submenu)){
                echo json_encode(array('error' => 'Please Input Data'));
            }else{
                for($row=0; $row<count($submenu); $row++) {
                    $data[] = array(
                        'sub_nm' => strtoupper($submenu[$row][3]),
                        'url' => $submenu[$row][4],
                        'icon' => $submenu[$row][5],
                        'ordering' => $submenu[$row][6],
                        'is_active' => $submenu[$row][7],
                        'menu_id' => $submenu[$row][1],
                    );
                }
               $result =  $this->Sub_Menu_model->insertAll($data);
               if ($result != '') {
                    echo json_encode(array('success' => 'Added Successfully.'));
                } else {
                    echo json_encode(array('error' => 'Failed To Save'));
                };
            }  
            
        }
        
    }
