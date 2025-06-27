<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
        }

        public function index(){
            $data['order']      = 'alur_urutan';
            $data['id']         = 'kategori_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'title'         => 'Daftar Alur Kerja',
                'tampilData'    => $this->M_master->tampilData($data['table'], $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilData($data['table'], $data['order'])->num_rows(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function formAdd(){
            $data['order']      = 'alur_urutan';
            $data['id']         = 'kategori_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Input Data Alur Kerja',
                'id'            => $this->M_master->getData()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

           // print_r($data['id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('layout_admin/footer');
        
        }

        function actionAdd(){
            
            $alur_nama          = $this->input->post('alur_nama');
            $alur_urutan        = $this->input->post('alur_urutan');
            $alur_keterangan    = $this->input->post('alur_keterangan');

            print_r($alur_nama);
            print_r($alur_urutan);
            print_r($alur_keterangan);

            $data = array(
                'alur_nama'         => $alur_nama,
                'alur_urutan'       => $alur_urutan,
                'alur_keterangan'   => $alur_keterangan
            );

            print_r($data);

            print_r($add);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
            }
        }

        function actionDelete($id){
            $this->db->where('alur_id', $id);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
            }
        }


        public function formUpdate($id){
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
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('layout_admin/footer');
            
        }

        public function actionUpdate(){
            $alur_id        = $this->input->post('alur_id');
            $alur_nama      = $this->input->post('alur_nama');
            $alur_urut      = $this->input->post('alur_urutan');
            $alur_ket       = $this->input->post('alur_keterangan');

            $data = array(
                'alur_nama'         => $alur_nama,
                'alur_urutan'       => $alur_nama,
                'alur_keterangan'   => $alur_ket,
            );

            $where = array(
                'alur_id' => $alur_id,
            );


            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
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
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('layout_admin/footer');
        }
    }
    
?>