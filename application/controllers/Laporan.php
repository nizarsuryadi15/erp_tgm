<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Laporan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
        }

        public function index(){

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/laporan/index', $data);
            $this->load->view('layout_admin/footer');
        }
    }

        