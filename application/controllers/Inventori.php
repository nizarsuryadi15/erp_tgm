<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Inventori extends CI_Controller
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

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => 'Dashboard',
                'title'             => 'Dashboard Inventory',
                'content'           => 'dashboard/index',
                'perusahaan'        => $perusahaan,
                'total_job'         => $this->db->get('tbl_flow_diagram')->num_rows(),
                'total_produksi'    => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Masuk Proses Produksi'))->num_rows(),
                'total_done'        => $this->db->get_where('tbl_flow_diagram', array('status_transaksi' => 'Produksi Selesai, Barang di Bagian PB'))->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                
                'total_bahan'       => $this->M_master->getDataBahan()->num_rows(),
                'total_konsumen'    => $this->M_master->tampilData('tbl_konsumen', 'konsumen_nama')->num_rows(),
                'total_product'     => $this->M_master->getDataProduct()->num_rows(),
                'total_desk'        => $this->M_master->getdeskprint()->num_rows(),
                'jml_kategori'      => $this->db->get('tbl_kategori')->num_rows(),
                'jml_subkategori'   => $this->db->get('tbl_subkategori')->num_rows(),
                'jml_supplier'      => $this->db->get('tbl_supplier')->num_rows(),
                'jml_karyawan'      => $this->db->get('tbl_karyawan')->num_rows(),
                'jml_users'         => $this->db->get('users')->num_rows(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/inventori/dashboard', $data);
            $this->load->view('layout_admin/footer');
        }

        public function detail_product($id){
            $controller     = $this->uri->segment(1);
            $data['table']  = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'product'           => $this->db->get_where('tbl_product', array('product_id' => $id))->row_array(),
                'controller'        => $this->uri->segment(1),
                'satuan'            => $this->db->get('tbl_satuan')->result(),  
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'bahan'             => $this->db->get('tbl_bahan')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'waktu'             => $this->db->get('tbl_waktu')->result(),
                'step'              => $this->db->get('tbl_operator')->result(),
                'type'              => $this->db->get('tbl_type')->result(),
                'perusahaan'        => $this->db->get('tbl_perusahaan')->result(),
                'getProduct'        => $this->M_master->getProduct($id)->row_array(),
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
            );
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/product/detail_product', $data);
            $this->load->view('layout_admin/footer');
            
        }

        

        public function uploadproduct($id){
            $controller     = $this->uri->segment(1);
            $data['table']  = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'product'           => $this->db->get_where('tbl_product', array('product_id' => $id))->row_array(),
                'controller'        => $this->uri->segment(1),
                'satuan'            => $this->db->get('tbl_satuan')->result(),  
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'bahan'             => $this->db->get('tbl_bahan')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'waktu'             => $this->db->get('tbl_waktu')->result(),
                'step'              => $this->db->get('tbl_operator')->result(),
                'type'              => $this->db->get('tbl_type')->result(),
                'perusahaan'        => $this->db->get('tbl_perusahaan')->result(),
            );
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/product/form_upload', $data);
            $this->load->view('layout_admin/footer');
            
        }


        public function actionuploadaproduct(){
            $table      = 'tbl_product';
            $id         = $this->input->post('product_id');

            $config['upload_path']      = FCPATH . 'assets/images/product/';
            $config['allowed_types']    = 'jpg|jpeg|png';
            $config['max_size']         = '5048';
            // $config['max_width']        = '1024';
            // $config['max_height']       = '1024';

            $this->load->library('upload', $config);
            $product            = $this->db->get_where('tbl_product', array('product_id' => $id))->row_array();
            $foto_lama          = $product['product_img_1'];
            
            echo "Upload path (raw): " . $config['upload_path'] . "<br>";
            echo "Folder exists? " . (is_dir($config['upload_path']) ? 'Yes' : 'No') . "<br>";
            echo "Writable? " . (is_writable($config['upload_path']) ? 'Yes' : 'No') . "<br>";


            if (!empty($_FILES['product_img_1']['name'])) {
                print_r($_FILES);
                if ($this->upload->do_upload('product_img_1')) {
                    // hapus file lama
                    // if (file_exists('./assets/images/product/'. $foto_lama) && $foto_lama != 'official.png') {
                    //     unlink('./assets/images/product/'. $foto_lama);
                    // }
                    $foto_baru = $this->upload->data('file_name');
                } else {
                    // print_r("kadieu 2");
                    echo $this->upload->display_errors();
                    echo 'Upload path: ' . $config['upload_path'];
                    // if (!is_dir($config['upload_path'])) {
                    //     echo ' ← folder TIDAK DITEMUKAN!';
                    // }
                    // $this->session->set_flashdata('error', $this->upload->display_errors());
                    // if (!is_dir($config['upload_path'])) {
                    //     echo "Folder tidak ditemukan!";
                    // } elseif (!is_writable($config['upload_path'])) {
                    //     echo "Folder tidak bisa ditulis!";
                    // } else {
                    //     echo "Folder valid dan bisa ditulis.";
                    // }
                    
                    // redirect('inventori/uploadproduct/' . $id);
                }
            } else {
                $foto_baru = $foto_lama;
            }

            $data = [
                'product_img_1' => $foto_baru
            ];
    
            $this->User_model->updateHarga($table, $id, $data);
            redirect('inventori/uploadproduct/' . $id);

        }


        public function formAddBahan(){
            $controller = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Tambah Data Bahan',
                'id'            => $this->M_master->getData()->row_array(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'kategori'      => $this->M_master->get_kategori()->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/bahan/form_add', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function product(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Product',
                'table'             => 'tbl_kategori',
                'tampilData'        => $this->M_master->getDataProduct()->result(),
                'total_rows'        => $this->M_master->getDataProduct()->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/product/index', $data);
            $this->load->view('layout_admin/footer');
        }

        function get_subkategori(){
            $id=$this->input->post('id');
            $data=$this->M_master->get_subkategori($id);
            echo json_encode($data);
        }

        function actionAdd(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
        
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'subkategori_id'            => $this->input->post('subkategori_id'),
                'bahan_id'                  => $this->input->post('bahan_id'),
                'product_nama'              => strtoupper($this->input->post('product_nama')),
                'satuan_id'                 => $this->input->post('satuan_id'),
                'product_waktu_pengerjaan'  => $this->input->post('product_waktu_pengerjaan'),
                'satuan_waktu_id'           => $this->input->post('satuan_waktu_id'),
                'product_deskripsi'         => $this->input->post('product_deskripsi'),
                'perusahaan_id'             => $this->session->userdata('perusahaan_id'),  
                // 'perusahaan'                => $conf['perusahaan']['nama_perusahaan'],
                // 'hakakses'                  => $conf['hakakses']['divisi_nama'],
                // 'logo'                      => $conf['perusahaan']['logo'],
            );

            $subkategori    = $this->input->post('subkategori_id');
            $bahanid        = $this->input->post('bahan_id');
            $satuan         = $this->input->post('satuan_id');

            $cekproduct = $this->M_master->cekProduct($subkategori, $bahanid, $satuan, $perusahaan)->num_rows();

            if ($cekproduct == 0){
                $add = $this->M_master->addData($table, $data);

                if ($add == true) {
                    $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                    redirect($controller);
                }
            }else{
                $this->session->set_flashdata('error', 'Data Sudah Ada');
                redirect($controller);
            }
        }

        function actionupdataproduct(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $update = array(
                'subkategori_id'            => $this->input->post('subkategori_id'),
                'kategori_id'               => $this->input->post('kategori_id'),
                'bahan_id'                  => $this->input->post('bahan_id'),
                'product_nama'              => strtoupper($this->input->post('product_nama')),
                'satuan_id'                 => $this->input->post('satuan_id'),
                'product_waktu_pengerjaan'  => $this->input->post('product_waktu_pengerjaan'),
                'satuan_waktu_id'           => $this->input->post('satuan_waktu_id'),
                'product_deskripsi'         => $this->input->post('product_deskripsi'),
                'perusahaan_id'             => $this->input->post('perusahaan_id'),
                'tipe_id'                   => $this->input->post('tipe_id'),
                'step_1'                    => $this->input->post('step_1'),
                'step_2'                    => $this->input->post('step_2'),
                'step_3'                    => $this->input->post('step_3'),
                'step_4'                    => $this->input->post('step_4'),
                'step_5'                    => $this->input->post('step_5'),
            );

            $where = array('product_id' => $this->input->post('product_id'));


            $success = $this->M_master->updateData($table, $where, $update);

            if ($success == true){
                redirect($controller.'/detail_product');
            }

        }

        function actionDelete($id){
            $table              = 'tbl_bahan';
            $data['id']         = 'bahan_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('hapus', 'Data Berhasil Dihapus');
                redirect($controller.'/bahan');
            }
        }


        public function updatebahan($id){
            $controller     = $this->uri->segment(1);
            $data['table']  = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'getlist'           => $this->db->get_where('tbl_bahan', array('bahan_id' => $id))->row_array(),
                'controller'        => $this->uri->segment(1),
                'satuan'            => $this->db->get('tbl_satuan')->result(),    
            );
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/bahan/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function actionupdatebahan(){
            $table          = 'tbl_bahan';
            $controller     = $this->uri->segment(1);
            
            $where          = array(
                'bahan_id'  => $this->input->post('bahan_id'),
            );

            $data = array(
                'barcode'           => $this->input->post('barcode'),
                'bahan_nama'        => strtoupper($this->input->post('bahan_nama')),
                'satuan_id'         => $this->input->post('satuan_id'),
                'product_jasa'      => $this->input->post('product_jasa'),
                
            );

            print_r($data);

            $update = $this->M_master->updateData($table, $where, $data);


            redirect('inventori/bahan');
            
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
            $table          = 'tbl_product';
            $controller     = $this->uri->segment(1);
            // $data['table']  = 'tbl_bahan';
            // print_r($id);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Tambah Data Product',
                'getAlurKerja'  => $this->M_master->get_alur_kerja_product($id)->result(),
                'id'            => $this->M_master->getData()->row_array(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'kategori'      => $this->M_master->get_kategori()->result(),
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

                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/product/detail', $data);
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

        function action_save_all(){
            $controller         = $this->uri->segment(1);
            
            $kategori_id        = $this->input->post('kategori_id');
            $subkategori_id     = $this->input->post('subkategori_id');
            $detail_product     = $this->input->post('detail_product');
            $hargaid            = $this->input->post('harga_id');
            $product            = $this->input->post('product_id');
            $rangeid            = $this->input->post('range_id');
            $ket1               = $this->input->post('ket_1');
            $ket2               = $this->input->post('ket_2');
            $ket3               = $this->input->post('ket_3');  
            $ket4               = $this->input->post('ket_4');  
            $harga1             = $this->input->post('harga_1');
            $harga2             = $this->input->post('harga_2');
            $harga3             = $this->input->post('harga_3');
            $subkategori_ket    = $this->input->post('subkategori_ket');
            $jml_minimum        = $this->input->post('jml_minimum');
            $step_1               = $this->input->post('step_1');
            $step_2               = $this->input->post('step_2');
            $step_3               = $this->input->post('step_3');  
            $step_4               = $this->input->post('step_4');

            print_r("kategori : ".$kategori_id[0]);
            print_r("<br>");
            print_r("Sub kategori : ".$subkategori_id[0]);
            print_r("<br>");
            print_r("Product : ".$product[0]);
            print_r("<br>");
            print_r("Ket 1 :".$ket1[0]);
            print_r("<br>");
            print_r("Ket 2 :".$ket2[0]);
            print_r("<br>");
            print_r("Ket 3 :". $ket3[0]);
            print_r("<br>");
            print_r("Ket 4 :". $ket4[0]);

            foreach ($hargaid as $i => $value) { 
                //Product A3 Lembaran
                if (($kategori_id[0] == '1') && (($subkategori_id[0] == '1') OR ($subkategori_id[0] == '2') OR ($subkategori_id[0] == '3') OR ($subkategori_id[0] == '4'))) {
                    $update = [
                        'detail_product'    => strtoupper($detail_product[$i]),
                        'jml_minimum'       => $jml_minimum[$i],
                        'range_id'          => $rangeid[$i],
                        'harga_1'           => $harga1[$i],
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'ket_3'             => $ket3[$i],
                    ];

                    echo "Kadieu ny";
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate  = $this->db->update('tbl_harga_product', $update);
                    //print($getupdate);

                }
                //PRODUCT METERAN LARGE FORMAT
                elseif (($kategori_id[0] == '2') && (($subkategori_id[0] == '4') OR ($subkategori_id[0] == '5') OR ($subkategori_id[0] == '6') OR ($subkategori_id[0] == '7') OR ($subkategori_id[0] == '8') OR ($subkategori_id[0] == '17') OR ($subkategori_id[0] == '18') OR ($subkategori_id[0] == '19')))
                 {
                    echo "kadieu nyaaaaa";
                    $update = [
                        'detail_product'    => strtoupper($detail_product[$i]),
                        'range_id'          => $rangeid[$i],
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => $ket1[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    
                }
                //PAKET DISPLAY
                elseif (($kategori_id[0] == '3') && (($subkategori_id[0] == '9') OR ($subkategori_id[0] == '10') OR ($subkategori_id[0] == '11')  OR ($subkategori_id[0] == '12')  OR ($subkategori_id[0] == '13')))
                {
                    echo "kadieu nyaaaaa";
                    $update = [
                        'detail_product'    => strtoupper($detail_product[$i]),
                        'range_id'          => $rangeid[$i],
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'ket_3'             => $ket3[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => $ket1[$i],
                        'jml_minimum'       => $jml_minimum[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    
                }
                //PRINT BY SIZE
                elseif ($kategori_id[0] == '4') {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //PAKET KARTU NAMA
                elseif (($satuanid[0] == '7') && ($subkategori_id[0] == '5')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => $rangeid[$i],
                        'jml_minimum'       => $jml_minimum[$i],
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'ket_3'             => 4,
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //BROSUR
                elseif (($satuanid[0] == '8') && ($subkategori_id[0] == '5')) {
                    if ($ket2[$i] == '1') {
                        $ket3[$i]    = 500/2;
                    }elseif ($ket2[$i] == '2') {
                        $ket3[$i]    = 500/6;
                    }elseif ($ket2[$i] == '3') {
                        $ket3[$i]    = 500/4;
                    }
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 1,
                        'jml_minimum'         => 1,
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'ket_3'             => $ket3[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //ID CARD
                elseif (($satuanid[0] == '1') && ($subkategori_id[0] == '5')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => $rangeid[$i],
                        'jml_minimum'         => $jml_minimum[$i],
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //Laminasi A3+
                elseif (($satuanid[0] == '1') && ($subkategori_id[0] == '3')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => $rangeid[$i],
                        'jml_minimum'       => $jml_minimum[$i],
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];
                    
                    //print_r($update);
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //BENDING LEM PANAS
                elseif ($product == '29') {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => $rangeid[$i],
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];

                    //print_r($update);
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //CUTTING STICKER A3
                elseif (($satuanid[0] == '1') && ($subkategori_id[0] == '4')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];
                    echo "kesini";
                    print_r($update);
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                } 
                
                elseif (($satuanid[0] == '3') && ($subkategori_id[0] == '4')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];

                  //  print_r($update);
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                } 
                //JILID SPIRAL 
                elseif (($satuanid[0] == '3') && ($subkategori_id[0] == '4')) {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        
                    ];

                  //  print_r($update);
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                } 
                //BANNER and LARGE PAPER
                elseif ($subkategori_ket[0] == '3') 
                {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => $rangeid[$i],
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => $ket1[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    
                }
                //DTF
                elseif ($subkategori_id[0] == '27') 
                {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => $ket1[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    
                }
                //DTF
                elseif (($subkategori_id[0] == '26')  or ($subkategori_id[0] == '28')) 
                {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => $ket1[$i],
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    
                }
               

                //Finishing Large Format
                elseif ($subkategori_id[0] == '14')  
                {
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'ket_1'             => $ket1[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => 5,
                    ];
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                }
                //Apparel
                elseif ($subkategori_id[0] == '23')  
                {
                    echo"kadieu";
                
                    $update = [
                        'detail_product'    => $detail_product[$i],
                        'range_id'          => 6,
                        'ket_1'             => $ket1[$i],
                        'ket_2'             => $ket2[$i],
                        'ket_3'             => $ket3[$i],
                        'ket_4'             => $ket4[$i],
                        'harga_1'           => $harga1[$i],   
                        'harga_2'           => $harga2[$i],
                        'harga_3'           => $harga3[$i],
                        'mesin_id'          => 5,
                        'jml_minimum'       => $jml_minimum[$i],
                    ];

                
                    $this->db->where('harga_id', $hargaid[$i]);
                    $getupdate = $this->db->update('tbl_harga_product', $update);
                    print_r($getupdate);
                }
                
            
            }
            if ($getupdate) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('inventori/detail/'.$product);
                //redirect('product/detail/'.$product);
            }else{
                $this->session->set_flashdata('error', 'Data Berhasil Disimpan');
                //redirect('product/detail/'.$product);
            }
        }



        function copyproductProduct($id){
            $controller     = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Copy Product',
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
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/'.$controller.'/product/form_copy', $data);
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
                redirect($controller.'/detail/'.$product);
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


        // Gudang

        function stokopname(){
            $controller         = $this->uri->segment(1);

            $this->form_validation->set_rules('bahan_id', 'bahan_id', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $data = array(
                    'controller'    => $this->uri->segment(1),
                    'function'      => $this->uri->segment(2),
                    'title'         => 'Stok Opname',
                    'bulanini'      => date('Y-m'),
                    'tampilData'    => $this->M_gudang->getDataStokOpname()->result(),
                    'total_rows'    => $this->M_gudang->getDataStokOpname()->num_rows(),
                    'bahan'         => $this->db->get('tbl_bahan')->result(),
                );

                $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/top_header');
                $this->load->view('layout_admin/sidebar', $data);
                // $this->load->view('layout_admin/top_bar');
                $this->load->view('admin/'.$controller.'/gudang/son/dataSon', $data);
                $this->load->view('layout_admin/footer');
            }
            else
            {
                @$bahan_id = $this->input->post('bahan_id');
                $data = array(
                    'controller'    => $this->uri->segment(1),
                    'function'      => $this->uri->segment(2),
                    'title'         => 'Stok Opname',
                    'hariini'       => date('Y-m-d'),
                    'bulanini'      => date('Y-m'),
                    'tampilData'    => $this->M_gudang->getDataStokOpname()->result(),
                    'total_rows'    => $this->M_gudang->getDataStokOpname()->num_rows(),
                    'getbahan'      => $this->M_gudang->getBahan($bahan_id)->result(),
                    'getRow'        => $this->M_gudang->getBahan($bahan_id)->num_rows(),
                    'bahan'         => $this->db->get('tbl_bahan')->result(),
                    
                    
                );

                //print_r($data['getRow']);

                $this->load->view('layout_admin/head', $data);
                $this->load->view('layout_admin/header');
                $this->load->view('layout_admin/top_bar', $data);
                $this->load->view('gudang/son/dataSon', $data);
                $this->load->view('layout_admin/footer');
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
            $data = array(
                'tampilData'    => $this->M_gudang->getDataStokOpname()->result(),
                'total_rows'    => $this->M_gudang->getDataStokOpname()->num_rows(),
                'bulanini'      => date('m'),
            );
            $this->load->view('gudang/son/cetakson', $data);
        }

        // Supplier

        
        
    }
    
?>