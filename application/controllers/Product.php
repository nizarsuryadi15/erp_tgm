<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Product extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
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
                'title'             => 'Daftar Semua Product',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_master->getDataProduct()->result(),
                'total_rows'        => $this->M_master->getDataProduct()->num_rows(),
                'list_bahan'        => $this->db->order_by('bahan_nama', 'ASC')->get('tbl_bahan')->result(),
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'tipe'              => $this->db->get('tbl_type')->result(),
                'waktu'             => $this->db->get('tbl_waktu')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),  
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),  
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'sisi'              => $this->db->get('tbl_side')->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/index', $data);
            $this->load->view('layout_admin/footer');
            // $this->load->view('layout_admin/alert');
        }

        

        public function viewProduct(){
            $kdbahan            = $this->uri->segment(3);
            $controller         = $this->uri->segment(1);

            $data['table']      = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Lihat Product',
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'kategori'      => $this->db->get('tbl_kategori')->result(),
                'subkategori'   => $this->db->get('tbl_subkategori')->result(),
                'tipe'          => $this->db->get('tbl_type')->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'bahan'         => $this->db->get_where('tbl_bahan', array('bahan_id'=> $kdbahan))->row_array(),
                'product'       => $this->db->get_where('tbl_product', array('bahan_id'=>$kdbahan))->result(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

        //    print_r($data['bahan']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/view_product', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function get_subkategori(){
            $id=$this->input->post('id');
            $data=$this->M_master->get_subkategori($id);
            echo json_encode($data);
        }

        function actionAdd(){
            $table      = 'tbl_product';
            $controller = $this->uri->segment(1);

            // Ambil data user dari session
            $perusahaan_id = $this->session->userdata('perusahaan_id');
            $level         = $this->session->userdata('level');

            // Konfigurasi tambahan (jika diperlukan di view)
            $conf  = array(
                'perusahaan' => $this->db->get_where('tbl_perusahaan', ['id_perusahaan' => $perusahaan_id])->row_array(),
                'hakakses'   => $this->db->get_where('tbl_divisi', ['divisi_id' => $level])->row_array(),
            );

            // Ambil data dari input form
            $data = [
                'kategori_id'        => $this->input->post('kategori_id'),
                'subkategori_id'     => $this->input->post('subkategori_id'),
                'bahan_id'           => $this->input->post('bahan_id'),
                'product_nama'       => trim($this->input->post('product_nama')),
                'satuan_id'          => $this->input->post('satuan_id'),
                'product_deskripsi'  => trim($this->input->post('product_deskripsi')),
                'perusahaan_id'      => $perusahaan_id,
                'tipe_id'            => $this->input->post('tipe_id'),
                // 'product_img_1'    => $this->input->post('product_img_1'), // jika nanti dibutuhkan
            ];

            // Debug
            // print_r($data);

            // Cek apakah produk sudah ada
            $subkategori = $this->input->post('subkategori_id');
            $bahanid     = $this->input->post('bahan_id');
            $satuan      = $this->input->post('satuan_id');

            $cekproduct = $this->M_master->cekProduct($subkategori, $bahanid, $satuan, $perusahaan_id)->num_rows();

            // Debug
            // echo "Jumlah data ditemukan: $cekproduct";

            if ($cekproduct == 0) {
                $add = $this->M_master->addData($table, $data);
                
                if ($add) {
                    $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan data');
                }

                redirect($controller);

            } else {
                $this->session->set_flashdata('error', 'Data sudah ada');
                redirect($controller);
            }

        }

        function deleteproduct($id){
            if (!is_numeric($id)) {
                show_error('Invalid ID');
                return;
            }

            $product = $this->M_master->getprodukbyid($id);

            if (!$product) {
                $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
                redirect('product');
                return;
            }

            $this->M_product->delete_skala_harga($id);
            $this->M_product->delete_routing($id);

            // Hapus gambar jika ada
            if (!empty($product->product_img_1)) {
                $path = FCPATH . 'assets/images/product/' . $product->product_img_1;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            // Hapus data utama produk
            $this->M_product->delete($id);

            $this->session->set_flashdata('success', 'Produk dan semua data terkait berhasil dihapus.');
            redirect('product');
        }


        public function actionUpdate(){
            // Validasi minimal ID produk
            $product_id = $this->input->post('product_id');
            if (!$product_id) {
                show_error('ID produk tidak ditemukan');
            }

            $table  = 'tbl_product';
            $where  = [
                'product_id' => $product_id
            ];

            // Ambil semua input dari form
            $data = [
                'kategori_id'       => $this->input->post('kategori_id'),
                'subkategori_id'    => $this->input->post('subkategori_id'),
                'bahan_id'          => $this->input->post('bahan_id'),
                'product_nama'      => $this->input->post('product_nama'),
                'tipe_id'           => $this->input->post('tipe_id'),
                'satuan_id'         => $this->input->post('satuan_id'),
                'product_deskripsi' => $this->input->post('product_deskripsi')
            ];
            // print_r($table);
            // print_r("<br>");
            // print_r($where);
            // print_r("<br>");
            // print_r($data);

            // Update ke database melalui model
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_product', $data);

            // Set notifikasi dan redirect
            $this->session->set_flashdata('success', 'Data produk berhasil diperbarui.');
            redirect('product');
        }

        function viewData($id){

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
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('layout_admin/footer');
        }

        function detail($id){
            $id             = $this->uri->segment(3);
            $table          = 'tbl_product';
            $controller     = $this->uri->segment(1);
            $data['table']  = 'tbl_bahan';
            //print_r($id);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Data Product',
                // 'getAlurKerja'  => $this->M_master->get_alur_kerja_product($id)->result(),
                // 'id'            => $this->M_master->getData()->row_array(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                // 'kategori'      => $this->M_master->get_kategori()->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'getProduct'    => $this->M_master->getProduct($id)->row_array(),
                'getHarga'      => $this->M_master->getHarga($id)->result(),
                'jmlHarga'      => $this->M_master->getHarga($id)->num_rows(),
                'getRange'      => $this->db->get('tbl_range')->result(),
                'mesin'         => $this->db->get('tbl_mesin')->result(),
                'getmata'       => $this->db->get('tbl_mata_cutting')->result(),
                'getUkuranFile' => $this->db->get('tbl_ukuran_file')->result(),
                'getWarna'      => $this->db->get('tbl_warna')->result(),
                'getLebar'      => $this->db->get('tbl_lebar_textile')->result(),
                'kodeProduct'   => $id,
                'paketBanner'   => $this->db->get('tbl_paket_banner')->result(),
                'paketDigital'  => $this->db->get('tbl_paket_digital')->result(),
                'warnaKaos'     => $this->db->get('tbl_warna_kaos')->result(),
                'sizeKaos'      => $this->db->get('tbl_size_kaos')->result(),
                'side'          => $this->db->get('tbl_side')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            //print_r($data['getProduct']);
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/detail', $data);
            $this->load->view('layout_admin/footer');
        }

        function addHarga(){
            
            $controller     = $this->uri->segment(1);
            $product = $this->input->post('product_id');

            
            $add = [
                'product_id'    => $product,
            ];

            print_r($add);
            $tambah = $this->db->insert('tbl_harga_product', $add);
            if ($tambah == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Ditambahkan');
                redirect($controller.'/detail/'.$product);
            }
        }



        function copyproduct($id){
            $controller     = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Tambah Data Product',
                'id'            => $this->M_master->getData()->row_array(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'kategori'      => $this->M_master->get_kategori()->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'product'       => $this->M_master->getProduct($id)->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                
            );

            $data['subkategori'] = $this->M_master->get_subkategori($data['product']['kategori_id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_copy', $data);
            $this->load->view('layout_admin/footer');
        }

        function actionCopy(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            // print_r($controller);

            $data = array(
                'kategori_id'               => $this->input->post('kategori_id'),
                'subkategori_id'            => $this->input->post('subkategori_id'),
                'bahan_id'                  => $this->input->post('bahan_id'),
                'product_nama'              => $this->input->post('product_nama'),
                'satuan_id'                 => $this->input->post('satuan_id'),
                'product_waktu_pengerjaan'  => $this->input->post('product_waktu_pengerjaan'),
                'satuan_waktu_id'           => $this->input->post('satuan_waktu_id'),
                'product_deskripsi'         => $this->input->post('product_deskripsi'),
                'barcode'                   => $this->input->post('barcode'),
                
                
            );

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect($controller);
            }
        }

        function del_harga($id, $product){
            $controller = $this->uri->segment(1);
        
            $this->db->where('harga_id', $id);
            $del = $this->db->delete('tbl_harga_product');
            if ($del == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect('manufaktur/skala-harga/'.$product);
            }
        }

        function action_checkbox(){
            $alur       = $this->input->post('alur_id');
            $product    = $this->input->post('product_id');
            $jumlah     = count($alur);

            print_r($alur);
            print_r($product);
            // print_r($jumlah);

            for ($i=0; $i < $jumlah; $i++) { 
                $data = array(
                    'alur_id'       => $alur[$i],
                    'product_id'    => $product,
                );

            }
            if ($input == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('product/detail/'.$product);
            }

        }

        public function add_alur($product){
            $data = array(
                    'product_id' => $product,
            );

            if ($input == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('product/formUpdate/'.$product);
            }

        }

        public function add_subkategori_ajax()
        {
            $nama = $this->input->post('subkategori_nama');
            if (!$nama) {
                echo json_encode(['status' => 'error', 'message' => 'Nama tidak boleh kosong']);
                return;
            }

            $this->db->insert('tbl_subkategori', ['subkategori_nama' => $nama]);
            $id = $this->db->insert_id();

            echo json_encode([
                'status' => 'success',
                'data' => [
                    'subkategori_nama' => $nama
                ]
            ]);
        }


        public function handle_subkategori()
        {
            $id     = $this->input->post('subkategori_id');
            $action = $this->input->post('action');
            $nama   = $this->input->post('subkategori_nama');

            if ($action == 'edit') {
                $this->db->update('tbl_subkategori', ['subkategori_nama' => $nama], ['subkategori_id' => $id]);
                $this->session->set_flashdata('success', 'Subkategori berhasil diupdate');
            } elseif ($action == 'delete') {
                $this->db->delete('tbl_subkategori', ['subkategori_id' => $id]);
                $this->session->set_flashdata('success', 'Subkategori berhasil dihapus');
            }

            redirect($_SERVER['HTTP_REFERER']); // kembali ke halaman modal
        }

        public function update_subkategori_ajax()
        {
            $id   = $this->input->post('subkategori_id');
            $nama = $this->input->post('subkategori_nama');

            if ($id && $nama) {
                $this->db->where('subkategori_id', $id);
                $update = $this->db->update('tbl_subkategori', [
                    'subkategori_nama' => $nama
                ]);

                if ($update) {
                    echo json_encode(['status' => 'success', 'message' => 'Berhasil diupdate']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal update']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            }
        }

        public function delete_subkategori_ajax()
        {
            $id = $this->input->post('subkategori_id');

            if ($id) {
                $this->db->where('subkategori_id', $id);
                $delete = $this->db->delete('tbl_subkategori');

                if ($delete) {
                    echo json_encode(['status' => 'success', 'message' => 'Berhasil dihapus']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
            }
        }




        
    }
    
?>