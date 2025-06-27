<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Auth extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('M_auth');
            $this->load->library('form_validation');
            $this->load->library('session');
        }
    
        function index(){
            $data  = [
                'conf'      => $this->db->get('tbl_config')->result(),
                'title'     => 'Login'
            ];

            $this->load->view('layout_admin/head', $data);
            $this->load->view('auth/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function proses_login()
        {
            $username       = $this->input->post('username', TRUE);
            $inputPassword  = $this->input->post('password', TRUE); // ← TANPA md5!

            $user = $this->M_auth->login($username)->row_array();

            if ($user) {
                if ($user['active'] == '1') {
                    $dbPassword = $user['password'];

                    // Cocokkan password
                    if (password_verify($inputPassword, $dbPassword)) {

                        // Jika hash lama masih md5, upgrade ke password_hash
                        if (strlen($dbPassword) <= 32 && md5($inputPassword) === $dbPassword) {
                            $newHash = password_hash($inputPassword, PASSWORD_DEFAULT);
                            $this->db->where('user_id', $user['user_id'])->update('users', ['password' => $newHash]);
                        }

                        // Set session
                        $data = array(
                            'id'            => $user['user_id'],
                            'karyawan_id'   => $user['karyawan_id'],
                            'username'      => $user['username'],
                            'email'         => $user['email'],
                            'level'         => $user['role_id'],
                            'nama_level'    => $user['role_nama'],
                            'perusahaan_id' => $user['perusahaan_id'],
                            'user_img'      => $user['images'],
                            'logged_in'     => TRUE,
                        );
                        $this->session->set_userdata($data);
                        $this->session->set_flashdata('login', 'Berhasil login');
                        
                        // Log login
                        $this->db->insert('user_log', [
                            'user_id' => $user['user_id'], // pakai user_id sesuai session
                            'username' => $user['username'],
                            'login_time' => date('Y-m-d H:i:s')
                        ]);

                        redirect('Mobile');

                    } else {
                        $this->session->set_flashdata('error', 'Password salah');
                        redirect('auth');
                        $this->session->unset_userdata('success'); 
                    }
                } else {
                    $this->session->set_flashdata('error', 'Akun belum aktif');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Username tidak terdaftar');
                redirect('auth');
            }
        }

        function logout(){
            $this->session->sess_destroy();
            redirect('website');
        }

        
    }
