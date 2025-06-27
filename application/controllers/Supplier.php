<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Supplier extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_bahan';
        }
        
        function index(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => 'Dashboard',
                'title'             => 'Supllier',
                'content'           => 'dashboard/index',
                'perusahaan'        => $perusahaan,
                'tampilData'        => $this->db->get('tbl_supplier')->result(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/supplier/index', $data);
            $this->load->view('layout_admin/footer');
        }
    }