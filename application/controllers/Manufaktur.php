<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Manufaktur extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set('Asia/Jakarta');

            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_master');
                $this->load->model('M_routing');
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
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'tipe'              => $this->db->get('tbl_type')->result(),
                'waktu'             => $this->db->get('tbl_waktu')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'bahan'             => $this->M_master->getDataBahan()->result(),   
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'jml_stok_minim'    => $this->M_gudang->stok_minim()->num_rows(),  
                'level'             => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),  
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'list_bahan'        => $this->M_master->getDataBahan()->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header',);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/index', $data);
            $this->load->view('layout_admin/footer');
            $this->load->view('layout_admin/alert');
        }

        function routing(){
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Routing Manufacturing Product',
                'table'             => 'tbl_kategori',
                'product'           => $this->M_master->getproductorderby('product_nama')->result(),
                'total_rows'        => $this->db->get('routing')->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                'getproduct'        => $this->db->get_where('tbl_product', array('product_id'=>$kode))->row_array(),
                'kode'              => $kode,
                'operator_list'     => $this->db->get('tbl_operator')->result(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
           
                
            );

            if ($kode <> ''){
                $data['tampilData'] = $this->M_master->routingbykode($kode)->result();
                $data['total_rows'] = $this->M_master->routingbykode($kode)->num_rows();
            }else{
                $data['tampilData'] = $this->M_master->routingbykode()->result();
                $data['total_rows'] = $this->M_master->routingbykode()->num_rows();
            }

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/manufaktur/routing', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function bom(){
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Bulit Of Material',
                'table'             => 'tbl_kategori',
                'product'           => $this->M_master->getproductorderby('product_nama')->result(),
                'total_rows'        => $this->db->get('routing')->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                'routing'           => $this->db->get('routing')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'getproduct'        => $this->db->get_where('tbl_product', array('product_id'=>$kode))->row_array(),
                'bahan'             => $this->M_master->getDataBahan('')->result(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),

                
            );

            if ($kode <> ''){
                $data['tampilData'] = $this->M_master->getbomkode('bahan_id',$kode)->result();
                $data['total_rows'] = $this->M_master->getbomkode('bahan_id',$kode)->num_rows();
            }else{
            //     $data['tampilData'] = $this->M_master->getbom('bahan_id')->result();
            //     $data['total_rows'] = $this->M_master->getbom('bahan_id')->num_rows();
            }

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/manufaktur/bom', $data);
            $this->load->view('layout_admin/footer');
        
        }

        public function aksi_simpan_bom()
        {
            // Ambil input dari form
            $product_id     = $this->input->post('product_id');
            $quantity       = $this->input->post('quantity');
            $satuan_id      = $this->input->post('satuan_id');
            $bahan_id       = $this->input->post('bahan_id');
            $panjang        = $this->input->post('panjang');
            $lebar          = $this->input->post('lebar');
            

            // Validasi sederhana
            if (!$quantity || !$product_id || !$bahan_id) {
                $this->session->set_flashdata('error', 'Semua field wajib diisi!');
                // redirect('manufaktur/bom/'.$product_id); // Ganti dengan halaman yang sesuai
            }

            // Siapkan data untuk insert
            $data = [
                'quantity'      => $quantity,
                'product_id'    => $product_id,
                'bahan_id'      => $bahan_id,
                'satuan_id'     => $satuan_id,
                'panjang'       => $panjang,
                'lebar'         => $lebar,
            ];

            print_r($data);

            // Simpan ke database
            $simpan = $this->db->insert('bom_lines', $data); // Ganti 'tbl_bom' dengan nama tabel sebenarnya

            // // Notifikasi sukses
            if ($simpan == true){
                $this->session->set_flashdata('success', 'Data BOM berhasil disimpan.');
                redirect('manufaktur/bom/'.$product_id); // Ganti sesuai halaman yang relevan
            }
        }

        function skalaharga(){
            $userid             = $this->session->userdata('id');
            $kode               = $this->uri->segment(3);

            // print_r($kode);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Product',
                'table'             => 'tbl_kategori',
                
                'product'           => $this->M_master->getproductorderby('product_nama')->result(),
                'total_rows'        => $this->db->get('routing')->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                'getProduct'        => $this->M_master->getProduct($kode)->row_array(),
                'getHarga'          => $this->M_master->getHarga($kode)->result(),
                'jmlHarga'          => $this->M_master->getHarga($id)->num_rows(),
                'getRange'          => $this->db->get('tbl_range')->result(),
                'mesin'             => $this->db->get('tbl_mesin')->result(),
                'getmata'           => $this->db->get('tbl_mata_cutting')->result(),
                'side'              => $this->db->get('tbl_side')->result(),
                'segmen2'           => $this->uri->segment(2),
                'lebarkain'         => $this->db->get('tbl_lebar_textile')->result(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                
            );

            if ($kode <> ''){
                $data['tampilData'] = $this->M_master->getroutingkode('bahan_id',$kode)->result();
                $data['total_rows'] = $this->M_master->getroutingkode('bahan_id',$kode)->num_rows();
            }else{
                $data['tampilData'] = $this->M_master->getrouting('bahan_id')->result();
                $data['total_rows'] = $this->M_master->getrouting('bahan_id')->num_rows();
            }

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/detail', $data);
            $this->load->view('layout_admin/footer');
            // $this->load->view('layout_admin/alert');
        
        }
        
        

        function aksi_simpan_routing(){
            $table      = 'routing';
            $product    = $this->input->post('product_id');

            $data = array(
                'routing_name'  => $this->input->post('routing_name'),
                'product_id'    => $this->input->post('product_id'),
            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);
            var_dump($add);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('manufaktur/routing/'.$product);
            }
        }

        function aksideletestep($id,$product){
            $table              = 'routing';

            $this->db->where('routing_id', $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('hapus', 'Data Berhasil Dihapus');
                redirect('manufaktur/routing/'.$product);
            }
        }

        function step_routing($kode){
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Daftar Step Routing Manufacturing',
                'table'             => 'tbl_kategori',
                
                'getrouting'        => $this->M_master->getroutingbykode($kode)->row_array(),
                'workcenters'       => $this->M_master->getworkcenters()->result(),
                'step_routing'      => $this->M_master->steprouting($kode)->result(),
                'total_rows'        => $this->M_master->steprouting($kode)->num_rows(),
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/manufaktur/step_routing', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function aksi_simpan_step_routing(){
            $table  = 'routing_steps';
            $kode   = $this->input->post('routing_id');

            $data = array(
                'routing_id'        => $this->input->post('routing_id'),
                'sequence'          => $this->input->post('sequence'),
                'operation'         => $this->input->post('operation'),
                'workcenter_id'     => $this->input->post('workcenter_id'),
                'duration_mins'     => $this->input->post('duration_mins'),
                'notes'             => $this->input->post('notes'),
            );

            $add = $this->M_master->addData($table, $data);
            // var_dump($add);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('manufaktur/step_routing/'.$kode);
            }
        }

        public function formAdd(){
            $controller = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';
            $userid             = $this->session->userdata('id');

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
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
            );

           // print_r($data['id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/form_add', $data);
            $this->load->view('layout_admin/footer');
        
        }

        function get_subkategori(){
            $id=$this->input->post('id');
            $data=$this->M_master->get_subkategori($id);
            echo json_encode($data);
        }

        function action_add_routing(){
            $product            = $this->input->post('product_id');
            $data = [
                'routing_name'   => $this->input->post('routing_name'),
                'product_id'     => $this->input->post('product_id'),
                'routing_urutan' => $this->input->post('routing_urutan'),
                'operator_id'    => $this->input->post('mesin_id'),
                'durasi'         => '5',
                'keterangan'     => $this->input->post('routing_name'),
                'is_active'      => '1',
                'created_at'     => date('Y-m-d H:i:s')
            ];

            print_r($data);

            $this->db->insert('routing', $data);
            $this->session->set_flashdata('success', 'Data routing berhasil ditambahkan.');
            redirect('manufaktur/routing/'.$product);
            
        }

        function deleteproduct($id){

            // Baru hapus product
            $this->db->where('product_id', $id);
            $this->db->delete('tbl_product');

            // $this->session->set_flashdata('success', 'Produk dan semua data terkait berhasil dihapus.');
            redirect('manufaktur');
        }


        public function formUpdate($id){
            $controller     = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';
            $userid             = $this->session->userdata('id');

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
                'kategori'      => $this->db->get('tbl_kategori')->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'product'       => $this->M_master->getProduct($id)->row_array(),
                'step'          => $this->db->get('tbl_operator')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                
            );

            $data['subkategori'] = $this->M_master->get_subkategori($data['product']['kategori_id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function actionUpdateproduct(){
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
                'product_deskripsi' => $this->input->post('product_deskripsi'),
                'side_id'           => $this->input->post('side_id'),
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
            $userid             = $this->session->userdata('id');
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
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('layout_admin/footer');
        }

        function detail($id){
            $userid         = $this->session->userdata('id');
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
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),

                
            );

            //print_r($data['getProduct']);
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/top_bar', $data);
            $this->load->view('admin/'.$controller.'/detail', $data);
            $this->load->view('layout_admin/footer');
        }

        function addHarga(){
            $segmen2  = $this->input->post('segmen2');
            $product  = $this->input->post('product_id');

            print_r($product);
            // Data yang akan ditambahkan
            $data = [
                'product_id' => $product,
            ];


            // Proses insert ke database
            $insert = $this->db->insert('tbl_harga_product', $data);
            print_r($insert);


            if ($insert) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');

                $redirect_url = ($segmen2 == 'edit-product') 
                    ? 'manufaktur/edit-product/' . $product 
                    : 'manufaktur/skala-harga/' . $product;

                redirect($redirect_url);
            }

        }

        public function action_save_all()
        {
            $segmen2        = $this->input->post('segmen2');
            $product        = $this->input->post('product_id');
            $hargaid        = $this->input->post('harga_id');

            // Pastikan hargaid ada agar tidak terjadi loop error
            if (!empty($hargaid) && is_array($hargaid)) {

                // Ambil semua input yang dibutuhkan
                $detail_product     = $this->input->post('detail_product');
                $rangeid            = $this->input->post('range_id');
                $ket1               = $this->input->post('ket_1');
                $hpp                = $this->input->post('hpp');
                $jml_minimum        = $this->input->post('jml_minimum');
                $harga1_raw         = $this->input->post('harga_1');
                $harga2_raw         = $this->input->post('harga_2');
                $harga3_raw         = $this->input->post('harga_3');
                $jenisprint_id      = $this->input->post('jenisprint_id');
                $side_id            = $this->input->post('side_id');

                // print_r($detail_product);

                // Format harga jadi integer
                $harga1 = array_map(function($val) {
                    return (int) str_replace('.', '', $val);
                }, (array) $harga1_raw);

                $harga2 = array_map(function($val) {
                    return (int) str_replace('.', '', $val);
                }, (array) $harga2_raw);

                $harga3 = array_map(function($val) {
                    return (int) str_replace('.', '', $val);
                }, (array) $harga3_raw);

                // Loop untuk update data
                $berhasil = true; // Penanda status global

                foreach ($hargaid as $i => $id) {
                    if (empty($id)) continue;

                    $update = [
                        'detail_product'    => $detail_product[$i] ?? '',
                        'jml_minimum'       => $jml_minimum[$i] ?? 0,
                        'range_id'          => $rangeid[$i] ?? 0,
                        'harga_1'           => $harga1[$i] ?? 0,
                        'harga_2'           => $harga2[$i] ?? 0,
                        'harga_3'           => $harga3[$i] ?? 0,
                        'ket_1'             => $ket1[$i] ?? 0,
                        'hpp'               => $hpp[$i] ?? 0,
                        'jenisprint_id'     => $jenisprint_id[$i] ?? 0,
                        'side_id'           => $side_id[$i] ?? 0,
                        'finishing_id'      => 0,
                        'total_step'        => 0,
                        'routing_id'        => 0,
                        'is_active'         => '1',
                    ];

                    $this->db->where('harga_id', $id);
                    $update_status = $this->db->update('tbl_harga_product', $update);

                    if (!$update_status) {
                        $berhasil = false;
                        echo "❌ Gagal update ID: $id<br>";
                        echo $this->db->last_query()."<br>";
                        echo $this->db->error()['message']."<br>";
                        break;
                    }
                }

                // Setelah semua looping selesai, baru redirect
                if ($berhasil) {
                    $this->session->set_flashdata('success', 'Data berhasil diupdate');
                    redirect('manufaktur/skala-harga/' . $product);
                }


                
            }
        }




        function copy_product(){
            $controller         = $this->uri->segment(1);
            $kode               = $this->uri->segment(3);
            $data['table']      = 'tbl_bahan';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Tambah Data Product',
                // 'id'            => $this->M_master->getData()->row_array(),
                // 'bahan'         => $this->db->get('tbl_bahan')->result(),
                // 'kategori'      => $this->M_master->get_kategori()->result(),
                // 'waktu'         => $this->db->get('tbl_waktu')->result(),
                'getproduct'    => $this->M_master->getprodukbykode($kode)->row_array(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'product'       => $this->M_master->getProduct($kode)->row_array(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                'getHarga'      => $this->M_master->getHarga($kode)->result(),
                'jmlHarga'      => $this->M_master->getHarga($kode)->num_rows(),
                'getRange'      => $this->db->get('tbl_range')->result(),
                'mesin'         => $this->db->get('tbl_mesin')->result(),
                'getmata'       => $this->db->get('tbl_mata_cutting')->result(),
                'side'          => $this->db->get('tbl_side')->result(),
                
            );

            $data['subkategori'] = $this->M_master->get_subkategori($data['product']['kategori_id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/product/form_copy', $data);
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

        public function del_harga($id, $product_id)
        {
            // Cek apakah ID dan product valid
            if (empty($id) || empty($product_id)) {
                $this->session->set_flashdata('error', 'Data tidak valid.');
                redirect('manufaktur/skala-harga/' . $product_id);
                return;
            }

            // Hapus data harga berdasarkan ID
            $this->db->where('harga_id', $id);
            $delete = $this->db->delete('tbl_harga_product');

            if ($delete) {
                $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus data.');
            }

            redirect('manufaktur/skala-harga/' . $product_id);
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

        public function updaterouting($id){
            $controller         = $this->uri->segment(1);
            $data['table']      = 'tbl_bahan';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Edit Routing Product',
                'id'            => $this->M_master->getData()->row_array(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'waktu'         => $this->db->get('tbl_waktu')->result(),
                'satuan'        => $this->db->get('tbl_satuan')->result(),
                'step'          => $this->db->get('tbl_operator')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('user_roles', array('user_id'=>$userid))->row_array(),
                'routing'       => $this->db->get_where('routing', array('routing_id' => $id))->row_array(),
                'product_list'  => $this->db->get('tbl_product')->result(),
                'mesin_list'    => $this->db->get('tbl_mesin')->result(),
                
            );

            $data['subkategori'] = $this->M_master->get_subkategori($data['product']['kategori_id']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/manufaktur/update_routing', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function action_update_routing($id)
        {
            print_r($id);

            $this->form_validation->set_rules('routing_name', 'Routing Name', 'required');
            $this->form_validation->set_rules('product_id', 'Product', 'required|numeric');
            $this->form_validation->set_rules('routing_urutan', 'Routing Urutan', 'required|numeric');
            $this->form_validation->set_rules('mesin_id', 'Mesin', 'required|numeric');
            $this->form_validation->set_rules('durasi', 'Durasi', 'required|numeric');

            $data = [   
                'routing_name'      => $this->input->post('routing_name'),
                'product_id'        => $this->input->post('product_id'),
                'routing_urutan'    => $this->input->post('routing_urutan'),
                'mesin_id'          => $this->input->post('mesin_id'),
                'durasi'            => $this->input->post('durasi'),
                'keterangan'        => $this->input->post('keterangan'),
                'is_active'         => $this->input->post('is_active') ? 1 : 0,
                'created_at'        => $this->input->post('created_at'),
            ];

            print_r($data);

            $this->M_routing->update($id, $data);
            $this->session->set_flashdata('success', 'Data routing berhasil diperbarui.');
            redirect('manufaktur/routing');
            
        }

        public function edit_product(){
            $controller     = $this->uri->segment(1);
            $kode           = $this->uri->segment(3);
            $segmen2        = $this->uri->segment(2);

            // print_r($id);

            $data['table']  = 'tbl_bahan';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'controller'        => $this->uri->segment(1),
                'title'             => 'Update Product',
                'satuan'            => $this->db->get('tbl_satuan')->result(),  
                'getproduct'        => $this->M_master->getprodukbykode($kode)->row_array(),
                'getProduct'        => $this->M_master->getprodukbykode($kode)->result(),
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'getHarga'          => $this->M_master->getHarga($kode)->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'bahan'             => $this->db->get('tbl_bahan')->result(),
                'satuan'            => $this->db->get('tbl_satuan')->result(),
                'waktu'             => $this->db->get('tbl_waktu')->result(),
                'step'              => $this->db->get('tbl_operator')->result(),
                'type'              => $this->db->get('tbl_type')->result(),
                'perusahaan'        => $this->db->get('tbl_perusahaan')->result(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'jmlHarga'          => $this->M_master->getHarga($id)->num_rows(),
                'getRange'          => $this->db->get('tbl_range')->result(),
                'mesin'             => $this->db->get('tbl_mesin')->result(),
                'getmata'           => $this->db->get('tbl_mata_cutting')->result(),
                'side'              => $this->db->get('tbl_side')->result(),
                'segment2'          => $segmen2,
                'sisi'              => $this->db->get('tbl_side')->result(),
            );

            // print_r($data['getproduct']);
            
            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/product/form_update', $data);
            $this->load->view('layout_admin/footer');
            
        }
        
    }
    
?>