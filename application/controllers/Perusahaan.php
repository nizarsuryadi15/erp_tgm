<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Perusahaan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            
        }

        public function index(){
            $table              = 'tbl_perusahaan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Data Perusahaan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->getPerusahaan()->result(),
                'total_rows'    => $this->M_master->getPerusahaan()->num_rows(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/perusahaan/index', $data);
            $this->load->view('layout_admin/footer');
        }
    }
?>