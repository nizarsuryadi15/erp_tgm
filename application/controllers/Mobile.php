<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Mobile extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');    
            }
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->load->model('Absensi_model');
            $this->load->model('Produk_model');
            $this->load->model('M_gudang');
        }

        function index(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $tanggal            = date('Y-m-d');
            $jamSekarang        = date('H:i');
            // print_r($karyawan);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
                'userid'        => $this->db->get_where('users', array('user_id'=> $this->session->userdata('id')))->row_array(),    
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $perusahaan,
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'cekabsen'          => $this->db->get_where('absensi', ['karyawan_id' => $karyawan, 'tanggal' => date('Y-m-d')])->row_array(),
                'hasilcek'          => $this->db->get_where('absensi', ['karyawan_id' => $karyawan, 'tanggal' => date('Y-m-d')])->num_rows(),
                'success'           => $this->db
                                    ->where('karyawan_id', $karyawan)
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('jam_masuk IS NOT NULL AND jam_masuk != "00:00:00"', null, false)
                                    ->where('jam_pulang IS NOT NULL AND jam_pulang != "00:00:00"', null, false)
                                    ->get('absensi')
                                    ->num_rows(),

                );
            // 1. Cek hari libur dari tabel hari_libur
            $isLibur = $this->db
                        ->where('tanggal', $tanggal)
                        ->get('hari_libur')
                        ->num_rows() > 0;

            $isMinggu               = date('w', strtotime($tanggal)) == 0;
            $isJamKerja             = ($jamSekarang >= '07:00' && $jamSekarang <= '19:00');
            $data['boleh_absen']    = !$isLibur && !$isMinggu && $isJamKerja;
            
            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/index', $data);
            $this->load->view('admin/mobile/footer', $data);
            $this->load->view('layout_admin/alert', $data);
            
        }

        public function lembur(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/lembur', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function sakit(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/sakit', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function laporan(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'absensi'           => $this->Absensi_model->get_absensi_hari_ini(),
                'lembur'            => $this->M_master->karyawan_lembur()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/laporan', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function profile(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'title'             => 'Profile',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'profile'           => $this->M_profile->getprofile()->row_array(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/profile', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function reset_pass(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/ubah_password', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function ajax_list() {
        
            $keyword    = $this->input->get('keyword');
            $page       = $this->input->get('page');
            $limit      = 6;

            // Pastikan page berupa angka
            $page = is_numeric($page) && $page > 0 ? $page : 1;
            $start = ($page - 1) * $limit;

            $config['base_url']             = base_url('mobile/product');
            $config['total_rows']           = $this->Produk_model->count_all($keyword);
            $config['per_page']             = $limit;
            $config['use_page_numbers']     = TRUE;
            $config['attributes']           = ['data-ci-pagination-page' => ''];

            // Pagination HTML
            $config['full_tag_open']        = '<ul class="pagination justify-content-center">';
            $config['full_tag_close']       = '</ul>';
            $config['num_tag_open']         = '<li class="page-item"><a class="page-link" href="#">';
            $config['num_tag_close']        = '</a></li>';
            $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']        = '</span></li>';
            $config['next_tag_open']        = '<li class="page-item"><a class="page-link" href="#">';
            $config['next_tag_close']       = '</a></li>';
            $config['prev_tag_open']        = '<li class="page-item"><a class="page-link" href="#">';
            $config['prev_tag_close']       = '</a></li>';

            $this->pagination->initialize($config);

            $data['produk']         = $this->Produk_model->get_paginated($limit, $start, $keyword);
            $data['pagination']     = $this->pagination->create_links();

            // Kembali ke partial view
            $this->load->view('admin/mobile/product_list', $data);

        }


        public function product(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'produk'           => $this->db->get('tbl_product')->result(),
                
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/product', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function produk_detail($id){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'produk'           => $this->db->get('tbl_product')->result(),
                'getProduct'        => $this->M_master->getProduct($kode)->row_array(),
                'getHarga'          => $this->M_master->getHarga($kode)->result(),
                'jmlHarga'          => $this->M_master->getHarga($id)->num_rows(),
                'getRange'          => $this->db->get('tbl_range')->result(),
                'mesin'             => $this->db->get('tbl_mesin')->result(),
                'getmata'           => $this->db->get('tbl_mata_cutting')->result(),
                'side'              => $this->db->get('tbl_side')->result(),
                
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/detail_product', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function aksi_simpan_lembur()
        {
            $jam_mulai      = $this->input->post('jam_mulai');
            $jam_selesai    = $this->input->post('jam_selesai');

            if ($jam_mulai >= $jam_selesai) {
                $this->session->set_flashdata('error', 'Jam selesai harus lebih besar dari jam mulai.');
                redirect('karyawan/lembur'); // Kembali ke form
                return;
            }

            $data = [
                'karyawan_id'  => $this->input->post('karyawan_id'),
                'tanggal'      => $this->input->post('tanggal'),
                'jam_mulai'    => $jam_mulai,
                'jam_selesai'  => $jam_selesai,
                'kegiatan'     => $this->input->post('kegiatan'),
            ];

            $this->db->insert('tbl_lembur', $data);
            $this->session->set_flashdata('msg', 'Data lembur berhasil ditambahkan.');
            redirect('mobile');
        }

        function aksi_edit_profile(){
            $id             = $this->input->post('karyawan_id');

            $where          = array(
                'karyawan_id' => $this->input->post('karyawan_id'),
            );

            $data = [
                    'nama_lengkap'    => $this->input->post('nama_lengkap'),
                    'jenis_kelamin'   => $this->input->post('jenis_kelamin'),
                    'tempat_lahir'    => $this->input->post('tempat_lahir'),
                    'tanggal_lahir'   => $this->input->post('tanggal_lahir'),
                    'alamat'          => $this->input->post('alamat'),
                    'telepon'         => $this->input->post('telepon'),
                    'email'           => $this->input->post('email'),
                ];
            $update = $this->M_master->updateData('tbl_karyawan', $where, $data);
            print_r($update);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect('mobile');
            }
        }

        function owner(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $tanggal            = date('Y-m-d');
            $jamSekarang        = date('H:i');
            // print_r($karyawan);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
                'userid'        => $this->db->get_where('users', array('user_id'=> $this->session->userdata('id')))->row_array(),    
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Sistem Absensi Lembur',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $perusahaan,
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'cekabsen'          => $this->db->get_where('absensi', ['karyawan_id' => $karyawan, 'tanggal' => date('Y-m-d')])->row_array(),
                'hasilcek'          => $this->db->get_where('absensi', ['karyawan_id' => $karyawan, 'tanggal' => date('Y-m-d')])->num_rows(),
                'success'           => $this->db
                                    ->where('karyawan_id', $karyawan)
                                    ->where('tanggal', date('Y-m-d'))
                                    ->where('jam_masuk IS NOT NULL AND jam_masuk != "00:00:00"', null, false)
                                    ->where('jam_pulang IS NOT NULL AND jam_pulang != "00:00:00"', null, false)
                                    ->get('absensi')
                                    ->num_rows(),

                );
            // 1. Cek hari libur dari tabel hari_libur
            $isLibur = $this->db
                        ->where('tanggal', $tanggal)
                        ->get('hari_libur')
                        ->num_rows() > 0;

            $isMinggu               = date('w', strtotime($tanggal)) == 0;
            $isJamKerja             = ($jamSekarang >= '07:00' && $jamSekarang <= '18:00');
            $data['boleh_absen']    = !$isLibur && !$isMinggu && $isJamKerja;
            
            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/owner', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        // Dashboard Owner

        public function keuangan(){
            $this->load->model('M_transaksi');
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $bulanini           = date('Y-m');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'absensi'           => $this->Absensi_model->get_absensi_hari_ini(),
                'lembur'            => $this->M_master->karyawan_lembur()->result(),
                'keuangan'          => $this->M_transaksi->getkeuanganmobile()->result(),
                'pengeluaran'       => $this->M_transaksi->getpengeluaran()->result(),
                
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/keuangan', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function penjualan(){
            $this->load->model('M_transaksi');
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $bulanini           = date('Y-m');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'logo'                  => $conf['perusahaan']['logo'],
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan_terpilih'     => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'absensi'               => $this->Absensi_model->get_absensi_hari_ini(),
                'lembur'                => $this->M_master->karyawan_lembur()->result(),
                'keuangan'              => $this->M_transaksi->getkeuanganmobile()->result(),
                'pengeluaran'           => $this->M_transaksi->getpengeluaran()->result(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getpenjualanall()->result(),
                
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/penjualan', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function sdm(){
            $this->load->model('M_transaksi');
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $bulanini           = date('Y-m');
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'logo'                  => $conf['perusahaan']['logo'],
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan_terpilih'     => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'absensi'               => $this->Absensi_model->get_absensi_hari_ini(),
                'lembur'                => $this->M_master->karyawan_lembur()->result(),
                'karyawan'              => $this->db->get('tbl_karyawan')->result(),
                
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/sdm', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function inventory(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Inventory',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'tampildata'        => $this->M_gudang->getGudangBahan()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/inventory', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function piutang(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Inventory',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'piutang'        => $this->M_transaksi->getPiutang()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/piutang', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function analisis(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Inventory',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'analisis'          => $this->M_transaksi->product_terlaris()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/analisis', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function trend(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Inventory',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'analisis'          => $this->M_transaksi->product_terlaris()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/trend', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

        public function kinerja(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $karyawan           = $this->session->userdata('karyawan_id');
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Inventory',
                'logo'              => $conf['perusahaan']['logo'],
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'analisis'          => $this->M_transaksi->product_terlaris()->result(),
            );

            $this->load->view('admin/mobile/head', $data);
            $this->load->view('admin/mobile/kinerja', $data);
            $this->load->view('admin/mobile/footer', $data);
            
        }

    }