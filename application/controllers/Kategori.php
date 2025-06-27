<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Kategori extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_kategori';
        }

        public function index(){
            $controller     = $this->uri->segment(1);
            $table              = 'tbl_kategori';
            $data['order']      = 'kategori_urutan';
            $data['id']         = 'kategori_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Kategori',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/kategori/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function formAdd(){
            $data['table']      = 'tbl_kategori';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Input Data Kategori',
                'id'            => $this->M_master->getData()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

           // print_r($data['id']);
            
           $this->load->view('layout_admin/head', $data);
           $this->load->view('layout_admin/top_header');
           $this->load->view('layout_admin/sidebar', $data);
           // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/kategori/form_add', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function actionAdd(){
            $table              = 'tbl_kategori';
            $controller         = $this->uri->segment(1);
            
            // print_r($controller);

            $data = array(
                'kategori_nama'         => $this->input->post('kategori_nama'),
                'kategori_deskripsi'    => $this->input->post('kategori_deskripsi'),
                'kategori_urutan'       => $this->input->post('kategori_urutan'),
                'status'                => $this->input->post('status'),
            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect($controller);
            }
        }

        function actionDelete($id){
            
            $table              = 'tbl_kategori';
            $data['id']         = 'kategori_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }


        public function formUpdate($id){
            $id                 = $this->uri->segment(3);
            $table              = 'tbl_kategori';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'getlist'       => $this->db->get_where('tbl_kategori', array('kategori_id' => $id))->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/kategori/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function actionUpdate(){
            $controller     = $this->uri->segment(1);
            $table          = 'tbl_kategori';

            $where          = array(
                'kategori_id' => $this->input->post('kategori_id'),
            );

            
            $id             = $this->input->post('kategori_id');
        
            $data = array(
                'kategori_nama'         => $this->input->post('kategori_nama'),
                'kategori_deskripsi'    => $this->input->post('kategori_deskripsi'),
                'kategori_urutan'       => $this->input->post('kategori_urutan'),
                'status'       => $this->input->post('status'),
            );
            print_r($data);

            $update = $this->M_master->updateData($table, $where, $data);
            print_r($update);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect('inventori/kategori');
            }
        }

        function viewData($id){

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_update', $data);
            $this->load->view('layout_admin/footer');
        }
    }
    
?>