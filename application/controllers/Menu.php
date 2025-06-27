<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Menu extends CI_Controller
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
            $table              = 'menu';
            $data['order']      = 'id';
            $data['id']         = 'id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Pengaturan Menu',
                'table'         => 'tbl_kategori',
                // 'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                // 'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'jmlmenu'          => $this->db->get('menu')->num_rows(),
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/pengaturan/menu/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function submenu(){
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $submenu            = $this->uri->segment(3);

            $table              = 'submenu';
            $data['order']      = 'id';
            $data['id']         = 'id_menu';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Pengaturan Menu',
                'table'         => 'tbl_kategori',
                // 'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                // 'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'getsubmenu'       => $this->db->get_where('submenu', array('id_menu'=>$submenu))->result(),
                'jmlmenu'       => $this->db->get_where('submenu', array('id_menu'=>$submenu))->num_rows(),
                
                'submenu'       => $this->M_master->getmenu($controller)->result(), 
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/pengaturan/menu/submenu', $data);
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
            $table              = 'tbl_mesin';
            $controller         = $this->uri->segment(1);
    
            $data = array(
                'mesin_nama'         => $this->input->post('mesin_nama'),
                'mesin_keterangan'   => $this->input->post('mesin_keterangan'),
                'kategori'           => $this->input->post('kategori'),
            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('mesin');
            }
        }

        function aksi_delete(){
            
            $id                 = $this->uri->segment(3);
            $table              = 'tbl_mesin';
            $data['id']         = 'mesin_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }


        public function edit_mesin($id){
            $controller         = $this->uri->segment(1);
            $table              = 'tbl_kategori';
            $data['id']         = 'kategori_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'getlist'       => $this->db->get_where($table, array($data['id'] => $id))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/kategori/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function aksi_edit(){
            $controller     = $this->uri->segment(1);
            $table          = 'tbl_mesin';

            $where          = array(
                'mesin_id' => $this->input->post('mesin_id'),
            );

            
            $id             = $this->input->post('mesin_id');
        
            $data = array(
                'mesin_nama'         => $this->input->post('mesin_nama'),
                'mesin_keterangan'    => $this->input->post('mesin_keterangan'),
                'kategori'       => $this->input->post('kategori'),
                
            );
            print_r($data);

            $update = $this->M_master->updateData($table, $where, $data);
            print_r($update);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect($controller);
            }
        }
    }
    
?>