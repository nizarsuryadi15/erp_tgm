<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Gudang Controller
     * 
     * This controller handles the management of the warehouse, including stock management,
     * purchase orders, and inventory tracking.
     */

    class Gudang extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set('Asia/Jakarta');
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
        }

        public function index(){
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Stok Gudang Utama',
                'table'             => 'tbl_kategori',
                'bulanini'          => date('m'),
                'tampilData'        => $this->M_gudang->getStokgudang()->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'total_bahan'       => $this->db->get('tbl_bahan')->num_rows(),
                'total_produk'      => $this->db->get('tbl_product')->num_rows(),
                'total_masuk'       => $this->db->get('tbl_pembelian_detail')->num_rows(),
                'total_keluar'      => $this->db->get('tbl_pengambilan_detail')->num_rows(),
                'stok_minim'        => $this->M_gudang->stok_minim()->result(),    
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header',$data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/gudang/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function stok(){
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Stok Bahan Produksi',
                'table'             => 'tbl_kategori',
                'bulanini'          => date('m'),
                'tampilData'        => $this->M_gudang->getStokgudang()->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'total_bahan'       => $this->db->get('tbl_bahan')->num_rows(),
                'total_produk'      => $this->db->get('tbl_product')->num_rows(),
                'total_masuk'       => $this->db->get('tbl_pembelian_detail')->num_rows(),
                'total_keluar'      => $this->db->get('tbl_pengambilan_detail')->num_rows(),
                'stok_minim'        => $this->M_gudang->stok_minim()->result(),    
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header',$data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/gudang/stok', $data);
            $this->load->view('layout_admin/footer');
        }

        function DaftarPembelian()
        {
            $controller = $this->uri->segment(1);
            $userid = $this->session->userdata('id');

            // Ambil konfigurasi perusahaan dan hak akses
            $conf = [
                'perusahaan' => $this->db->get_where('tbl_perusahaan', [
                    'id_perusahaan' => $this->session->userdata('perusahaan_id')
                ])->row_array(),
                'hakakses' => $this->db->get_where('tbl_divisi', [
                    'divisi_id' => $this->session->userdata('level')
                ])->row_array(),
            ];

            // Siapkan data untuk view
            $data = [
                'controller'        => $controller,
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Pembelian Bahan',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_gudang->getbelibahan()->result(),
                'total_rows'        => $this->M_gudang->getbelibahan()->num_rows(),
                'bahan'            => $this->db->get('tbl_bahan')->result(),       
                'supplier'          => $this->db->get('tbl_supplier')->result(),
                'temp'              => $this->M_gudang->getTemp('tbl_temp_beli')->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),
                'level'             => $this->db->get_where('users', ['user_id' => $userid])->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            ];

            // Load view
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/bahan/daftarPembelian', $data);
            $this->load->view('layout_admin/footer');
        }

        function Add_barang_masuk(){
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Belanja Bahan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getDataBahan()->result(),
                'total_rows'    => $this->M_gudang->getDataBahan()->num_rows(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'supplier'      => $this->db->get('tbl_supplier')->result(),
                'temp'          => $this->M_gudang->getTemp('tbl_temp_beli')->result(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),  
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(), 
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(), 
                
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/gudang/add_barang_masuk', $data);
            $this->load->view('layout_admin/footer');
        }

        function DaftarPengambilan(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Barang Keluar',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getDataPengambilan()->result(),
                'total_rows'    => $this->M_gudang->getDataPengambilan()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(), 
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/bahan/daftarPengambilan', $data);
            $this->load->view('layout_admin/footer');
        }

        function PengambilanBahan(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Pengambilan Bahan',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_gudang->getDataBahan()->result(),
                'total_rows'        => $this->M_gudang->getDataBahan()->num_rows(),
                'bahan'             => $this->db
                                                ->select('tbl_bahan.*, (tbl_stok_gudang.stok_awal + tbl_stok_gudang.stok_tambah - tbl_stok_gudang.stok_kurang) as jumlah_stok')
                                                ->join('tbl_stok_gudang', 'tbl_bahan.bahan_id = tbl_stok_gudang.bahan_id')
                                                ->where('(tbl_stok_gudang.stok_awal + tbl_stok_gudang.stok_tambah - tbl_stok_gudang.stok_kurang) >', 0)
                                                ->get('tbl_bahan')->result(),
                
                'karyawan'          => $this->db->get('tbl_karyawan')->result(),
                'temp'              => $this->M_gudang->getTemp('tbl_temp_pengambilan')->result(),
                'cabang'            => $this->db->get('tbl_perusahaan')->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'karyawan'          => $this->db->get('tbl_karyawan')->result(),
                'gudang'            => $this->db->get('tbl_gudang')->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/gudang/PengambilanBahan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function stokopname()
        {
            $userid         = $this->session->userdata('id');
            $perusahaan_id  = $this->session->userdata('perusahaan_id');
            $divisi_id      = $this->session->userdata('level');
            $controller     = $this->uri->segment(1);
            $function       = $this->uri->segment(2);

            $this->form_validation->set_rules('bahan_id', 'Bahan', 'required');

            // Ambil konfigurasi umum
            $conf = [
                'perusahaan' => $this->db->get_where('tbl_perusahaan', ['id_perusahaan' => $perusahaan_id])->row_array(),
                'hakakses'   => $this->db->get_where('tbl_divisi', ['divisi_id' => $divisi_id])->row_array(),
            ];

            // Data umum yang selalu digunakan
            $data = [
                'controller'        => $controller,
                'function'          => $function,
                'title'             => 'Stok Opname',
                'hariini'           => date('Y-m-d'),
                'bulanini'          => date('Y-m'),
                'tampilData'        => $this->M_gudang->getDataStokOpname()->result(),
                'total_rows'        => $this->M_gudang->getDataStokOpname()->num_rows(),
                'bahan'             => $this->db->get('tbl_bahan')->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),
                'level'             => $this->db->get_where('users', ['user_id' => $userid])->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            ];

            // Jika form valid
            if ($this->form_validation->run()) {
                $bahan_id = $this->input->post('bahan_id', true);
                $data['getbahan'] = $this->M_gudang->getBahan($bahan_id)->result();
                $data['getRow']   = $this->M_gudang->getBahan($bahan_id)->num_rows();
            }

            // Load tampilan
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/gudang/son/dataSon', $data);
            $this->load->view('layout_admin/footer');
        }


        public function gudang_bahan(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Stok Gudang Bahan',
                'table'         => 'tbl_kategori',
                'bulanini'      => date('m'),
                'tampilData'    => $this->M_gudang->getGudangBahan()->result(),
                'total_rows'    => $this->M_gudang->getGudangBahan()->num_rows(),
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/bahan/stok_gudang_bahan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function dashboard(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Stok Gudang Utama',
                'table'         => 'tbl_kategori',
                'bulanini'      => date('m'),
                'tampilData'    => $this->M_gudang->getStokgudang()->result(),
                // 'total_rows'    => $this->M_gudang->getStokgudang()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),  
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),  
                
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('gudang/bahan/index', $data);
            $this->load->view('layout_admin/footer');
        }


        function laporan_barang_masuk(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Laporan Barang Masuk',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getbelibahan()->result(),
                'total_rows'    => $this->M_gudang->getbelibahan()->num_rows(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'supplier'      => $this->db->get('tbl_supplier')->result(),
                'temp'          => $this->M_gudang->getTemp('tbl_temp_beli')->result(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),   
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(), 
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/bahan/daftarPembelian', $data);
            $this->load->view('layout_admin/footer');
        }

        function laporan_barang_keluar(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Laporan Barang Keluar',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getDataPengambilan()->result(),
                'total_rows'    => $this->M_gudang->getDataPengambilan()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

           $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/bahan/daftarPengambilan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function syncronisasi_stok(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Syncronnisasi Stok Masuk',
                'table'         => 'tbl_kategori',
                'bulanini'      => date('m'),
                'tampilData'    => $this->M_gudang->stokjasa_masuk($this->session->userdata('perusahaan_id'))->result(),
                'total_rows'    => $this->M_gudang->getDataBahan()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'gudangmasuk'   => $this->M_gudang->stokjasa($this->session->userdata('perusahaan_id'))->num_rows(),
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('gudang/bahan/syncronisasi_stok', $data);
            $this->load->view('layout_admin/footer');
        }

        function syncronisasi_stok_action(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);

            $this->form_validation->set_rules('qty_real', 'Quanntity real', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
                redirect($controller.'/syncronisasi_stok');
            }
            else 
            {
                $bahanId            = $this->input->post('bahan_id');
                //print_r($bahanId);
                //cek stok bahan dari tabel stok bahan 
                $cekStok        = $this->M_gudang->getStokBahan($bahanId)->row_array();

               // print_r($cekStok);

                $where = [
                    'bahan_id'      => $bahanId,
                ];
                $updateStok = [
                    'stok_tambah'   => $cekStok['stok_tambah'] + $this->input->post('qty_real'),
                ];

                print_r($this->input->post('qty_real'));
                print_r($updateStok);

                $this->M_gudang->updateData('tbl_stok_bahan', $where, $updateStok);    

                $where1 = [
                    'pengambilan_id' => $this->input->post('pengambilan_id'),
                ];

                $update1 = [
                    'approve'   => '1',
                ];

                $this->M_gudang->updateData('tbl_pengambilan_detail', $where1, $update1);
             }
                
        
            $this->session->set_flashdata('success', 'Berhasil menambahkan data');
            redirect($controller.'/syncronisasi_stok');
            
            
        }


        public function reloadstok(){
            $userid             = $this->session->userdata('id');
            $controller     = $this->uri->segment(1);
            $stok_id        = $this->input->post('stok_id');
            $stokaktif      = $this->input->post('stokaktif');

            $where = array(
                'stok_id' => $stok_id
            );

            $update = array(
                'stok_awal'     => $stokaktif,
                'stok_tambah'   => 0,
                'stok_kurang'   => 0,
            );

            $this->M_gudang->updateData('tbl_stok_bahan', $where, $update);
            redirect($controller);
        }

        

        function detailbarangmasuk($id){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'pembelian'         => $this->uri->segment(3),
                'title'             => 'Detail Pembelian Bahan',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_gudang->getdetailPembelian($id)->result(),
                'getData'           => $this->M_gudang->getdetailPembelian($id)->row_array(),
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'logo'          => $perusahaan['logo'],
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

           $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/gudang/detailPembelian', $data);
            $this->load->view('layout_admin/footer');
        }

        function cetakPembelian($id){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Cetak Pembelian Bahan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getdetailPembelian($id)->result(),
                'getData'       => $this->M_gudang->getdetailPembelian($id)->row_array(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
            );

            //print_r($data['tampilData']);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('gudang/bahan/cetakPembelian', $data);
            $this->load->view('layout_admin/footer');
        }

        function getTambahan($bahanId){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Detail Pembelian Bahan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getbahanPembelian($bahanId)->result(),
                'getData'       => $this->M_gudang->getbahanPembelian($bahanId)->row_array(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/bahan/detailPembelianBahan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function getPengurangan($bahanId)
        {
            $userId     = $this->session->userdata('id');
            $controller = $this->uri->segment(1);

            $perusahaan = $this->db->get_where('tbl_perusahaan', [
                'id_perusahaan' => $this->session->userdata('perusahaan_id')
            ])->row_array();

            $hakAkses = $this->db->get_where('tbl_divisi', [
                'divisi_id' => $this->session->userdata('level')
            ])->row_array();

            $data = [
                'controller'    => $controller,
                'function'      => $this->uri->segment(2),
                'title'         => 'Detail Pengambilan Bahan',
                'table'         => 'tbl_kategori',
                'bahan'         => $this->db->get_where('tbl_bahan', ['bahan_id' => $bahanId])->result(),
                'level'         => $this->db->get_where('users', ['user_id' => $userId])->row_array(),
                'logo'          => $perusahaan['logo'],
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            ];

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/bahan/pengambilanbahan', $data);
            $this->load->view('layout_admin/footer');
        }


        

        function actionAdd(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            
            $add = array(
                'bahan_id'      => $this->input->post('bahan_id'),
                'qty'           => $this->input->post('qty'),
                'harga'         => $this->input->post('harga'),
            );
            print_r($add);

            $tambah = $this->db->insert('tbl_temp_beli', $add);

            if ($tambah) {
                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect($controller.'/belanjabahan');
            }
        }

        function deleteTempbeli($id){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $where = array(
                'temp_id' => $id
            );

            $this->M_gudang->deleteData('tbl_temp_beli', $where);
            redirect($controller.'/belanjabahan');
        }

        function deleteTempAmbil($id){
            $controller         = $this->uri->segment(1);
            $where = array(
                'temp_id' => $id
            );

            $this->M_gudang->deleteData('tbl_temp_pengambilan', $where);
            redirect($controller.'/PengambilanBahan');
        }

        function actionAddbelanja(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);

            $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
            $this->form_validation->set_rules('pembelian_tgl', 'Tanggal', 'required');
            $this->form_validation->set_rules('pembelian_total', 'Total', 'required');
            $this->form_validation->set_rules('no_faktur', 'No Faktur', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
                redirect($controller.'/belanjabahan');
            } else {
                $add = array(
                    'supplier_id'       => $this->input->post('supplier_id'),
                    'pembelian_tgl'     => $this->input->post('pembelian_tgl'),
                    'pembelian_total'   => $this->input->post('pembelian_total'),
                    'no_faktur'         => $this->input->post('no_faktur'),
                );

                $dataTemp       = $this->db->get('tbl_temp_beli')->result();
                $pembelianID    = $this->M_gudang->getLastId('tbl_pembelian','pembelian_id')->row_array();
                

                foreach ($dataTemp as $data) {
                    $addDetail = [
                        'pembelian_id'      => $pembelianID['pembelian_id']+1,
                        'bahan_id'          => $data->bahan_id,
                        'pemb_qty'          => $data->qty,
                        'pemb_harga'        => $data->harga,
                    ];

                    //insert into tabel pembelian
                    $this->db->insert('tbl_pembelian_detail', $addDetail);

                    //cek stok bahan dari tabel stok bahan 
                    $cekStok        = $this->M_gudang->getStok($addDetail['bahan_id'])->row_array();
        
                    $where = [
                        'bahan_id'      => $addDetail['bahan_id'],
                    ];

                    $updateStok = [
                        'stok_tambah'   => $cekStok['stok_tambah'] + $data->qty,
                    ];

                    $this->M_gudang->updateData('tbl_stok_gudang', $where, $updateStok);

                    
                }
                
                $tambah = $this->db->insert('tbl_pembelian', $add);
                $hapus  = $this->db->empty_table('tbl_temp_beli');
        
                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect($controller.'/belanjabahan');
            
            }
        }

        function actionAddpengambilan(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);

            $this->form_validation->set_rules('karyawan_id', 'Karyawan', 'required');
            $this->form_validation->set_rules('pengambilan_tgl', 'Tanggal', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
                redirect('gudang/pengambilanbahan');
            } 
            else 
            {
                $add = array(
                    'karyawan_id'           => $this->input->post('karyawan_id'),
                    'pengambilan_tgl'       => $this->input->post('pengambilan_tgl'),
                    'gudang_id'             => $this->input->post('gudang_id'),
                );

                $dataTemp       = $this->db->get('tbl_temp_pengambilan')->result();
                $pengambilanID  = $this->M_gudang->getLastId('tbl_pengambilan','pengambilan_id')->row_array();
                

                foreach ($dataTemp as $data) {
                    $addDetail = [
                        'pengambilan_id'    => $pengambilanID['pengambilan_id']+1,
                        'bahan_id'          => $data->bahan_id,
                        'pengambilan_qty'   => $data->qty,
                    ];

                    $this->db->insert('tbl_pengambilan_detail', $addDetail);
                
                    $cekStok        = $this->M_gudang->getStok($addDetail['bahan_id'])->row_array();
                    $stokaktif      = $cekStok['stok_awal'] + $cekStok['stok_tambah'] - $cekStok['stok_kurang'];

                    $where = [
                        'bahan_id'      => $addDetail['bahan_id'],
                    ];

                    $updateStok = [
                        'stok_kurang'   => $cekStok['stok_kurang'] + $data->qty,
                    ];

                    $this->M_gudang->updateData('tbl_stok_gudang', $where, $updateStok);
                }
                
                $tambah = $this->db->insert('tbl_pengambilan', $add);
                $hapus  = $this->db->empty_table('tbl_temp_pengambilan');
        
                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect('gudang/barang-keluar');
            
            }
        }

        

        function actionAddTemp(){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $bahanid            = $this->input->post('bahan_id');

            $cekstokgudang      = $this->M_gudang->getStok($bahanid)->row_array();
            $stokgudang         = $cekstokgudang['stok_awal'] + $cekstokgudang['stok_tambah'] - $cekstokgudang['stok_kurang'];
            
            if ($this->input->post('qty') > $stokgudang) {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi');
                redirect($controller.'/PengambilanBahan');
            }
            else{
                $add = array(
                    'bahan_id'      => $this->input->post('bahan_id'),
                    'qty'           => $this->input->post('qty'),
                );
    
                $tambah = $this->db->insert('tbl_temp_pengambilan', $add);
    
                if ($tambah) {
                    $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                    redirect($controller.'/PengambilanBahan');
                }
            }
        }

        function action_add_son(){
            $this->form_validation->set_rules('son_real', 'son_real', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                redirect('gudang/stokopname');
            }
            else
            {
                $bahan_id   = $this->input->post('bahan_id');
                $son_real   = $this->input->post('son_real');
                $son_tgl    = $this->input->post('son_tgl');


                $cekdatason = $this->M_gudang->cekSon($bahan_id, $son_tgl)->num_rows();

                if ($cekdatason > 0) {
                    $this->session->set_flashdata('error', 'Data sudah ada');
                    redirect('gudang/stokopname');
                }
                else{
                    $add = array(
                        'bahan_id'      => $this->input->post('bahan_id'),
                        'son_real'      => $this->input->post('son_real'),
                        'son_tgl'       => $this->input->post('son_tgl'),
                        'son_aplikasi'  => $this->input->post('son_aplikasi'),
                    );
                    
                    $tambah = $this->db->insert('tbl_stok_opname', $add);
                    if ($tambah) {
                        $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                        redirect('gudang/stokopname');
                    }
                }

                
            }
        }

        function cetakSon($bulanini){
            $userid             = $this->session->userdata('id');
            $data = array(
                'tampilData'    => $this->M_gudang->getDataStokOpname()->result(),
                'total_rows'    => $this->M_gudang->getDataStokOpname()->num_rows(),
                'bulanini'      => date('m'),
            );
            $this->load->view('admin/gudang/son/cetakson', $data);
        }

        function actionAddSupplier(){
            $userid             = $this->session->userdata('id');
            $supplier_nama      = $this->input->post('supplier_nama');
            $supplier_alamat    = $this->input->post('supplier_alamat');
            $supplier_nohp      = $this->input->post('supplier_nohp');
            $supplier_email     = $this->input->post('supplier_email');

            $add = array(
                'supplier_nama'   => $supplier_nama,
                'supplier_alamat' => $supplier_alamat,
                'supplier_nohp'   => $supplier_nohp,
                'supplier_email'  => $supplier_email,
            );

            $tambah = $this->db->insert('tbl_supplier', $add);
            if ($tambah) {
                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect('gudang/BelanjaBahan');
            }
        }

        function barang_masuk(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Barang Masuk',
                'table'         => 'tbl_kategori',
                'bulanini'      => date('m'),
                'tampilData'    => $this->M_gudang->getbelibahan()->result(),
                'total_rows'    => $this->M_gudang->getbelibahan()->num_rows(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'supplier'      => $this->db->get('tbl_supplier')->result(),
                'temp'          => $this->M_gudang->getTemp('tbl_temp_beli')->result(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/gudang/daftarPembelian', $data);
            $this->load->view('layout_admin/footer');
        }

        function action_add_barang_masuk(){
            $data = array(
                'bahan_id'      => $this->input->post('bahan_id'),
                'qty'           => $this->input->post('qty'),
            );
            $tambah = $this->db->insert('tbl_temp_beli', $data);
            if ($tambah) {
                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect('gudang/add_barang_masuk');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
                redirect('gudang/add_barang_masuk');
        
            }
        }

        function deletePembelian($id){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $where = array(
                'pembelian_id' => $id
            );

            $this->M_gudang->deleteData('tbl_pembelian', $where);
            redirect($controller.'/barang_masuk');
        }

        function action_barang_masuk(){
            $no_faktur      = $this->input->post('no_faktur');
            $supplier_id    = $this->input->post('supplier_id');
            $pembelian_tgl  = $this->input->post('pembelian_tgl');

            $insert = $this->db->insert('tbl_pembelian', [
                'no_faktur'         => $no_faktur,
                'supplier_id'       => $supplier_id,
                'pembelian_tgl'     => $pembelian_tgl,
            ]);

            if ($insert) {
                $pembelian_id = $this->db->insert_id();
                $tempData = $this->db->get('tbl_temp_beli')->result();

                foreach ($tempData as $data) {
                    $detail = [
                        'pembelian_id'  => $pembelian_id,
                        'bahan_id'      => $data->bahan_id,
                        'pemb_qty'      => $data->qty,
                       
                    ];
                    $this->db->insert('tbl_pembelian_detail', $detail);
                }
                // Update stok bahan
                foreach ($tempData as $data) {
                    $cekStok        = $this->M_gudang->getStok($data->bahan_id)->row_array();
                    $where = [
                        'bahan_id'      => $data->bahan_id,
                    ];
                    $updateStok = [
                        'stok_tambah'   => $cekStok['stok_tambah'] + $data->qty,
                    ];      
                    $this->M_gudang->updateData('tbl_stok_gudang', $where, $updateStok);
                }

                // Hapus data dari tabel sementara
                $this->db->empty_table('tbl_temp_beli');

                $this->session->set_flashdata('success', 'Berhasil menambahkan data');
                redirect('gudang/barang_masuk');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data');
                redirect('gudang/barang_masuk');
            }
        }

        function updateHarga(){
            $pemb_detail_id     = $this->input->post('pemb_detail_id');
            $harga              = $this->input->post('pemb_harga');
            $pembelian_id       = $this->input->post('pembelian_id');

            $where = array(
                'pemb_detail_id' => $pemb_detail_id
            );

            print_r($where);

            $update = array(
                'pemb_harga' => $harga
            );

            print_r($update);   

            $this->db->update('tbl_pembelian_detail', $update,$where);
            redirect('gudang/detailbarangmasuk/'.$pembelian_id);
        }

        function barang_keluar(){
                $userid             = $this->session->userdata('id');
                $table              = 'tbl_bahan';
                $controller         = $this->uri->segment(1);
                $conf  = array(
                    'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                    'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
                );

                $data = array(
                    'controller'        => $this->uri->segment(1),
                    'function'          => $this->uri->segment(2),
                    'title'             => 'Barang Keluar',
                    'table'             => 'tbl_kategori',
                    'bulanini'          => date('m'),
                    'tampilData'        => $this->M_gudang->getDataPengambilan()->result(),
                    'total_rows'        => $this->M_gudang->getDataPengambilan()->num_rows(),
                    'logo'              => $conf['perusahaan']['logo'],
                    'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                    'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                    'menu'              => $this->db->get('menu')->result(),
                    'submenu'           => $this->M_master->getmenu($controller)->result(),
                    
                );

            $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/top_header');
                $this->load->view('layout_admin/sidebar', $data);
                
                $this->load->view('admin/gudang/daftarPengambilan', $data);
                $this->load->view('layout_admin/footer');
        }

        function action_add_barang_keluar(){
            $bahan_id = $this->input->post('bahan_id');
            $qty = $this->input->post('qty');

            // Cek stok gudang
            $stok = $this->M_gudang->getStok($bahan_id)->row_array();
            $stok_gudang = 0;
            if ($stok) {
                $stok_gudang = $stok['stok_awal'] + $stok['stok_tambah'] - $stok['stok_kurang'];
            }

            if ($qty > $stok_gudang) {
                $this->session->set_flashdata('error', 'Stok tidak mencukupi');
                redirect('gudang/tambah-pengiriman');
                return;
            }

            $data = array(
                'bahan_id' => $bahan_id,
                'qty' => $qty
            );

            $this->db->insert('tbl_temp_pengambilan', $data);
            redirect('gudang/tambah-pengiriman');
        }

        function deletePengambilan($id){
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $where = array(
                'pengambilan_id' => $id
            );

            $this->M_gudang->deleteData('tbl_pengambilan', $where);
            redirect($controller.'/barang_keluar');
        }

        function monitoring(){
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_bahan';
            $controller         = $this->uri->segment(1);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Monitoring Stok Bahan',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_gudang->getDataBahan()->result(),
                'total_rows'    => $this->M_gudang->getDataBahan()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),    
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                'bulanini'      => date('m'),
                'monitoring'    => $this->M_gudang->getMonitoringStok()->result(),
                
            );

           $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/gudang/monitoring', $data);
            $this->load->view('layout_admin/footer');
        }

    }
   
    
    
?>