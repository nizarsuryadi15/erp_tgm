<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Subkategori extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_subkategori';
            $controller = $this->uri->segment(1);
        }

        public function index(){
            $controller = $this->uri->segment(1);
            $table1             = 'tbl_subkategori';
            $table2             = 'tbl_kategori';
            $data['order']      = 'subkategori_urutan';
            $data['id']         = 'subkategori_id';

            print_r($data['id']);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
            //     'controller'    => $this->uri->segment(1),
                'function'      => 'Data Sub Kategori',
                'title'         => 'Daftar Sub Kategori',
            //     'table'         => 'tbl_subkategori',
                'tampilData'    => $this->db->get('tbl_subkategori')->result(),
            //     'total_rows'    => $this->M_master->joinKategori($table1,$table2, $data['order'])->num_rows(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/subkategori/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function formAdd(){
            $controller = $this->uri->segment(1);
            $table1             = 'tbl_subkategori';
            $table2             = 'tbl_kategori';

            $data['table']      = 'tbl_subkategori';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Input Data Sub Kategori',
                'id'            => $this->M_master->getData()->row_array(),
                'kategori'      => $this->M_master->tampilData($table2, 'kategori_urutan')->result(),
                'urutan'        => $this->M_master->getUrutan($table1, 'subkategori_urutan')->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            print_r($data['urutan']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_add', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function actionAdd(){
            $table              = 'tbl_subkategori';

            $controller         = $this->uri->segment(1);
    
            $data = array(
                'subkategori_nama'         => $this->input->post('subkategori_nama'),
                'subkategori_deskripsi'    => $this->input->post('subkategori_deskripsi'),
                'subkategori_urutan'    => $this->input->post('subkategori_urutan'),
                'status'                   => $this->input->post('status'),
                'kategori_id'              => $this->input->post('kategori_id'),
            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect($controller);
            }
        }

        function actionDelete($id){
            $table              = 'tbl_subkategori';
            $data['id']         = 'subkategori_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }


        public function formUpdate($id){
            $controller = $this->uri->segment(1);
            $table              = 'tbl_subkategori';
            $table2             = 'tbl_kategori';

            
            $data['id']         = 'subkategori_id';
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Sub Kategori',
                'getlist'       => $this->db->get_where($table, array($data['id'] => $id))->row_array(),
                'kategori'      => $this->M_master->tampilData($table2, 'kategori_urutan')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            // print_r($data['getlist']);
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function actionUpdate(){
            $table          = 'tbl_subkategori';

            $where          = array(
                'subkategori_id' => $this->input->post('subkategori_id'),
            );

            $controller     = $this->uri->segment(1);
            $id             = $this->input->post('subkategori_id');
        
            $data = array(
                'subkategori_nama'          => $this->input->post('subkategori_nama'),
                'subkategori_deskripsi'     => $this->input->post('subkategori_deskripsi'),
                'subkategori_urutan'        => $this->input->post('subkategori_urutan'),
                'status'                    => $this->input->post('status'),
                'kategori_id'               => $this->input->post('kategori_id'),
            );

            print_r($data);

            $update = $this->M_master->updateData($table, $where, $data);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
               redirect($controller);
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