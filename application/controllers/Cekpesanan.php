<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Cekpesanan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            
        }

        public function spk($nospk){
            
            $data = [
                'function'      => 'Cek Pesanan',
                'title'         => 'Cek Pesanan - Online',
                'nospk'         => $nospk,
                'pembayaran'    => $this->M_transaksi->getcekpesanan($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'cekflow'       => $this->db->get_where("tbl_produksi", array('nospk' => $nospk))->row_array(),
            ];

            // print_r($data['cekflow']);

            $this->load->view('layout_admin/head');
            $this->load->view('pesanan/cekpesanan', $data);
            $this->load->view('layout_admin/footer');

        }

        
    }
    
?>