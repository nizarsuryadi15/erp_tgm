<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Bahan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $user_img   = $this->session->userdata('user_img');
                $perusahaan = $this->session->userdata('perusahaan_id');
            }
           
        }

        public function index(){
            
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Bahan dan Jasa',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_master->getDataBahan()->result(),
                'total_rows'        => $this->M_master->getDataBahan()->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'last_barcode'      => $this->db->select('barcode')
                                            ->from('tbl_bahan')
                                            ->order_by('CAST(barcode AS UNSIGNED)', 'DESC')
                                            ->limit(1)
                                            ->get()
                                            ->row(),    
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/bahan/index', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function product_bahan($id){
            $kode           = $this->uri->segment(3);
            $controller     = $this->uri->segment(1);
            $userid = $this->session->userdata('id');

            $data['table']  = 'tbl_bahan';
            $namabahan      = $this->db->get_where('tbl_bahan', array('bahan_id' => $kode))->row_array();

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'title'             => 'Daftar product Bahan '.$namabahan['bahan_nama'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'tampil'            => $this->M_master->get_produk_by_bahan($kode)->result(),
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

            // print_r($data);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/bahan/product_bahan', $data);
            $this->load->view('layout_admin/footer');
            
        }


        function actionAdd(){
            $table = 'tbl_bahan';
            $controller = $this->uri->segment(1);

            $barcode = $this->input->post('barcode');
            // Barcode otomatis jika kosong: ambil barcode terakhir, tambah 1
            if (empty($barcode)) {
                $last = $this->db->select('barcode')
                    ->from($table)
                    ->order_by('bahan_id', 'DESC')
                    ->limit(1)
                    ->get()
                    ->row();
                if ($last && is_numeric($last->barcode)) {
                    $barcode = str_pad($last->barcode + 1, 8, '0', STR_PAD_LEFT);
                } else {
                    $barcode = '00000001';
                }
            }

            $data = array(
                'barcode'        => $barcode,
                'bahan_nama'     => $this->input->post('bahan_nama'),
                'satuan_gudang'  => $this->input->post('satuan_gudang'),
                'satuan_id'      => $this->input->post('satuan_id'),
                'product_jasa'   => $this->input->post('product_jasa'),
            );

            // Ambil bahan_id terakhir, tambah 1 jika insert baru
            $bahanid = $this->input->post('bahan_id');
            if (empty($bahanid)) {
                $last_id = $this->db->select('bahan_id')->from($table)->order_by('bahan_id', 'DESC')->limit(1)->get()->row();
                $bahanid = $last_id ? ($last_id->bahan_id + 1) : 1;
            }

            if (!empty($this->input->post('bahan_id'))) {
                // Jika bahan_id sudah ada, update data
                $this->db->where('bahan_id', $bahanid);
                $update = $this->db->update($table, $data);
                if ($update) {
                    $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data');
                }
                redirect('bahan');
            }
            $datastok   = array(
                'bahan_id'          => $bahanid,
                'stok_awal'         => 0, // Inisialisasi stok awal
                'stok_tambah'       => 0, // Inisialisasi stok awal
                'stok_kurang'       => 0, // Inisialisasi stok awal
                'stok_min'          => 0, // Inisialisasi stok awal
            );

            $add = $this->M_master->addData('tbl_bahan', array_merge($data, ['bahan_id' => $bahanid]));
            $add = $this->M_master->addData('tbl_stok_gudang', $datastok);

            $barcodeDir = FCPATH . 'assets/uploads/barcode/';
            if (!is_dir($barcodeDir)) {
                mkdir($barcodeDir, 0777, true);
            }
            $barcodeFile = $barcodeDir . $barcode . '.png';

            // Gunakan Picqer Barcode Generator
            if (!class_exists('\Picqer\Barcode\BarcodeGeneratorPNG')) {
                require_once(APPPATH . '../vendor/autoload.php');
            }
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $barcodeImage = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);
            write_file($barcodeFile, $barcodeImage);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
            }
            redirect('bahan');
        }

        function actionDelete(){
            $id                 = $this->uri->segment(3);
            $table              = 'tbl_bahan';
            $data['id']         = 'bahan_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);
            // Hapus file barcode jika ada
            $barcodeFile = FCPATH . 'assets/uploads/barcode/' . $id . '.png';
            if (file_exists($barcodeFile)) {
                unlink($barcodeFile);
            }
            if ($delete == true) {
                $this->session->set_flashdata('hapus', 'Data Berhasil Dihapus');
                redirect('bahan');
            }
        }


        public function actionUpdate() {
            $table = 'tbl_bahan';
            $id = $this->input->post('bahan_id');
            // Ambil barcode dari input, jika tidak ada maka tetap gunakan yang lama
            
            $data = [
              
                'bahan_nama' => $this->input->post('bahan_nama'),
                'product_jasa' => $this->input->post('product_jasa'),
                'satuan_gudang' => $this->input->post('satuan_gudang'),
                'satuan_id' => $this->input->post('satuan_id'),
            ];
           
            
            $this->db->where('bahan_id', $id);
            $this->db->update('tbl_bahan', $data);

            // Pastikan path folder dan file konsisten
            
            redirect('bahan');
        }
        

        public function updateBarcodeOnly() {
            $table = 'tbl_bahan';
            $id = $this->input->post('bahan_id');
            $barcode = $this->input->post('barcode');

            // Barcode otomatis jika kosong: ambil barcode terakhir yang paling besar (secara numerik)
            if (empty($barcode)) {
                $last = $this->db->select('barcode')
                    ->from($table)
                    ->order_by('CAST(barcode AS UNSIGNED)', 'DESC')
                    ->limit(1)
                    ->get()
                    ->row();
                if ($last && is_numeric($last->barcode)) {
                    $barcode = str_pad($last->barcode + 1, 8, '0', STR_PAD_LEFT);
                } else {
                    $barcode = '00000001';
                }
            }

            $data = [
                'barcode' => $barcode,
            ];

            $this->db->where('bahan_id', $id);
            $this->db->update($table, $data);

            // Generate barcode image
            $barcodeDir = FCPATH . 'assets/uploads/barcode/';
            if (!is_dir($barcodeDir)) {
                mkdir($barcodeDir, 0777, true);
            }
            $barcodeFile = $barcodeDir . $barcode . '.png';

            if (!class_exists('\Picqer\Barcode\BarcodeGeneratorPNG')) {
                require_once(APPPATH . '../vendor/autoload.php');
            }
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $barcodeImage = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);
            write_file($barcodeFile, $barcodeImage);

            redirect('bahan');
        }


        function viewData($id){
            $userid = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Detail Daftar Satuan',
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('layout_admin/footer');
        }

        // Tambahkan fungsi untuk cek barcode (opsional, untuk AJAX scan barcode)
        public function cekBarcode()
        {
            $barcode = $this->input->post('barcode');
            $result = $this->db->get_where('tbl_bahan', ['barcode' => $barcode])->row_array();
            if ($result) {
                echo json_encode(['status' => 'ada', 'data' => $result]);
            } else {
                echo json_encode(['status' => 'tidak_ada']);
            }
        }

    }
    
?>