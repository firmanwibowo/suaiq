                <?php
                defined('BASEPATH') or exit('No direct script access allowed');

                class Auth extends CI_Controller
                {

                    public function __construct()
                    {
                        parent::__construct(); //untuk memanggin constract yang ada di CI_Controller
                        $this->load->library('form_validation');
                        $this->load->model('Auth/Auth_model');
                        ob_start();
                    }
                    public function index()
                    {
                        //$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
                        $this->form_validation->set_rules('name', 'Name', 'required|trim');
                        $this->form_validation->set_rules('password', 'Password', 'required|trim');

                        if ($this->form_validation->run() == false) {

                            $data['title'] = 'Login';
                            $this->load->view('templates/auth_header', $data);
                            $this->load->view('auth/login');
                            $this->load->view('templates/auth_footer');
                        } else {

                            $this->login();
                        }
                    }

                    private function login()
                    {
                        $data = [
                            'user_nm' => $this->input->post('name'),
                            'password' =>  $this->input->post('password')
                        ];

                        $result = $this->Auth_model->search($data);


                        //jika usernya active / ada
                        if ($result) {
                            if ($result['is_active'] == 1) {
                                //check password
                                if (password_verify($data['password'], $result['password'])) {
                                    $session_data = [
                                        'user_nm' => $result['user_nm'],
                                        'role_id' => $result['role_id']
                                    ];

                                    //simpan data ke session
                                    $this->session->set_userdata($session_data);

                                    //check role_id
                                    if ($result['role_id'] == 1) {
                                        redirect('admin');
                                    } else if ($result['role_id'] == 2){
                                        redirect('user');
                                    } if ($result['role_id'] == 3) {
                                        redirect('develop');
                                    }
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
                    Wrong Password!</div>'); //flash data session
                                    redirect('auth'); // mengembalikan ke controller login
                                }
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
                This Name Has Not Been Activated!</div>'); //flash data session
                                redirect('auth');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">
            Name Is Not Registered!</div>'); //flash data session
                            redirect('auth');
                        }
                    }

            //         public function registration()
            //         {

            //             //start rules https://codeigniter.com/userguide3/libraries/form_validation.html?highlight=form%20validation#rule-reference

            //             $this->form_validation->set_rules('name', 'Name', 'required|trim');
            //             $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            //                 'is_unique' => "This Email Has Already Registered.!!"
            //             ]);
            //             $this->form_validation->set_rules('password', 'password', 'required|trim');
            //             $this->form_validation->set_rules(
            //                 'pass_confim',
            //                 'pass_confim',
            //                 'required|trim|min_length[3]|matches[password]',
            //                 [
            //                     'matches' => "Password Don't Matches",
            //                     'min_length' => "Password Too Short",
            //                     'required' => "Required Password"
            //                 ]
            //             );

            //             //end rules
            //             if ($this->form_validation->run() == false) {
            //                 $data['title'] = 'Registration';
            //                 $this->load->view('templates/auth_header', $data);
            //                 $this->load->view('auth/registration');
            //                 $this->load->view('templates/auth_footer');
            //             } else {
            //                 date_default_timezone_set('Asia/Jakarta');
            //                 $data = [
            //                     'user_nm' => htmlspecialchars($this->input->post('name', true)),
            //                     'email' => htmlspecialchars($this->input->post('email', true)),
            //                     'image' => 'default.jpg',
            //                     'password' => password_hash($this->input->post('pass_confim'), PASSWORD_DEFAULT), //password_hash fungsi / method bawaan php bukan ci
            //                     'is_active' => 1, //belajar user activation
            //                     'created_date' => date("Y-m-d H:i:s"),
            //                     'role_id' => 1
            //                 ];
            //                 $this->Auth_model->save("users", $data);
            //                 $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
            // Congtratulation ! Your Account Has Been Created. Please Login</div>'); //flash data session
            //                 redirect('auth');
            //             }
            //         }

                    public function logout()
                    {

                        //untuk membersihkan session

                        $this->session->unset_userdata('user_nm');
                        $this->session->unset_userdata('role_id');
                        $this->session->sess_destroy();

                        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">
        You Have Been Logged Out!</div>'); //flash data session
                        redirect('auth');
                    }
                }
