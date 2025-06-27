<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Penjualan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_transaksi');
            }

            $this->load->library('rajaongkir');
            
        }

    
        public function index(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Daftar Pemesanan',
                'table'                 => 'tbl_kategori',
                'tampilData'            => $this->M_transaksi->getDataPemesanan()->result(),
                'total_rows'            => $this->M_transaksi->getDataPemesanan()->num_rows(),
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'              => $conf['hakakses']['divisi_nama'],
                'logo'                  => $conf['perusahaan']['logo'],
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header', $data);
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/'.$controller.'/'.$function, $data);
            $this->load->view('layout_admin/footer');
        }

        public function pembayaran(){
            //print_r($bayarna);
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Transaksi Penjualan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getBayarmetode($bayar)->result(),
                'total_rows'    => $this->M_transaksi->getBayarmetode($bayar)->num_rows(),
                'total_trx'     => $this->M_transaksi->getTotalTrxmetode($bayar)->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('penjualan/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function onday($bayar){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Transaksi Penjualan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getPenjualanday($bayar)->result(),
                'total_rows'    => $this->M_transaksi->getPenjualanday($bayar)->num_rows(),
                'total_trx'     => $this->M_transaksi->getTotalday()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('penjualan/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function best_selling(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Best Selling',
                'table'         => 'tbl_penjualan',
                'tampilData'    => $this->M_transaksi->getPenjualanday($bayar)->result(),
                'total_rows'    => $this->M_transaksi->getPenjualanday($bayar)->num_rows(),
                'total_trx'     => $this->M_transaksi->getTotalday()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('penjualan/index', $data);
            $this->load->view('layout_admin/footer');
        }
    }