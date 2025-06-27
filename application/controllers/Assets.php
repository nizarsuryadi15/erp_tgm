<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Assets extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_bahan';
        }

        public function index(){
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Bahan Baku',
                'content'       => 'workflow/index',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->getDataBahan()->result(),
                'total_rows'    => $this->M_master->getDataBahan()->num_rows(),
                'workFlow'      => $this->M_master->tampilData('tbl_workflow', 'alur_urutan')->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/index', $data);
            $this->load->view('layout_admin/footer');
        }
        public function kategori(){
            $table              = 'tbl_kategori_assets';
            $controller         = $this->uri->segment(1);
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Kategori Assets',
                'content'       => 'workflow/index',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->db->get($table)->result(),
                'total_rows'    => $this->M_master->getDataBahan()->num_rows(),
                'workFlow'      => $this->M_master->tampilData('tbl_workflow', 'alur_urutan')->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/kategori', $data);
            $this->load->view('layout_admin/footer');
        }

        
    }
    
?>