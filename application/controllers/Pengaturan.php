<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Pengaturan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();

            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_master');
            }
            
        }

        public function index(){
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $table              = 'tbl_konsumen';
            $data['order']      = 'konsumen_nama';
            $data['id']         = 'kategori_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Pengaturan Sistem',
                
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                'store'         => $this->db->get('tbl_perusahaan')->num_rows(),
                'users'         => $this->db->get('users')->num_rows(),
                'karyawan'      => $this->db->get('tbl_karyawan')->num_rows(),
                'konsumen'      => $this->db->get('tbl_konsumen')->num_rows(),
                'bahanbaku'     => $this->db->get('tbl_bahan')->num_rows(),
                'product'       => $this->db->get('tbl_product')->num_rows(),
                'mesin'         => $this->db->get('tbl_mesin')->num_rows(),
                'getmenu'       => $this->db->get('menu')->num_rows(),

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/pengaturan/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function user_account(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $table              = 'users';
            $data['order']      = 'user_id';
            $data['id']         = 'user_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pengguna Sistem',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->getAllUser()->result(),
                'total_rows'    => $this->M_master->getAllUser()->num_rows(),
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'karyawan'      => $this->db->get('tbl_karyawan')->result(),
                'divisi'        => $this->db->get('tbl_divisi')->result(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

            $this->load->view('layout_admin/head', $data);
            // $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/'.$controller.'/user_account', $data);
            $this->load->view('layout_admin/footer');
        }

        public function edit_user_account($id){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $table              = 'users';
            $data['order']      = 'user_id';
            $data['id']         = 'user_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pengguna',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->getAllUser()->result(),
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('profile/edit_pengguna', $data);
            $this->load->view('layout_admin/footer');
        }

        public function action_add_user_account(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_user';
            $controller         = $this->uri->segment(1);
            
            // print_r($controller);

            $data = array(
                'username'              => $this->input->post('username'),
                'email'                 => $this->input->post('email'),
                'password'              => md5($this->input->post('password')),
                'karyawan_id'           => $this->input->post('karyawan_id'),
                'divisi_id'             => $this->input->post('divisi_id'),
                'active'                => $this->input->post('active'),
                'images'                => 'sample.png',
                'perusahaan_id'         => '1'
            );
            
            $this->db->insert('tbl_user', $data);
            
            print_r($data);
        }

        // Divisi 

        public function divisi(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $table              = 'tbl_divisi';
            $data['order']      = 'divisi_id';
            $data['id']         = 'divisi_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Divisi Perusahaan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->db->get('tbl_divisi')->result(),
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'karyawan'      => $this->db->get('tbl_karyawan')->result(),
                'divisi'        => $this->db->get('tbl_divisi')->result(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

            $this->load->view('layout_admin/head', $data);
            // $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/'.$controller.'/'.$function, $data);
            $this->load->view('layout_admin/footer');
        }
    }