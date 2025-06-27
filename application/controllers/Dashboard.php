<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                // $user_img   = $this->session->userdata('user_img');
                $this->load->model('M_transaksi');
                $this->load->model('M_master');
                $perusahaan = $this->session->userdata('perusahaan_id');
            }
        }

        public function index(){
            $userid = $this->session->userdata('id');
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
                'userid'        => $this->db->get_where('users', array('user_id'=> $this->session->userdata('id')))->row_array(),
                
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => 'Dashboard',
                'title'             => 'Dashboard',
                'content'           => 'dashboard/index',
                'perusahaan'        => $perusahaan,
                'total_produksi'    => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Masuk Proses Produksi'))->num_rows(),
                'total_done'        => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Produksi Selesai, Barang di Bagian PB'))->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'              => $conf['perusahaan']['logo'],
                'username'          => $conf['userid']['username'],
                'operator'          => $this->db->get('tbl_operator')->result(),
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
            );

            if ($data['level']['role_id']=='2'){
                redirect('transaksi/createspk','refresh');
            }
            if ($data['level']['role_id']=='2'){
                redirect('transaksi/createspk');
            }elseif ($data['level']['role_id']=='3'){
                redirect('transaksi/transaksi_belumbayar');
            }elseif ($data['level']['role_id']=='4'){
                redirect('transaksi/daftar-produksi');
            }elseif ($data['level']['role_id']=='5'){
                redirect('gudang');
            }elseif ($data['level']['role_id']=='6'){
                redirect('keuangan');
            }else{

                $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/top_header');
                $this->load->view('layout_admin/sidebar');
                $this->load->view('admin/dashboard/index', $data);
                $this->load->view('layout_admin/footer');
                $this->load->view('layout_admin/alert');
            
            }
            
        }

        public function board(){
            $userid     = $this->session->userdata('id');
            $harian     = date('Y-m-d');
            $kemarin    = date('Y-m-d', strtotime('-1 day'));

            $conf       = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => 'Dashboard',
                'title'             => 'Dashboard',
                'content'           => 'dashboard/index',
                'perusahaan'        => $perusahaan,
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'operator'          => $this->db->get('tbl_operator')->result(),
                'jml_pemesanan'     => $this->M_transaksi->get_pemesanan()->num_rows(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),

                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
            
                'total_trx'             => $this->M_transaksi->getTotalTrx($bulanan)->row_array(),
                'total_trxday'          => $this->M_transaksi->getTotalTrx($harian)->row_array(),
                'total_kemarin'         => $this->M_transaksi->getTotalTrx($kemarin)->row_array(),
                'total_penj_kemarin'    => $this->M_transaksi->total_produk_terjual($kemarin)->row_array(),
                'total_penj_hariini'    => $this->M_transaksi->total_produk_terjual($harian)->row_array(),
                'menu'                  => $this->db->get('menu')->result(),

                'jan'               => $this->M_transaksi->transaksi_bulanan('01')->row_array(),
                'feb'               => $this->M_transaksi->transaksi_bulanan('02')->row_array(),
                'mar'               => $this->M_transaksi->transaksi_bulanan('03')->row_array(),
                'apr'               => $this->M_transaksi->transaksi_bulanan('04')->row_array(),
                'mei'               => $this->M_transaksi->transaksi_bulanan('05')->row_array(),
                'jun'               => $this->M_transaksi->transaksi_bulanan('06')->row_array(),
                'jul'               => $this->M_transaksi->transaksi_bulanan('07')->row_array(),
                'ags'               => $this->M_transaksi->transaksi_bulanan('08')->row_array(),
                'sept'              => $this->M_transaksi->transaksi_bulanan('09')->row_array(),
                'okt'               => $this->M_transaksi->transaksi_bulanan('10')->row_array(),
                'nov'               => $this->M_transaksi->transaksi_bulanan('11')->row_array(),
                'des'               => $this->M_transaksi->transaksi_bulanan('12')->row_array(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/dashboard/administrator', $data);
            $this->load->view('layout_admin/footer');

            
        }

        
    }
    
?>