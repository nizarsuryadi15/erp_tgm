<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Konsumen extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_kategori';
            $this->load->model('M_transaksi');
        }

        public function index(){
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $table              = 'tbl_konsumen';
            $data['order']      = 'konsumen_nama';
            $data['id']         = 'konsumen_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'CRM - Daftar Konsumen',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
                'jml_konsumen'  => $this->db->get($table)->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/transaksi/konsumen/index', $data);
            $this->load->view('layout_admin/footer');
            $this->load->view('layout_admin/alert');
        }

        public function konsumen(){
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
                'title'         => 'CRM - Daftar Konsumen',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/transaksi/konsumen/index', $data);
            $this->load->view('layout_admin/footer');
        }

         public function aktivitas_konsumen(){
            $controller     = $this->uri->segment(1);
            $function       = $this->uri->segment(2);
            
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
                'title'         => 'CRM - Aktivitas Konsumen',
                'table'         => 'tbl_kategori',
                'tampil_data'   => $this->M_transaksi->get_konsumen_dengan_transaksi()->result(),
                'total_rows'    => $this->M_transaksi->get_konsumen_dengan_transaksi()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/transaksi/konsumen/aktivitas_konsumen', $data);
            $this->load->view('layout_admin/footer');
        }


        function actionAdd(){
            $table              = 'tbl_konsumen';
            $controller         = $this->uri->segment(1);
            
            // print_r($controller);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'konsumen_nama'         => $this->input->post('konsumen_nama'),
                'konsumen_alamat'       => $this->input->post('konsumen_alamat'),
                'konsumen_nohp'         => $this->input->post('konsumen_nohp'),
                'konsumen_email'        => $this->input->post('konsumen_email'),
                // 'password'              => md5($this->input->post('konsumen_nohp')),
                // 'member'                => '0',
                // 'avatar'                => 'male.png',
                // 'perusahaan_id'         => $this->session->userdata('perusahaan_id'),
                // 'logo'                  => $conf['perusahaan']['logo'],

            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('konsumen/konsumen');
            }
        }

        function aksi_delete(){
            
            $id                 = $this->uri->segment(3);
            $table              = 'tbl_konsumen';
            $data['id']         = 'konsumen_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }


       

        public function aksi_edit()
            {
                $id = $this->input->post('konsumen_id');

                $data = [
                    'konsumen_nama'   => $this->input->post('konsumen_nama', true),
                    'konsumen_alamat' => $this->input->post('konsumen_alamat', true),
                    'konsumen_nohp'   => $this->input->post('konsumen_nohp', true),
                    'konsumen_email'  => $this->input->post('konsumen_email', true),
                    'status'          => $this->input->post('status', true)
                ];

                $this->db->where('konsumen_id', $id);
                $this->db->update('tbl_konsumen', $data);

                $this->session->set_flashdata('success', 'Data konsumen berhasil diperbarui.');
                redirect('konsumen');
            }


        function lihat_konsumen($id){

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_update', $data);
            $this->load->view('layout_admin/footer');
        }

        public function get_ajax()
        {
            $request = $_POST;
            $this->load->model('Konsumen_model');

            $data = $this->Konsumen_model->get_datatables($request);
            echo json_encode($data);    
        }

        public function search_ajax()
        {
            $term = $this->input->get('q');
            $this->db->like('konsumen_nama', $term);
            $this->db->limit(20);
            $data = $this->db->get('tbl_konsumen')->result();

            $result = [];
            foreach ($data as $row) {
                $result[] = [
                    'konsumen_id' => $row->konsumen_id,
                    'konsumen_nama' => $row->konsumen_nama
                ];
            }

            echo json_encode($result);
        }


    }

    
?>