<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserEntry extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Menu/User_entry_model');
        $this->load->model('Menu/User_access_model');
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

        $data['role'] = $this->User_access_model->getAllRole();
        $data['user'] = $this->Auth_model->search($post);
        $data['title'] = 'User Entry';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('menu/userentry', $data);
        $this->load->view('templates/user_footer');
    }

    public function view()
    {
        $totalRowcount = $this->User_entry_model->count();
        // print_r($data);
        $output = '';
        $data = $this->User_entry_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table id="firsttblGrid" class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Image</th>
                                <th scope="col">Password</th>
                                <th scope="col">Is Active</th>
                                <th scope="col">Level</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["user_nm"] . '</td>  
                                            <td>' . $row["email"] . '</td>  
                                            <td><img src="./uploads/users/'. $row["image"].'" alt="Girl in a jacket" width="50" height="50"></td> 
                                            <td>' . $row["password"] . '</td>  
                                            <td>' . $row["is_active"] . '</td>  
                                            <td>' . $row["role_nm"] . '</td> 
                                            <td>
                                                <a href="#" id="' . $row['user_id'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['user_id'] . '" title="Delete" class="text-danger delbtn">
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

    public function getRoleById()
    {
        $data = $this->User_access_model->getRoleById($_POST['id']);
        echo json_encode($data);
    }

    public function insert()
    {
      
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $created_date = date('Y-m-d H:i:s');
        $is_active = isset($_POST['status']) ? $_POST['status'] : '';
        $role_id = isset($_POST['roleid']) ? $_POST['roleid'] : '';

        $user = $this->User_entry_model->search($username);   
        if($user){
            echo json_encode(array('success'=>false,'msg'=>'Name already exists'));
        } else {
            $extention = substr($_FILES['imgupload']['name'], -3);
            if($extention != 'jpg' && $extention != 'png'){
                echo json_encode(array('success'=>false,'msg'=>'Image format must be JPG or PNG'));
            } else {
                if(isset($_FILES['imgupload']['name'])){
                    $config['upload_path'] = './uploads/users/';
                    $config['allowed_types'] = 'jpg|png';
                    $config['max_size'] = 2048;
                    $config['encrypt_name'] = true;
                
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                        
                        
                    if(!$this->upload->do_upload('imgupload')){
                        //echo $this->upload->display_errors();
                         echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
                    } else { 
                        $data = $this->upload->data();
                        $user = [
                            'user_nm' => $username,
                            'email' => $email,
                            'image' => $data['file_name'],
                            'password' => $password,
                            'is_active' => $is_active,
                            'created_date' => $created_date,
                            'role_id' => $role_id,
                        ]; 
                        $data = $this->User_entry_model->insert($user);
                        echo json_encode(array('success'=>true,'msg'=>'You have successfully data.'));
                    }
                }
            }
        }    
    }

    public function edit(){
        // print_r($_POST);
        // exit;
        $id = isset($_POST['edituserid']) ? $_POST['edituserid'] : '';
        $username = isset($_POST['editusername']) ? $_POST['editusername'] : '';
        $email = isset($_POST['editemail']) ? $_POST['editemail'] : '';
        // $created_date = date('Y-m-d H:i:s');
        $is_active = isset($_POST['editstatus']) ? $_POST['editstatus'] : '';
        $role_id = isset($_POST['editroleid']) ? $_POST['editroleid'] : '';
     
        $password = $this->User_entry_model->getById($id);
   
        $extention = substr($_FILES['editimgupload']['name'], -3);
        if(!$_FILES['editimgupload']['name']){
           if($password['password'] == $_POST['editpassword']){
                $user = [
                    'user_nm' => $username,
                    'email' => $email,
                    'is_active' => $is_active,
                    'role_id' => $role_id,
                ]; 
           } else {
                $user = [
                    'user_nm' => $username,
                    'email' => $email,
                    'password' => password_hash($_POST['editpassword'], PASSWORD_DEFAULT),
                    'is_active' => $is_active,
                    'role_id' => $role_id,
                ]; 
           }
            $data = $this->User_entry_model->update($user, $id);
            if ($data == 1) {
                echo json_encode(array('success'=>true,'msg'=>'You have successfully data.'));
            } else if ($data != 1) {
                echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
            }; 
        } else {
            if($extention != 'jpg' && $extention != 'png'){
                echo json_encode(array('success'=>false,'msg'=>'Image format must be JPG or PNG'));
            }else{
                $config['upload_path'] = './uploads/users/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = true;
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);         
                if(!$this->upload->do_upload('editimgupload')){
                    echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
                } else { 
                    $data = $this->upload->data();
                    if($password['password'] == $_POST['editpassword']){
                        print_r('kesini');
                        exit;
                        $user = [
                            'user_nm' => $username,
                            'email' => $email,
                            'image' => $data['file_name'],
                            'is_active' => $is_active,
                            'role_id' => $role_id,
                        ]; 
                   } else {
                        $user = [
                            'user_nm' => $username,
                            'email' => $email,
                            'image' => $data['file_name'],
                            'password' => password_hash($_POST['editpassword'], PASSWORD_DEFAULT),
                            'is_active' => $is_active,
                            'role_id' => $role_id,
                        ]; 
                   }
                
                    $data = $this->User_entry_model->update($user, $id);
                    if ($data == 1) {
                        echo json_encode(array('success'=>true,'msg'=>'You have successfully data.'));
                    } else if ($data != 1) {
                        echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
                    };
                }
            }
        }
    }

    public function delete(){
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        if($id == ''){
            echo json_encode(array('success'=>false, 'msg'=>'Error occurred during processing.'));
        } else {
            $data = $this->User_entry_model->delete($id);
            if ($data == 1) {
                echo json_encode(array('success'=>true, 'msg'=>'Delete Successfully.'));
            } else if ($data != 1) {
                echo json_encode(array('success'=>false, 'msg'=>'Error occurred during processing.'));
            };
        }  
    }

    public function getbyid(){
        $data = $this->User_entry_model->getById($_POST['id']);
        echo json_encode($data);
    }
}
