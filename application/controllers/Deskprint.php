<?php 
    //error_reporting(0);
    defined('BASEPATH') OR exit('No direct script access allowed');

    class deskprint extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Jakarta");
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
                $this->load->model('M_transaksi');
                $this->load->model('M_pembayaran');
                $this->load->model('M_master');
                $user_img = $this->session->userdata('user_img');
            }
            
        }

        public function search_konsumen() {
            $keyword = $this->input->get('q');
            $results = $this->M_master->search_by_keyword($keyword);
            echo json_encode($results);
        }

        public function search_product() {
            $keyword = $this->input->get('q');
            $result = $this->M_master->search_product($keyword);
            echo json_encode($result);
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
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Dashboard Utama Kasir',
           
                'table'                 => 'tbl_kategori',
                'tampilData'            => $this->M_master->getDataProduct()->result(),
                'total_rows'            => $this->M_master->getDataProduct()->num_rows(),
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'              => $conf['hakakses']['divisi_nama'],
                'logo'                  => $conf['perusahaan']['logo'],
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'total_transaksi'       => $this->M_transaksi->get_transaksi()->row_array(),
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),

                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/index', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }


        public function load_transaksi($nospk)
        {
            $data['transaksi'] = $this->M_transaksi->tampilTmp($nospk)->result();

            // Load view sebagai fragment tbody
            $this->load->view('admin/deskprint/tmp_body', $data);
        }


        public function loadsummary($nospk)
        {
            $this->db->select('t.temp_qty, t.temp_panjang, t.temp_lebar, h.harga_1');
            $this->db->from('tbl_temp_transaksi t');
            $this->db->join('tbl_harga_product h', 't.harga_id = h.harga_id');
            $this->db->where('t.no_spk', $nospk);
            $query = $this->db->get()->result();

            $total = 0;
            $jml_item = count($query);

            foreach ($query as $row) {
                $harga_satuan = $row->harga_1; // fix nama field

                if ($row->temp_panjang != 0 && $row->temp_lebar != 0) {
                    $subtotal = $row->temp_qty * $row->temp_panjang * $row->temp_lebar * $harga_satuan;
                } else {
                    $subtotal = $row->temp_qty * $harga_satuan;
                }

                $total += $subtotal;
            }

            $response = [
                'total_harga' => $total,
                'jml_item'    => $jml_item
            ];

            // Debugging
            log_message('debug', 'Response Summary: ' . json_encode($response));

            // Output sebagai JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }


        public function add($kode){
            $table              = 'tbl_product';
            $user               = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'transaksi'     => $this->uri->segment(3),
                'kategorina'    => $this->uri->segment(4),
                'title'         => 'Dashboard Deskprint',
            
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->getDataProduct()->result(),
                'total_rows'    => $this->M_master->getDataProduct()->num_rows(),
                
                'kategori'      => $this->db->get('tbl_kategori')->result(),
                'konsumen'      => $this->db->get_where('tbl_konsumen', array('perusahaan_id' => $this->session->userdata('perusahaan_id')))->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),
                'tampilTmp'     => $this->M_transaksi->tampilTmp($kode)->result(),
                'jmlTmp'        => $this->M_transaksi->tampilTmp($kode)->num_rows(),
                'dataTmp'       => $this->M_transaksi->tampilTmp($kode)->row_array(),
                'kode'          => $kode,
                'max'           => $this->M_transaksi->getNoSPK()->row_array()['id'],
                'deskprint_id'  => $this->session->userdata('id'),
                'paketBanner'   => $this->db->get('tbl_paket_banner')->result(),
                'paketdigital'  => $this->db->get('tbl_paket_digital')->result(),
                'warnakaos'     => $this->db->get('tbl_warna_kaos')->result(),
                'sizekaos'      => $this->db->get('tbl_size_kaos')->result(),
                'ukuranfile'    => $this->db->get('tbl_ukuran_file')->result(),
                'side'          => $this->db->get('tbl_side')->result(),
                'finishinga3'   => $this->db->get('tbl_finishing_digital')->result(),
                'bahan'         => $this->db->get('tbl_bahan')->result(),
                'warna'         => $this->db->get('tbl_warna')->result(),
                'mesin'         => $this->db->get('tbl_mesin')->result(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );      

            if ($this->input->post('konsumen_id')) {
                $konsumen = ($this->input->post('konsumen_id'));
                $update = $this->M_transaksi->setKonsumen($konsumen, $kode);
                redirect('transaksi/add/'.$kode);
            }

            $idSPK      = $data['max']+1;
            $idKons     = $data['dataTmp']['konsumen_id'];
            
            $store      = $this->session->userdata('perusahaan_id');
        
            
            $data['noSPK'] = $store .date('dmy'). $user . $idSPK;

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/add_transaksi', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function get_sub_category(){
            $category_id = $this->input->post('id');
            $data = $this->M_transaksi->get_sub_category($category_id)->result();
            
            echo json_encode($data);
        }

        public function action_add_temp(){
            $inputs = [
                'kategori'      => $this->input->post('kategori_id'),
                'subkategori'   => $this->input->post('subkategori_id'),
                'bahan'         => $this->input->post('bahan_id'),
                'qty'           => $this->input->post('qty'),
                'user'          => $this->input->post('user_id'),
                'keterangan'    => $this->input->post('keterangan'),
                'panjang'       => $this->input->post('panjang'),
                'lebar'         => $this->input->post('lebar'),
                'ket_1'         => $this->input->post('ket_1'),
                
                'finishing'     => $this->input->post('finishing'),
                'nospk'         => $this->input->post('nospk'),
                'approve'       => $this->input->post('approve'),
                'product'       => $this->input->post('product_id'),
            ];

            if (!empty($inputs['ket_1']) && $inputs['ket_1'] != 0) {
                    $hargaQuery = $this->M_transaksi->cekHargaProductB($inputs['product'], $inputs['qty'], $inputs['ket_1']);
                
            } else {
                $hargaQuery = $this->M_transaksi->cekHargaProductD($inputs['product'], $inputs['qty']);
            }

            $cekhargaproduct = $hargaQuery->row_array();
            $hasilcek        = $hargaQuery->num_rows();


            if (!empty($hasilcek)) {
                $add_temp = [
                    'product_id'     => $inputs['product'],
                    'no_spk'         => $inputs['nospk'],
                    'temp_qty'       => $inputs['qty'],
                    'harga_id'       => $cekhargaproduct['harga_id'],
                    'user_id'        => $this->session->userdata('id'),
                    'keterangan'     => $inputs['keterangan'],
                    'temp_panjang'   => $inputs['panjang'],
                    'temp_lebar'     => $inputs['lebar'],
                    'perusahaan_id'  => $this->session->userdata('perusahaan_id'),
                    'approve'        => '1',
                ];

               
                if ($this->db->insert('tbl_temp_transaksi', $add_temp)) {
                    $response = ['status' => 'success', 'message' => 'Data berhasil disimpan'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Gagal menyimpan data ke database'];
                }

            } else {
                $response = ['status' => 'error', 'message' => 'Data harga tidak ditemukan'];
            }

            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }

        public function delete_temp_item() {
            $temp_id = $this->input->post('temp_id');
            $this->db->where('temp_id', $temp_id);
            $this->db->delete('tbl_temp_transaksi'); // sesuaikan dengan nama tabel

            echo json_encode(['status' => 'success']);
        }

        public function pending(){
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
                'title'         => 'Transaksi Pending',
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view($controller.'/pending', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function add_pemesanan(){
        
            $nospk          = $this->input->post('nospk');
            $konsumen       = $this->input->post('konsumen_id');
            $pemesanan      = $this->input->post('total_pemesanan');

            
            // Ambil data dari temporary
            $detailPemesanan = $this->M_transaksi->tampilTmp($nospk)->result();
            foreach ($detailPemesanan as $tmp) {
                $this->db->insert('tbl_pemesanan_detail', [
                    'product_id'      => $tmp->product_id,
                    'harga_id'        => $tmp->harga_id,
                    'qty'             => $tmp->temp_qty,
                    'mesin_id'        => $tmp->mesin_id,
                    'finishing_id'    => $tmp->finishing_id,
                    'panjang'         => $tmp->temp_panjang,
                    'lebar'           => $tmp->temp_lebar,
                    'dateline_tgl'    => $tmp->dateline_tgl,
                    'dateline_jam'    => $tmp->dateline_jam,
                    'nospk'           => $nospk,
                    'diskon'          => $tmp->temp_diskon,
                ]);
            }

            $dataPemesanan = [
                'nospk'             => $nospk,
                'jml_pemesanan'     => $pemesanan,
                'tgl_pemesanan'     => $this->input->post('transaksi_tgl'),
                'jam_pemesanan'     => $this->input->post('transaksi_jam'),
                'konsumen_id'       => $konsumen,
                'id_jenis_transaksi'=> $this->input->post('id_jenis_transaksi'),
                'marketplace_id'    => $this->input->post('marketplace_id'),
                'resi_marketplace'  => $this->input->post('resi_marketplace'),
                'deskprint_id'      => $this->input->post('deskprint_id'),
                'perusahaan_id'     => $this->session->userdata('perusahaan_id'),
            ];

            $cekTransaksi = $this->db->get_where('tbl_pemesanan', ['nospk' => $nospk])->row();

            if ($cekTransaksi) {
                // Update jika data sudah ada
                $this->M_transaksi->update('tbl_pemesanan', $dataPemesanan, ['nospk' => $nospk]);
                redirect('deskprint/createspk/' . $nospk);
            } else {
                // Insert baru
                $this->db->insert('tbl_pemesanan', $dataPemesanan);

                $this->M_transaksi->deleteTmp($nospk);
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
                redirect('deskprint/transaksi_deskprint');
            }
            
            
        }

        function transaksi_deskprint(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Dashboard Deskprint',
                
                'table'                 => 'tbl_kategori',
                // 'tampilData'            => $this->M_transaksi->getDataPemesanan()->result(),
                'total_rows'            => $this->M_transaksi->getDataPemesanan()->num_rows(),
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'              => $conf['hakakses']['divisi_nama'],
                'logo'                  => $conf['perusahaan']['logo'],
                'tampilData'            => $this->M_transaksi->transaksideskprint()->result(),
                'total_belumbayar'      => $this->M_transaksi->transaksideskprint()->num_rows(),
                // 'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                // 'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                // 'menu'                  => $this->db->get('menu')->result(),
                // 'submenu'               => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header', $data);
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/deskprint/transaksi_deskprint', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        
        }

        public function pembayaran(){
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Daftar Pemesanan',
              
                'table'                 => 'tbl_kategori',
                'tampilData'            => $this->M_transaksi->getDataPemesanan()->result(),
                'total_rows'            => $this->M_transaksi->getDataPemesanan()->num_rows(),
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'              => $conf['hakakses']['divisi_nama'],
                'logo'                  => $conf['perusahaan']['logo'],
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header', $data);
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/'.$function, $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function transaksi_belumbayar(){
            $table              = 'tbl_product';
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            print_r($this->session->userdata('level'));

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Daftar Pemesanan',
            
                'table'                 => 'tbl_kategori',
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getDataPemesanankasir('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getDataPemesanankasir('1')->num_rows(),
            
                'perusahaan'            => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'              => $conf['hakakses']['divisi_nama'],
                'logo'                  => $conf['perusahaan']['logo'],
                'level'                 => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'                  => $this->db->get('menu')->result(),
                'submenu'               => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/transaksi_belumbayar', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function transaksi_sudahbayar(){
            $table              = 'tbl_product';
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            print_r($this->session->userdata('level'));

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Daftar Semua Transaksi',
            
                'table'                 => 'tbl_kategori',
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
           
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/transaksi_sudahbayar', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function transaksi_cash(){
            $table              = 'tbl_product';
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            print_r($this->session->userdata('level'));

            $data = array(
                'controller'            => $this->uri->segment(1),
                'function'              => $this->uri->segment(2),
                'title'                 => 'Daftar Transaksi Cash',
           
                'table'                 => 'tbl_kategori',
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
         
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/transaksi_sudahbayar', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function bayar($nospkna){
            $table              = 'tbl_product';
            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            //print_r($this->uri->segment(3));
            $nospk              = decrypt_url($nospkna);
            //echo "$nospk";

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
                'getdata'       => $this->M_transaksi->getDetailPemesanan()->row_array(),
                'getdetail'     => $this->M_transaksi->getDetail()->result(),
              
                'rekening'      => $this->db->get('tbl_rekening')->result(),
                'ewallet'       => $this->db->get('tbl_ewallet')->result(),
                'hariini'       => date('Y-m-d'),
                'jamini'        => date('H:i:s'),

                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                
            );

            if($this->input->post('dateline_tgl')){
                $id             = $this->input->post('id');
                $dateline_tgl   = $this->input->post('dateline_tgl');
                $dateline_jam   = $this->input->post('dateline_jam');
                $dateline = $dateline_tgl.' '.$dateline_jam;

                $data = array(
                    'dateline_tgl'    => $dateline_tgl,
                    'dateline_jam'    => $dateline_jam,
                );
                $this->db->where('id', $id);
                $this->db->update('tbl_pemesanan_detail', $data);

                $nospk = encrypt_url($nospk);
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('transaksi/bayar/'.$nospk);
             }

            // $data['detailflow'] = $this->M_transaksi->getDetailFlow($data['getdetail']['product_id'])->row_array();


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/'.$function, $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function action_bayar()
        {
            $post       = $this->input->post(NULL, TRUE);
            $perusahaan = $this->session->userdata('perusahaan_id');
            $userid     = $this->session->userdata('id');

            $this->load->model('M_pembayaran');
            $this->load->library('ciqrcode');

            $result = $this->M_pembayaran->prosesTransaksi($post, $perusahaan, $userid);

            // echo '<pre>';
            //     print_r($result);
            //     print_r($post);
            //     exit;

            if ($result['status'] == 'success') {
                $this->session->set_flashdata('success', $result['message']);
                redirect(base_url('transaksi/cetak_invoice/' . $post['nospk']));
            } else {
                $this->session->set_flashdata('error', $result['message']);
                redirect('transaksi/bayar');
            }
        }


        public function cetak_invoice($nospk)
        {
            $perusahaanId = $this->session->userdata('perusahaan_id');
            $level        = $this->session->userdata('level');

            // Ambil data konfigurasi terkait perusahaan dan hak akses
            $perusahaan  = $this->db->get_where('tbl_perusahaan', ['id_perusahaan' => $perusahaanId])->row_array();
            $hakakses    = $this->db->get_where('tbl_divisi', ['divisi_id' => $level])->row_array();

            // Ambil data transaksi
            $pembayaran   = $this->M_transaksi->getPembayaran($nospk)->row_array();
            $detailBayar  = $this->M_transaksi->getDetailPembayaran($nospk)->result();

            // Siapkan data untuk view
            $data = [
                'title'        => 'Cek Invoice',
                'perusahaan'   => $perusahaan,
                'hakakses'     => $hakakses['divisi_nama'],
                'pembayaran'   => $pembayaran,
                'detailBayar'  => $detailBayar,
            ];

            // Tampilkan view cetak invoice
            $this->load->view('admin/transaksi/cetak_invoice', $data);
        }


        function cetak_invoice_ulang($nospk){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $data = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan' => $perusahaan))->row_array(),
                'pembayaran'    => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            // print_r($data);

            $this->load->view('admin/transaksi/cetak_invoice_ulang', $data);
        }

        function cek_invoice($nospk, $id){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            $data = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan' => $perusahaan))->row_array(),
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Transaksi || Operator',
                'pembayaran'    => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'detailprod'    => $this->M_transaksi->detailProduksina($id)->result(),
                'cekproduksi'   => $this->M_transaksi->cekproduksi($id)->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/cek_invoice', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function cek_pb($nospk){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan' => $perusahaan))->row_array(),
                'pembayaran'    => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'detailprod'    => $this->M_transaksi->detailpengambilan($nospk)->result(),
                'cekproduksi'   => $this->M_transaksi->cekproduksi($id)->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/cek_pb', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function produksi(){
            $user   = $this->session->userdata('id');
            $divisi = $this->session->userdata('level');
            $userid             = $this->session->userdata('id');

            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Produksi Product',
         
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getProduksina()->result(),
                'total_rows'    => $this->M_transaksi->getProduksina()->num_rows(),
          
                'user'          => $user,
                'divisi'        => $divisi,
                'logo'          => $conf['perusahaan']['logo'],
                'operator'      => $this->db->get('tbl_operator')->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            //print_r($data);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/produksi', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function op_produksi($op){
            $user   = $this->session->userdata('id');
            $divisi = $this->session->userdata('level');
            $userid             = $this->session->userdata('id');
        
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Produksi Product',
           
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getOPProduksina($op)->result(),
                'total_rows'    => $this->M_transaksi->getOPProduksina($op)->num_rows(),
             
                'user'          => $user,
                'divisi'        => $divisi,
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'operator'          => $this->db->get('tbl_operator')->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            //print_r($data);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('transaksi/produksi', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function proses_produksi(){
            $invoice        = $this->input->post('nospk');
            $produksiid     = $this->input->post('produksi_id');
            $userid             = $this->session->userdata('id');
            $update = [
                'status_produksi'   => $this->input->post('status_produksi'),
            ];

            $where  = [
                'produksi_id'       => $this->input->post('produksi_id'),
            ];

            $this->db->update('tbl_produksi', $update, $where);

            redirect('transaksi/cek_invoice/'.$invoice.'/'.$produksiid);
        }

        function produksi_done(){
            $invoice        = $this->input->post('nospk');
            $produksiid     = $this->input->post('produksi_id');
            $update = [
                'status_produksi'   => $this->input->post('status_produksi'),
            ];

            $where  = [
                'produksi_id'       => $this->input->post('produksi_id'),
            ];

            $this->db->update('tbl_produksi', $update, $where);

            redirect('transaksi/cek_invoice/'.$invoice.'/'.$produksiid);
            

        }

        public function pengambilan_barang(){
            $user               = $this->session->userdata('id');
            $divisi             = $this->session->userdata('level');
            $userid             = $this->session->userdata('id');
            
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );
            

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pengambilan Barang',
             
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getPengambilanAll()->result(),
            
                'user'          => $user,
                'divisi'        => $divisi,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_bar');
            // $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('transaksi/pengambilan_barang', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }


        function get_finishing(){
            $id=$this->input->post('id');
            $data=$this->M_transaksi->get_finishing($id);
            echo json_encode($data);
        }

        function get_largeformat(){
            $id=$this->input->post('id');
            $data=$this->M_transaksi->get_largeformat($id);
            echo json_encode($data);
        }

        function spk_finishing($nospk){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $data = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan' => $perusahaan))->row_array(),
                'pembayaran'    => $this->M_transaksi->getPembayaran($nospk)->row_array(),
                'detailBayar'   => $this->M_transaksi->getDetailPembayaran($nospk)->result(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            // print_r($data);

            $this->load->view('transaksi/spk_finishing', $data);
        }

        function pbarang(){
            $user               = $this->session->userdata('id');
            $userid             = $this->session->userdata('id');
            $divisi             = $this->session->userdata('level');
            $table              = 'tbl_product';
            $controller         = $this->uri->segment(1);
            
            $conf               = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Pengambilan Barang   ',
            
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getPB()->result(),
                'total_rows'    => $this->M_transaksi->getPB()->num_rows(),
             
                'user'          => $user,
                'divisi'        => $divisi,
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            //print_r($data);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            // $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/transaksi/pbarang', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function action_pengambilan(){
            $status     = $this->input->post('status');
            $id         = $this->input->post('id');
            $nospk     = $this->input->post('nospk');

            foreach ($status as $i => $stt) {
                $update     = array(
                    'status_produksi' => "$status[$i]",
                );
    
                $where = array(
                    'produksi_id' => $id[$i],
                );
                
                $update = $this->db->update('tbl_produksi', $update, $where);
                print_r($update);
                if ($update){
                    redirect('transaksi/cek_pb/'.$nospk);
                }
            }
        }


        public function daftarkonsumen(){
            $controller         = $this->uri->segment(1);
            $function           = $this->uri->segment(2);
            $userid             = $this->session->userdata('id');
            $table              = 'tbl_konsumen';
            $data['order']      = 'konsumen_nama';
            $data['id']         = 'kategori_id';

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Konsumen',
            
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_master->tampilData($table, $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilData($table, $data['order'])->num_rows(),
            
                'logo'          => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),

            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/konsumen/index', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        public function penjualan(){
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
                'title'         => 'Transaksi Penjualan',
            
                'table'         => 'tbl_kategori',
                'tampilData'    => $this->M_transaksi->getPenjualan()->result(),
                'total_rows'    => $this->M_transaksi->getPenjualan()->num_rows(),
                'total_trx'     => $this->M_transaksi->getTotalTrx()->row_array(),
             
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'transaksi_belumbayar'  => $this->M_transaksi->getDataPemesanankasir('0')->result(),
                'total_belumbayar'      => $this->M_transaksi->getDataPemesanankasir('0')->num_rows(),
                'transaksi_sudahbayar'  => $this->M_transaksi->getbayarsukses('1')->result(),
                'total_sudahbayar'      => $this->M_transaksi->getbayarsukses('1')->num_rows(),
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header', $data);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/'.$controller.'/penjualan/index', $data);
            $this->load->view('layout_admin/right_sidebar');
            $this->load->view('layout_admin/footer');
        }

        function createspk(){
            $userId         = $this->session->userdata('id');
            $perusahaanId   = $this->session->userdata('perusahaan_id');
            $levelId        = $this->session->userdata('level');
            $nospk          = $this->uri->segment(3);
            $controller     = $this->uri->segment(1);
            $kodeproduk     = $this->input->get('kodeproduk');

            // Ambil data yang sering dipakai
            $perusahaan     = $this->db->get_where('tbl_perusahaan', ['id_perusahaan' => $perusahaanId])->row_array();
            $divisi         = $this->db->get_where('tbl_divisi', ['divisi_id' => $levelId])->row_array();
            $spk            = $this->db->get_where('tbl_spk', ['nospk' => $nospk])->row_array();
            $konsumen       = $this->M_transaksi->getkonsumen($spk['konsumen_id'])->row_array();
            $tmpData        = $this->M_transaksi->tampilTmp($nospk);

            // Siapkan data untuk view
            $data = [
                'controller'        => $controller,
                'function'          => $this->uri->segment(2),
                'nospk'             => $nospk,
                'title'             => 'Dashboard Deskprint',
                
                'tampilData'        => $this->M_master->getDataProduct()->result(),
                'total_rows'        => $this->M_master->getDataProduct()->num_rows(),
                'kategori'          => $this->db->get('tbl_kategori')->result(),
                'subkategori'       => $this->db->get('tbl_subkategori')->result(),
                'konsumen'          => $this->db->get('tbl_konsumen')->result(),

                'hariini'           => date('Y-m-d'),
                'jamini'            => date('H:i:s'),
                'tampilTmp'         => $tmpData->result(),
                'jmlTmp'            => $tmpData->num_rows(),
                'dataTmp'           => $tmpData->row_array(),

                'deskprint_id'      => $userId,
                'perusahaan'        => $perusahaan['nama_perusahaan'],
                'perusahaan_id'     => $perusahaan['id_perusahaan'],
                'hakakses'          => $divisi['divisi_nama'],
                'logo'              => $perusahaan['logo'],

                'total_pemesanan'   => $this->M_transaksi->total_trx($nospk)->row_array(),
                'getkosumen'        => $konsumen,
                'getproduct'        => $this->M_master->getDataProduct()->result(),
                'getproduk'         => $this->db->get_where('tbl_product', ['product_id' => $kodeproduk])->row_array(),

                'cek_transaksi'     => $this->db->get_where('tbl_pemesanan', ['nospk' => $nospk])->num_rows(),
                'level'             => $this->db->get_where('users', ['user_id' => $userId])->row_array(),
                'bahan'             => $this->db->get('tbl_bahan')->result(),
                'tipe'              => $this->db->get('tbl_type')->result(),
                'side'              => $this->db->get('tbl_side')->result(),
                'mata'              => $this->db->get('tbl_mata_cutting')->result(),
                'lebarkain'         => $this->db->get('tbl_lebar_textile')->result(),
            ];

            $this->load->view('layout_admin/head_deskprint', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar_deskprint', $data);
            $this->load->view('layout_admin/breadcumb', $data);
            $this->load->view('admin/deskprint/createspk', $data);
            $this->load->view('layout_admin/footer');

        }

        function step_satu(){  
            $userId      = $this->session->userdata('id');
            $perusahaan  = $this->session->userdata('perusahaan_id');
            $konsumen    = $this->input->post('konsumen_id');

            // Ambil nomor urut SPK terakhir lalu increment
            $lastUrut    = $this->M_transaksi->getNoSPK($userId, $perusahaan)->row_array();
            $noUrutSPK   = $lastUrut['no_urut_spk'] + 1;

            // Generate nospk format
            $kodeSPK     = $perusahaan . date('dmy') . $userId . $noUrutSPK;
            $newSPK      = $perusahaan . '-' . $userId . '-' . $noUrutSPK . '-' . date('my');

            // Data untuk insert SPK
            $addSPK = [
                'nospk'             => $newSPK,
                'user_id'           => $userId,
                'no_urut_spk'       => $noUrutSPK,
                'konsumen_id'       => $konsumen,
                'metode_pesan'      => $this->input->post('id_jenis_transaksi'),
                'id_marketplace'    => $this->input->post('id_marketplace'),
                'resi_marketplace'  => $this->input->post('resi_marketplace'),
                'perusahaan_id'     => $perusahaan,
            ];

            // Simpan dan redirect
            $this->db->insert('tbl_spk', $addSPK);
            redirect('transaksi/createspk/' . $newSPK);
        }
        
    }
?>