<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Keuangan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_transaksi');
            }
            // $this->load->library('rajaongkir');
        }

    public function index(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $menu               = $this->uri->segment(2);
            print_r($menu);
            $bulanan            = date('Y-m');
            $harian             = date('Y-m-d');
            $userid = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => 'Dashboard',
                'title'             => 'Dashboard Keuangan',
                'content'           => 'dashboard/index',
                'perusahaan'        => $perusahaan,
                'total_job'         => $this->db->get('tbl_flow_diagram')->num_rows(),
                'total_produksi'    => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Masuk Proses Produksi'))->num_rows(),
                'total_done'        => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Produksi Selesai, Barang di Bagian PB'))->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),


                //bulanan
                'grandtotal'        => $this->M_transaksi->getTotalTrx($bulanan)->row_array(),
                'total_cash'        => $this->M_transaksi->getcashbulan()->row_array(),
                'total_piutang'     => $this->M_transaksi->getpiutangbulan()->row_array(),
                'total_transfer'    => $this->M_transaksi->gettransferbulan()->row_array(),
                'total_edc'         => $this->M_transaksi->getedcbulan()->row_array(),
                'total_ewallet'     => $this->M_transaksi->getewalletbulan()->row_array(),
                
                //harian
                'grandtotalharian'      => $this->M_transaksi->getTotalTrx($harian)->row_array(),
                'total_cashharian'      => $this->M_transaksi->getcashharian()->row_array(),
                'total_piutangharian'   => $this->M_transaksi->getpiutangharian()->row_array(),
                'total_tf_harian'       => $this->M_transaksi->gettransferharian()->row_array(),
                'total_edc_harian'      => $this->M_transaksi->getedcharian()->row_array(),
                'total_ewallet_harian'  => $this->M_transaksi->getewalletharian()->row_array(),

                //Pengeluaran           
                'pengeluaran_harian'    => $this->M_transaksi->pengeluarantotal($harian)->row_array(),
                'pengeluaran_bulanan'   => $this->M_transaksi->pengeluarantotal($bulanan)->row_array(),

            
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/keuangan/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function legger(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $userid = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Buku Besar Bulanan',
                'table'         => 'tbl_kategori',
                'bulan'         => date('M Y'),
                
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),

            );

            $tanggal_mulai          =   $this->input->get('mulai');
            $tanggal_selesai        =   $this->input->get('selesai');
            $data['legger']         =   $this->M_transaksi->get_legger($tanggal_mulai, $tanggal_selesai)->result();
            
    
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/keuangan/legger', $data);
            $this->load->view('layout_admin/footer');
            
            
        }
        
        public function laporan_periode_keuangan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $userid = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Break Event Point',
                'table'         => 'tbl_kategori',
                
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),

            );

            if ($this->input->post('set')){
                $tanggal_awal           = $this->input->post('tgl_awal');
                $tanggal_akhir          = $this->input->post('tgl_akhir');
                $data['tampilData']     = $this->M_transaksi->getPiutang()->result();
                $data['total_rows']     = $this->M_transaksi->getPenjualan()->num_rows();
                $data['getkasir']       = $this->db->get_where('tbl_user', ['divisi_id' => '1'])->result();
                $data['hariini']        = date('Y-m-d');

                $data['rekening']       = $this->db->get('tbl_rekening')->result();
                $data['edc']            = $this->db->get('tbl_mesin_edc')->result();
                $data['ewallet']        = $this->db->get('tbl_ewallet')->result();
                $data['pemasukan']      = $this->M_transaksi->getPemasukan($tanggal_awal, $tanggal_akhir)->result();
                $data['transfer']       = $this->M_transaksi->getMetodeBayar($tanggal_awal, $tanggal_akhir,'bayar_transfer')->result();
                // $data['debit']          = $this->M_transaksi->getMetodeBayar($tanggal_awal, $tanggal_akhir,'bayar_debit')->result();
                $data['cash']           = $this->M_transaksi->totalCash($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran')->row_array();
                $data['cashpiutang']    = $this->M_transaksi->totalCash($tanggal_awal, $tanggal_akhir,'tbl_pembayaran_piutang')->row_array();
                $data['tgl_awal']       = $tanggal_awal;
                $data['tgl_akhir']      = $tanggal_akhir;
                // $data['total_pemasukan'] = $this->M_transaksi->totalPemasukan($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran')->row_array();
                // // $data['total_pemasukan_piutang'] = $this->M_transaksi->totalPemasukan($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran_piutang')->row_array();
                $data['kategori']      = $this->db->get('tbl_kategori_pengeluaran')->result();
            

                $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/top_header');
                $this->load->view('layout_admin/sidebar', $data);
                // $this->load->view('layout_admin/top_bar');
                $this->load->view('admin/keuangan/rekap_laporan_periode', $data);
                $this->load->view('layout_admin/footer');
            }else{
                $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/top_header');
                $this->load->view('layout_admin/sidebar', $data);
                // $this->load->view('layout_admin/top_bar');
                $this->load->view('admin/keuangan/rekap_laporan_periode', $data);
                $this->load->view('layout_admin/footer');
            }
            
        }

        

        public function detail($kode){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pemesanan',
                'table'         => 'tbl_kategori',
                'nospk'         => $nospk,
                'getdata'       => $this->M_transaksi->totalPiutangKonsumen($kode)->row_array(),
                'getdetail'     => $this->M_transaksi->getPiutangKonsumen($kode)->result(),
                'getpiutang'    => $this->M_transaksi->getPiutangKonsumen($kode)->row_array(),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),
                'kasir_id'      => $user,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('piutang/detail', $data);
            $this->load->view('layout_admin/footer');
        }

        public function bayar($nospk){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pemesanan',
                'table'         => 'tbl_kategori',
                'nospk'         => $nospk,
                'getpiutang'    => $this->M_transaksi->getPiutangSPK($nospk)->row_array(),
                'getdata'       => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'getdetail'     => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),
                'kasir_id'      => $user,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('piutang/bayar', $data);
            $this->load->view('layout_admin/footer');
        }

        function action_bayar(){

            $add_bayar = array(
                // 'nospk'                 => $this->input->post('nospk'),
                'konsumen_id'           => $this->input->post('konsumen_id'),
                'pembayaran_tgl'        => $this->input->post('pembayaran_tgl'),
                'pembayaran_jam'        => $this->input->post('pembayaran_jam'),
                'bayar_tunai'           => $this->input->post('bayar_tunai'),
                'bayar_debit'           => $this->input->post('bayar_debit'),
                'id_edc'                => $this->input->post('id_edc'),
                'nomor_debit'           => $this->input->post('nomor_debit'),
                'bayar_transfer'        => $this->input->post('bayar_transfer'),
                'rekening_id'           => $this->input->post('rekening_id'),
                'bayar_ewallet'         => $this->input->post('bayar_ewallet'),
                'ewallet_id'            => $this->input->post('ewallet_id'),
                'kasir_id'              => $this->session->userdata('id'),
                'piutang_id'            => $this->input->post('piutang_id'),
            );

            $bayar_piutang  = $this->input->post('bayar_tunai') + $this->input->post('bayar_debit') + $this->input->post('bayar_transfer') + $this->input->post('bayar_ewallet');
            
            $cekpiutangID   = $this->M_transaksi->getPiutangSPK($this->input->post('nospk'))->row_array();
            $cekpiutang     = $cekpiutangID['piutang_total'];

            $sisa           = $cekpiutang - $bayar_piutang;
            if ($sisa == 0) {
                $status = 'Lunas';
            }else{
                $status = 'Belum Lunas';
            }

            $update = array(
                'piutang_bayar'         => $bayar_piutang,
                'piutang_status'        => 'Lunas',
                'piutang_status'        => $status,
                'piutang_sisa'          => $sisa,
            );

            $update_piutang =   $this->db->update('tbl_piutang', $update, array('id' => $this->input->post('piutang_id')));
            $insert_bayar = $this->db->insert('tbl_pembayaran_piutang',$add_bayar);
            
            if (($update_piutang == true) AND ($insert_bayar == true)){
                $this->session->set_flashdata('success','Data Berhasil Dikirim');
                redirect('piutang');
            }
            
        }

        function cetak_laporan_pemasukan($tgl_awal, $tgl_akhir){
            $tanggal_awal           = $tgl_awal;
            $tanggal_akhir          = $tgl_akhir;
        
            $data['rekening']       = $this->db->get('tbl_rekening')->result();
            $data['edc']            = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']        = $this->db->get('tbl_ewallet')->result();
            $data['pemasukan']      = $this->M_transaksi->getPemasukan($tanggal_awal, $tanggal_akhir)->result();
            $data['transfer']       = $this->M_transaksi->getMetodeBayar($tanggal_awal, $tanggal_akhir,'bayar_transfer')->result();
            $data['debit']          = $this->M_transaksi->getMetodeBayar($tanggal_awal, $tanggal_akhir,'bayar_debit')->result();
            $data['cash']           = $this->M_transaksi->totalCash($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']    = $this->M_transaksi->totalCash($tanggal_awal, $tanggal_akhir,'tbl_pembayaran_piutang')->row_array();
            $data['tgl_awal']       = $tanggal_awal;
            $data['tgl_akhir']      = $tanggal_akhir;
            $data['total_pemasukan'] = $this->M_transaksi->totalPemasukan($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang'] = $this->M_transaksi->totalPemasukan($tanggal_awal, $tanggal_akhir, 'tbl_pembayaran_piutang')->row_array();

            $this->load->view('keuangan/cetak_laporan_pemasukan', $data);
        }

        // Transaksi Harian

        function transaksi_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Per '.date_indo($hariini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getPemasukanHarian($hariini)->result(),
                'hariini'       => $hariini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashharian($hariini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashharian($hariini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_pemasukan_harian', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_cash_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Cash Per '.date_indo($hariini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpendapatan($hariini, 'bayar_tunai')->result(),
                'hariini'       => $hariini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashharian($hariini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashharian($hariini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_cash_harian', $data);
            $this->load->view('layout_admin/footer');
        }

         function transaksi_transfer_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Transfer Bank Per '.date_indo($hariini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->gettransfer($hariini,'bayar_transfer')->result(),
                'hariini'       => $hariini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashharian($hariini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashharian($hariini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_transfer_harian', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_edc_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Transaksi EDC Harian Per '.date_indo($hariini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getbayaredcbulan($hariini,'bayar_debit')->result(),
                'hariini'       => $hariini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashharian($hariini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashharian($hariini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_edc_harian', $data);
            $this->load->view('layout_admin/footer');
        }


        function transaksi_ewallet_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Per '.date_indo($hariini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getbayaewalletcbulan($hariini,'bayar_ewallet')->result(),
                'hariini'       => $hariini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarharian($hariini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashharian($hariini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashharian($hariini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanharian($hariini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_ewallet_harian', $data);
            $this->load->view('layout_admin/footer');
        }


        // Transaksi Bulanan

        function pemasukan_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Per '.$bulanini,
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpemasukanbulanan($bulanini)->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            // print_r($data['pemasukan']);

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashbulanan($bulanini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('keuangan/rekap_pemasukan_bulanan', $data);
            $this->load->view('layout_admin/footer');
            
        }

        function transaksi_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpemasukanbulanan($bulanini)->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            // print_r($data['pemasukan']);

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashbulanan($bulanini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/keuangan/rekap_pemasukan_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_cash_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Metode Cash Bulan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpendapatan($bulanini,'bayar_tunai')->result(),
                'bulanini'      => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            // print_r($data['pemasukan']);

            $data['cash']                       = $this->M_transaksi->totalCashbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashbulanan($bulanini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            
            $this->load->view('admin/keuangan/rekap_cash_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_transfer_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan Transfer Bulan'.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->gettransfer($bulanini,'bayar_transfer')->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            // print_r($data['pemasukan']);

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_transfer')->result();
            

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_transfer_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_edc_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getbayaredcbulan($bulanini,'bayar_debit')->result(),
                'bulanini'      => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashbulanan($bulanini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_edc_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function transaksi_ewallet_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pembayaran E-Wallet Bulan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getbayaewalletcbulan($bulanini,'bayar_ewallet')->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $data['rekening']                   = $this->db->get('tbl_rekening')->result();
            $data['edc']                        = $this->db->get('tbl_mesin_edc')->result();
            $data['ewallet']                    = $this->db->get('tbl_ewallet')->result();
            $data['transfer']                   = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_transfer')->result();
            $data['debit']                      = $this->M_transaksi->getMetodeBayarbulanan($bulanini,'bayar_debit')->result();
            $data['cash']                       = $this->M_transaksi->totalCashbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['cashpiutang']                = $this->M_transaksi->totalCashbulanan($bulanini,'tbl_pembayaran_piutang')->row_array();
            $data['total_pemasukan']            = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran')->row_array();
            $data['total_pemasukan_piutang']    = $this->M_transaksi->totalPemasukanbulanan($bulanini, 'tbl_pembayaran_piutang')->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_ewallet_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function laporan_pajak_bulanan(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpemasukanbulanan($bulanini)->result(),
                'lap_pajak'     => $this->M_transaksi->getpajakbulanan($bulanini)->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/laporan_pajak_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

         function export_laporan_pajak(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $bulanini           = date('Y-m');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pemasukan '.date_indo($bulanini),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'pemasukan'     => $this->M_transaksi->getpemasukanbulanan($bulanini)->result(),
                'lap_pajak'     => $this->M_transaksi->getpajakbulanan($bulanini)->result(),
                'bulanini'       => $bulanini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

           
            $this->load->view('admin/keuangan/export_excel_laporan_pajak', $data);
            
        }

        function pengeluaran_harian(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $user               = $this->session->userdata('id');
            $hariini            = date('Y-m-d');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Rekap Pengeluaran Harian',
                'hariini'           => $hariini,
                'pengeluaran'       => $this->M_transaksi->getpengeluaranharian($hariini)->result(),
                'kategori'          => $this->db->get('tbl_kategori_pengeluaran')->result(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'jml_pengeluaran'   => $this->M_transaksi->pengeluaran_harian($hariini)->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            // print_r($data['jml_pengeluaran']);

        
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_pengeluaran_harian', $data);
            $this->load->view('layout_admin/footer');
        }

        function pengeluaran_bulanan(){
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $bulanini            = date('m');
            $tahunini            = date('Y');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'bulanini'      => $this->db->get_where('tbl_bulan', array('bulan_kode' => $bulanini))->row_array(),
                'tahunini'      => $tahunini,
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Rekap Pengeluaran Bulanan',
                'hariini'       => $hariini,
                'pengeluaran'   => $this->M_transaksi->getpengeluaranbulanan($bulanini, $tahunini)->result(),
                'kategori'      => $this->db->get('tbl_kategori_pengeluaran')->result(),
                'bulanini'      => $bulanini,
                'tahunini'      => $tahunini,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/rekap_pengeluaran_bulanan', $data);
            $this->load->view('layout_admin/footer');
        }

        function add_pengeluaran_harian(){
            $add = array(
                'pengeluaran_tgl'           => date('Y-m-d'),
                'kategori_pengeluaran_id'   => $this->input->post('kategori'),
                'pengeluaran_jumlah'        => $this->input->post('jumlah'),
                'pengeluaran_detail'        => $this->input->post('keterangan'),
                'pengeluaran_penerima'      => $this->input->post('penerima'),
                'user_id'                   => $this->session->userdata('id'),
                'perusahaan_id'             => $this->session->userdata('perusahaan_id'),
            );

            print_r($add);
            $success = $this->db->insert('tbl_pengeluaran_harian', $add);
            if($success){
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
                redirect('keuangan/pengeluaran_harian');
            }
        }

        function add_pengeluaran_bulanan(){
            $add = array(
                'pengeluaran_bulan'         => date('m'),
                'pengeluaran_tahun'         => date('Y'),
                'kategori_pengeluaran_id'   => $this->input->post('kategori'),
                'pengeluaran_jumlah'        => $this->input->post('jumlah'),
                'pengeluaran_detail'        => $this->input->post('keterangan'),
                'pengeluaran_penerima'      => $this->input->post('penerima'),
                'user_id'                   => $this->session->userdata('id'),
            );

            print_r($add);
            $success = $this->db->insert('tbl_pengeluaran_bulanan', $add);
            if($success){
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
                redirect('keuangan/pengeluaran_bulanan');
            }
        }

        // Piutang

        public function piutang(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Piutang Konsumen',
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getPiutang()->result(),
                'total_rows'    => $this->M_transaksi->getPenjualan()->num_rows(),
                'total_trx'     => $this->M_transaksi->getTotalPiutang()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/piutang/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function hutang(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Hutang Perusahaan',
                'table'         => 'tbl_kategori',
                // 'tampilData'    => $this->M_transaksi->getPiutang()->result(),
                'total_rows'    => $this->M_transaksi->getPenjualan()->num_rows(),
                // 'total_trx'     => $this->M_transaksi->getTotalPiutang()->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/hutang/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function detail_piutang($kode){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pemesanan',
                'table'         => 'tbl_kategori',
                'nospk'         => $nospk,
                'getdata'       => $this->M_transaksi->totalPiutangKonsumen($kode)->row_array(),
                'getdetail'     => $this->M_transaksi->getPiutangKonsumen($kode)->result(),
                'getpiutang'    => $this->M_transaksi->getPiutangKonsumen($kode)->row_array(),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),
                'kasir_id'      => $user,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/piutang/detail', $data);
            $this->load->view('layout_admin/footer');
        }

        public function bayar_piutang($nospk){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $user               = $this->session->userdata('id');
            $perusahaan         = $this->session->userdata('perusahaan_id');
            $userid             = $this->session->userdata('id');

            
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pemesanan',
                'table'         => 'tbl_kategori',
                'nospk'         => $nospk,
                'getpiutang'    => $this->M_transaksi->getPiutangSPK($nospk)->row_array(),
                'getdata'       => $this->M_transaksi->getPiutangSPK($nospk)->row_array(),
                'getdetail'     => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),
                'kasir_id'      => $user,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan' => $perusahaan))->row_array(),
                'pembayaran'    => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/keuangan/piutang/bayar', $data);
            $this->load->view('layout_admin/footer');
        }

        function action_bayar_piutang(){
            $nospk  = $this->input->post('nospk');

            $add_bayar = array(
                // 'nospk'                 => $this->input->post('nospk'),
                'konsumen_id'           => $this->input->post('konsumen_id'),
                'pembayaran_tgl'        => $this->input->post('pembayaran_tgl'),
                'pembayaran_jam'        => $this->input->post('pembayaran_jam'),
                'bayar_tunai'           => $this->input->post('bayar_tunai'),
                'bayar_debit'           => $this->input->post('bayar_debit'),
                'id_edc'                => $this->input->post('id_edc'),
                'nomor_debit'           => $this->input->post('nomor_debit'),
                'bayar_transfer'        => $this->input->post('bayar_transfer'),
                'rekening_id'           => $this->input->post('rekening_id'),
                'bayar_ewallet'         => $this->input->post('bayar_ewallet'),
                'ewallet_id'            => $this->input->post('ewallet_id'),
                'kasir_id'              => $this->session->userdata('id'),
                'piutang_id'            => $this->input->post('piutang_id'),
                'perusahaan_id'         => $this->session->userdata('perusahaan_id'),
            );

            $bayar_piutang  = $this->input->post('bayar_tunai') + $this->input->post('bayar_debit') + $this->input->post('bayar_transfer') + $this->input->post('bayar_ewallet');
            
            $cekpiutangID   = $this->M_transaksi->getPiutangSPK($this->input->post('nospk'))->row_array();
            $cekpiutang     = $cekpiutangID['piutang_total'];

            $bayarna        = $cekpiutangID['piutang_bayar']+$bayar_piutang;

            $sisa           = $cekpiutang - $bayarna;
            

            if ($sisa == 0) {
                $status = 'Lunas';
            }else{
                $status = 'Belum Lunas';
            }

            $update = array(
                'piutang_bayar'         => $bayarna,
                'piutang_status'        => 'Lunas',
                'piutang_status'        => $status,
                'piutang_sisa'          => $sisa,
            );

            $updatebayar = array(
                'piutang'               => $sisa,
                // 'bayar_tunai'           => $this->input->post('bayar_tunai'),
                // 'bayar_debit'           => $this->input->post('bayar_debit'),
                // 'id_edc'                => $this->input->post('id_edc'),
                // 'nomor_debit'           => $this->input->post('nomor_debit'),
                // 'bayar_transfer'        => $this->input->post('bayar_transfer'),
                // 'rekening_id'           => $this->input->post('rekening_id'),
                // 'bayar_ewallet'         => $this->input->post('bayar_ewallet'),
            );

            $update_piutang             =   $this->db->update('tbl_piutang', $update, array('id' => $this->input->post('piutang_id')));
            $update_pembayaran          =   $this->db->update('tbl_pembayaran',$updatebayar, array('nospk'=>$this->input->post('nospk')));
            $insert_bayar               =   $this->db->insert('tbl_pembayaran_piutang',$add_bayar);
            
            if (($update_piutang == true) AND ($insert_bayar == true)){
                $this->session->set_flashdata('success','Data Berhasil Dikirim');
                redirect('keuangan/piutang');
            }
            
        }
    }