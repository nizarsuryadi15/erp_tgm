<?php 
    //error_reporting(0);
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Produksi extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_transaksi');
                $this->load->model('M_master');
                $user_img = $this->session->userdata('user_img');
            }
            
        }

        function index(){
            $user   = $this->session->userdata('id');
            $divisi = $this->session->userdata('level');
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Produksi Product',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getProduksina()->result(),
                'total_rows'    => $this->M_transaksi->getProduksina()->num_rows(),
                'user'          => $user,
                'divisi'        => $divisi,
                'logo'          => $conf['perusahaan']['logo'],
                'operator'      => $this->db->get('tbl_operator')->result(),
                // 'level'         => $divisi;
            );

            //print_r($data);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/transaksi/produksi', $data);
            $this->load->view('layout_admin/footer');
        }

        public function proses()
        {
            $produksi_id       = $this->input->post('produksi_id');
            $qty_produksi      = $this->input->post('qty_produksi');
            $panjang_produksi  = $this->input->post('panjang_produksi');
            $lebar_produksi    = $this->input->post('lebar_produksi');
            $status_produksi   = $this->input->post('status_produksi');

            // validasi sederhana (opsional)
            if (!$status_produksi) {
                $this->session->set_flashdata('error', 'Status produksi wajib diisi.');
                redirect('transaksi/produksi');
            }

            // data yang akan diupdate
            $data = [
                'qty_produksi'      => $qty_produksi,
                'panjang_produksi'  => $panjang_produksi,
                'lebar_produksi'    => $lebar_produksi,
                'status_produksi'   => $status_produksi,
                'update_time'       => date('Y-m-d H:i:s')
            ];

            print_r($data);
            print_r($produksi_id);

            // update ke database
            $this->db->where('produksi_id', $produksi_id);
            $this->db->update('tbl_produksi', $data);

            // $this->session->set_flashdata('success', 'Data produksi berhasil diperbarui.');
            redirect('transaksi/produksi'); // ganti ke halaman tujuan
        }

        function op_produksi($op){
            $user   = $this->session->userdata('id');
            $divisi = $this->session->userdata('level');
        
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Produksi Product',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getOPProduksina($op)->result(),
                'total_rows'    => $this->M_transaksi->getOPProduksina($op)->num_rows(),
                'user'          => $user,
                'divisi'        => $divisi,
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'operator'          => $this->db->get('tbl_operator')->result(),
            );

            //print_r($data);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('transaksi/produksi', $data);
            $this->load->view('layout_admin/footer');
        }

    }