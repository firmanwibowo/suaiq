<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
        // $this->load->library('form_validation');
        $this->load->model('Auth/Auth_model');
        $this->load->model('Master/Products_model');
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
        $data['title'] = 'Product';

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('master/products', $data);
        $this->load->view('templates/user_footer');
    }

    public function autonumber()
	{
        $autonumber = $this->Products_model->autoNumber();
        echo $autonumber ;
        
	}


    public function view()
    {
        $totalRowcount = $this->Products_model->count();
        $output = '';
        $data = $this->Products_model->getAll();
        if ($totalRowcount > 0) {
            $output .= '<table class="table table-striped table-sm table-border">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Price</th>
                                <th scope="col">Develop Fee</th>
                                <th scope="col">Admin Fee</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($data as $n => $row) {
                $n += 1;
                $output .= '<tr class="text-center text-secondary">
                                            <td>' . $n . '</td>  
                                            <td>' . $row["pd_code"] . '</td>  
                                            <td>' . $row["pd_nm"] . '</td>  
                                            <td>' . $row["status"] . '</td>  
                                            <td>' . $this->rupiah($row["price"]) . '</td>  
                                            <td>' . $row["develop_fee"] . '%</td>  
                                            <td>' . $row["admin_fee"] . '%</td>  
                                            <td>' . $row["created_at"] . '</td>  
                                            <td>
                                                <a href="#" id="' . $row['pd_code'] . '" title="Edit" class="text-primary editBtn" data-toggle="modal" data-target="#editModal">
                                                <i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;
                                                <a href="#" id="' . $row['pd_code'] . '" title="Delete" class="text-danger delbtn">
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
        $priceformant = str_replace(".", "", substr($_POST['price'],4));
        $pd_code = isset($_POST['pd_code']) ? $_POST['pd_code'] : '';
        $pd_nm = isset($_POST['pd_nm']) ? $_POST['pd_nm'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $price = isset($priceformant) ? $priceformant : '';
        $develop_fee = isset($_POST['developfee']) ? $_POST['developfee'] : '';
        $admin_fee = isset($_POST['adminfee']) ? $_POST['adminfee'] : '';
        $created_at = $this->session->userdata('user_nm');
        $created_date = date('Y-m-d H:i:s');
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $products = [
            'pd_code' => strtoupper($pd_code),
            'pd_nm' => strtoupper($pd_nm),
            'status' => $status,
            'price' => $price,
            'develop_fee' => $develop_fee,
            'admin_fee' => $admin_fee,
            'created_at' => strtoupper($created_at),
            'created_date' => $created_date,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];

        $data = $this->Products_model->insert($products);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully insert data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
        
    }

    public function getbyid()
    {
        $data = $this->Products_model->getById($_POST['id']);
        echo json_encode($data);
    }

    public function edit()
    {
        $priceformant = str_replace(".", "", substr($_POST['edit_price'],4));
        $pd_code = isset($_POST['edit_pd_code']) ? $_POST['edit_pd_code'] : '';
        $pd_nm = isset($_POST['edit_pd_nm']) ? $_POST['edit_pd_nm'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $price = isset($priceformant) ? $priceformant : '';
        $develop_fee = isset($_POST['editdevelopfee']) ? $_POST['editdevelopfee'] : '';
        $admin_fee = isset($_POST['editadminfee']) ? $_POST['editadminfee'] : '';
        $modified_at = $this->session->userdata('user_nm');
        $modified_date = date('Y-m-d H:i:s');
    
        $products = [
            'pd_nm' => strtoupper($pd_nm),
            'status' => $status,
            'price' => $price,
            'develop_fee' => $develop_fee,
            'admin_fee' => $admin_fee,
            'modified_at' => strtoupper($modified_at),
            'modified_date' => $modified_date,
        ];
        
        $data = $this->Products_model->update($products, $pd_code);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully update data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
          
    }

    public function delete()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $data = $this->Products_model->delete($id);
        if ($data == 1) {
            echo json_encode(array('success'=>true,'msg'=>'You have successfully delete data.'));
        } else if ($data != 1) {
            echo json_encode(array('success'=>false,'msg'=>'Error occurred during processing.'));
        };
    }

    function rupiah($angka){
        $hasil_rupiah = "" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

}
