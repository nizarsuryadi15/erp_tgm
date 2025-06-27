<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Website extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            
        }

        public function index(){
            $data = array(
                'perusahaan'        => $this->db->get('tbl_config')->row_array(),
                'total_konsumen'    => $this->M_master->tampilData('tbl_konsumen', 'konsumen_nama')->num_rows(),
                'total_product'     => $this->M_master->getDataProduct()->num_rows(),
            );

            $this->load->view('website/head', $data);
            // $this->load->view('website/header', $data);
            $this->load->view('website/index', $data);
            $this->load->view('website/footer', $data);

        }
        
        public function product(){

            $data = array(
                'product'       => $this->M_master->getDataProduct()->result(),  
            );

            $this->load->view('website/head', $data);
            // $this->load->view('website/header', $data);
            $this->load->view('website/product', $data);
            $this->load->view('website/footer', $data);
        }

        public function penggunaan(){

            $data = array(
                'product'       => $this->M_master->getDataProduct()->result(),  
            );

            $this->load->view('website/head', $data);
            // $this->load->view('website/header', $data);
            $this->load->view('website/cara_penggunaan', $data);
            $this->load->view('website/footer', $data);
        }

        public function cekpesanan(){

            $data = array(
                'product'       => $this->M_master->getDataProduct()->result(),  
            );

            if ($this->input->post('nospk')){
                $nospk      = $this->input->post('nospk');
                $data = array(
                    'pembayaran'    => $this->M_transaksi->getcekpesanan($nospk)->row_array(),
                    'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                    'cekflow'       => $this->db->get_where("tbl_produksi", array('nospk' => $nospk))->row_array(),
                );
            }

            $this->load->view('website/head', $data);
            $this->load->view('website/header', $data);
            $this->load->view('website/cek_pesanan', $data);
            $this->load->view('website/footer', $data);
        }

        public function detail_product($kode){

            $data = array(
                'getproduct'    => $this->M_master->getProduct($kode)->row_array(),
                
            );

            $this->load->view('website/head', $data);
            $this->load->view('website/header', $data);
            $this->load->view('website/single_product', $data);
            $this->load->view('website/footer', $data);
        }
    }
?>