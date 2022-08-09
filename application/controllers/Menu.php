<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Menu/Menu_model');
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

        $data['menu'] = $this->Menu_model->getAll();
        $data['user'] = $this->Auth_model->search($post);
        $data['title'] = 'Menu';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('menu/menu', $data);
        $this->load->view('templates/user_footer');
    }

    public function view()
    {
        $totalRowcount = $this->Menu_model->count();
        // print_r($data);
        $output = '';
        $data = $this->Menu_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Icon</th>
                                <th scope="col">Ordering</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["menu_nm"] . '</td>  
                                            <td>' . $row["icon"] . '</td>  
                                            <td>' . $row["ordering"] . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['menu_id'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['menu_id'] . '" title="Delete" class="text-danger delbtn">
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
        $menu = isset($_POST['menu']) ? $_POST['menu'] : '';
        $icon = isset($_POST['icon']) ? $_POST['icon'] : '';
        $order = isset($_POST['order']) ? $_POST['order'] : '';
        $is_active = isset($_POST['status']) ? $_POST['status'] : '';

        if($menu == '' || $icon == '' || $order == '' || $is_active == ''){
            echo json_encode(array('success' => 'Error occurred during processing.'));
        } else {
            $menu = [
                'menu_nm' => strtoupper($menu),
                'icon' => $icon,
                'ordering' => $order,
                'is_active' => $is_active,
            ];
            $data = $this->Menu_model->insert($menu);
            if ($data == 1) {
                echo json_encode(array('success' => 'Added Successfully.'));
            } else if ($data != 1) {
                echo json_encode(array('error' => 'Error occurred during processing.'));
            };
        }
    }

    public function getbyid()
    {
        $data = $this->Menu_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function edit()
    {
        $menu = isset($_POST['editmenu']) ? $_POST['editmenu'] : '';
        $icon = isset($_POST['editicon']) ? $_POST['editicon'] : '';
        $order = isset($_POST['editorder']) ? $_POST['editorder'] : '';
        $is_active = isset($_POST['status']) ? $_POST['status'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';
       
        if($menu == '' || $icon == '' || $order == '' || $is_active == '' || $id == ''){
            echo json_encode(array('success' => 'Error occurred during processing.'));
        } else {
            $menu = [
                'menu_nm' => strtoupper($menu),
                'icon' => $icon,
                'ordering' => $order,
                'is_active' => $is_active,
            ];
            $data = $this->Menu_model->update($menu, $id);
            if ($data == 1) {
                echo json_encode(array('success' => 'Added Successfully.'));
            } else if ($data != 1) {
                echo json_encode(array('error' => 'Error occurred during processing.'));
            };
        }
          
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        if($id == ''){
            echo json_encode(array('success' => 'Error occurred during processing.'));
        } else {
            $data = $this->Menu_model->delete($id);
            if ($data == 1) {
                echo json_encode(array('success' => 'Delete Successfully.'));
            } else if ($data != 1) {
                echo json_encode(array('error' => 'Error occurred during processing.'));
            };
        }  
    }

}
