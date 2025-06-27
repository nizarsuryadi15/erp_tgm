<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Karyawan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table = 'tbl_kategori';
        }

        public function index(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');
            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Dashboard Human Resourse',
                'table'             => 'tbl_kategori',
                'bulanini'          => date('m'),
                'tampilData'        => $this->M_gudang->getStokgudang()->result(),
                'logo'              => $conf['perusahaan']['logo'],
                'total_karyawan'    => $this->db->get('tbl_karyawan')->num_rows(),
                'total_akun'        => $this->db->get('users')->num_rows(),
                'total_laki'        => $this->db->get_where('tbl_karyawan', array('jenis_kelamin'=>'L'))->num_rows(),
                'total_pere'        => $this->db->get_where('tbl_karyawan', array('jenis_kelamin'=>'P'))->num_rows(),
                'total_deskprint'   => $this->db->get_where('tbl_karyawan', array('jabatan_id'=>'4'))->num_rows(),
                'total_kasir'       => $this->db->get_where('tbl_karyawan', array('jabatan_id'=>'5'))->num_rows(),
                'total_operator'    => $this->db->get_where('tbl_karyawan', array('jabatan_id'=>'6'))->num_rows(),
                
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                
            );

            $data['logs']           = $this->db->order_by('login_time', 'DESC')->get('user_log')->result();

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header',$data);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/index', $data);
            $this->load->view('layout_admin/footer');
        }
        
        public function karyawan(){
            $controller     = $this->uri->segment(1);
            $table              = 'tbl_karyawan';
            $data['order']      = 'karyawan_id';
            $data['id']         = 'kategori_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Karyawan',
                'table'         => 'tbl_karyawan',
                'karyawan'      => $this->M_master->get_karyawan()->result(),
                'jml'           => $this->M_master->get_karyawan()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/karyawan/karyawan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function penilaian_kinerja(){
            // $controller     = $this->uri->segment(1);
            // $table              = 'tbl_karyawan';
            // $data['order']      = 'karyawan_id';
            // $data['id']         = 'kategori_id';
            // $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Kinerja Karyawan',
                'table'         => 'tbl_karyawan',
                'karyawan'      => $this->M_master->get_karyawan_jabatan('4')->result(),
                'jml'           => $this->M_master->get_karyawan_jabatan('4')->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/kinerja_karyawan', $data);
            $this->load->view('layout_admin/footer');
        }


        public function absen_lembur(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Absensi Lembur',
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'      => $this->M_master->get_lembur()->result(),
                'jml'           => $this->M_master->get_lembur()->num_rows(),
                'listkaryawan'  => $this->db->get('tbl_karyawan')->result(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/absen_lembur', $data);
            $this->load->view('layout_admin/footer');
        }


        function update_status_ajax(){
            $id     = $this->input->post('id');
            $status = $this->input->post('status');

            $this->db->where('id', $id);
            $this->db->update('tbl_lembur', ['status' => $status]);

            echo json_encode(['success' => true]);
        }

        public function pengajuan_lembur(){
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
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'karyawan'          => $this->M_master->karyawan_lembur()->result(),
                'jml'               => $this->M_master->karyawan_lembur()->num_rows(),
                'listkaryawan'      => $this->db->get('tbl_karyawan')->result(),
                'karyawan_terpilih' => $this->db->get_where('tbl_karyawan', array('karyawan_id'=>$karyawan))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/pengajuan_lembur', $data);
            $this->load->view('layout_admin/footer');
        }

        public function absen_karyawan(){
            $controller         = $this->uri->segment(1);
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Absensi Karyawan',
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'absensi'       => $this->Absensi_model->get_all_absensi(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/absen_karyawan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function aksi_simpan_lembur()
        {
            $jam_mulai      = $this->input->post('jam_mulai');
            $jam_selesai    = $this->input->post('jam_selesai');

            if ($jam_mulai >= $jam_selesai) {
                $this->session->set_flashdata('error', 'Jam selesai harus lebih besar dari jam mulai.');
                redirect('karyawan/pengajuan_lembur'); // Kembali ke form
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
            redirect('karyawan/pengajuan_lembur');
        }



        public function jabatan(){
            $controller     = $this->uri->segment(1);
            $table              = 'tbl_karyawan';
            $data['order']      = 'karyawan_id';
            $data['id']         = 'kategori_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Jabatan',
                'table'         => 'tbl_karyawan',
                'jabatan'       => $this->db->get('tbl_jabatan')->result(),
                'jml'           => $this->db->get('tbl_jabatan')->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/jabatan', $data);
            $this->load->view('layout_admin/footer');
        }

        public function tambah_karyawan(){
            $controller         = $this->uri->segment(1);
            $kode               = $this->uri->segment(3);
            $table              = 'tbl_karyawan';
            $data['id']         = 'karyawan_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'getlist'       => $this->db->get_where('tbl_karyawan', array('karyawan_id' => $kode))->row_array(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $data['karyawan']   = $this->M_master->get_by_id($kode);
            $data['jabatan']    = $this->M_master->get_all_jabatan();

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/tambah_karyawan', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function tambah_jabatan(){

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/tambah_jabatan', $data);
            $this->load->view('layout_admin/footer');
            
        }

        function aksi_simpan_jabatan()
        {
            $data = [
                'nama_jabatan'  => $this->input->post('nama_jabatan'),
                'keterangan'    => $this->input->post('deskripsi'),
            ];

            print_r($data);

            $simpan = $this->db->insert('tbl_jabatan', $data);
            if ($simpan == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('karyawan/daftar-jabatan-divisi');
            }
            
        }

        public function akun(){
            $controller     = $this->uri->segment(1);
            $table              = 'users';
            $data['order']      = 'user_id';
            $data['id']         = 'user_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Akun Karyawan',
                'table'         => 'tbl_karyawan',
                'total_rows'    => $this->M_master->getUser()->num_rows(),
                'logo'          => $conf['perusahaan']['logo'],
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                'tampilData'    => $this->M_master->getUser()->result(),
                'role'          => $this->db->get('roles')->result(),
                'karyawan'      => $this->db->get('tbl_karyawan')->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/akun/index', $data);
            $this->load->view('layout_admin/footer');
            $this->load->view('layout_admin/alert');
        }

        

        function actionAdd(){
            $table              = 'tbl_konsumen';
            $controller         = $this->uri->segment(1);
            
            // print_r($controller);

            $data = array(
                'konsumen_nama'         => $this->input->post('konsumen_nama'),
                'konsumen_alamat'       => $this->input->post('konsumen_alamat'),
                'konsumen_nohp'         => $this->input->post('konsumen_nohp'),
                'konsumen_email'        => $this->input->post('konsumen_email'),
                'password'              => md5($this->input->post('konsumen_nohp')),
                'member'                => '0',
                'avatar'                => 'male.png',
                'perusahaan_id'         => $this->session->userdata('perusahaan_id')
            );
            print_r($data);

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect('transaksi/add/1');
            }
        }

        function actionDelete($id){
            
            $table              = 'tbl_konsumen';
            $data['id']         = 'kategori_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }


        public function edit_karyawan(){
            $controller         = $this->uri->segment(1);
            $kode               = $this->uri->segment(3);
            $table              = 'tbl_karyawan';
            $data['id']         = 'karyawan_id';
            $userid             = $this->session->userdata('id');

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Edit Data Keryawan',
                'getlist'       => $this->db->get_where('tbl_karyawan', array('karyawan_id' => $kode))->row_array(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $data['karyawan']   = $this->M_master->get_by_id($kode);
            $data['jabatan']    = $this->M_master->get_all_jabatan();

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/edit_karyawan', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function edit_akun(){
            $controller         = $this->uri->segment(1);
            $kode               = $this->uri->segment(3);
            print_r($kode);

            $table              = 'users';
            $userid             = $this->session->userdata('id');

             $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Akun',
                'getlist'       => $this->db->get_where($table, array('user_id' => $kode))->row_array(),
                'karyawan'      => $this->db->get('tbl_karyawan')->result(),
                'perusahaan'    => $this->db->get('tbl_perusahaan')->result(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'logo'          => $conf['perusahaan']['logo'],
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            print_r($data['getlist']);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/edit_akun', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function aksi_edit_akun(){
            $controller     = $this->uri->segment(1);
            $table          = 'users';

            $where          = array(
                'user_id'   => $this->input->post('user_id'),
            );

            
            $id             = $this->input->post('user_id');
            $password       = md5($this->input->post('password'));

            $data = array(
                'username'       => $this->input->post('username'),
                'password'       => $password,
                'email'          => $this->input->post('email'),
                'karyawan_id'    => $this->input->post('karyawan_id'),
                'perusahaan_id'  => $this->input->post('perusahaan_id'),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );
            

            $update = $this->M_master->updateData($table, $where, $data);
            

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect('karyawan/daftar-akun');
            }
        }

        public function aksi_edit_karyawan(){
            $id             = $this->input->post('karyawan_id');

            $where          = array(
                'karyawan_id' => $this->input->post('karyawan_id'),
            );

            $data = [
                    'nama_lengkap'    => $this->input->post('nama_lengkap'),
                    'nik'             => $this->input->post('nip'),
                    'jenis_kelamin'   => $this->input->post('jenis_kelamin'),
                    'tempat_lahir'    => $this->input->post('tempat_lahir'),
                    'tanggal_lahir'   => $this->input->post('tanggal_lahir'),
                    'alamat'          => $this->input->post('alamat'),
                    'telepon'         => $this->input->post('telepon'),
                    'email'           => $this->input->post('email'),
                    'tanggal_masuk'   => $this->input->post('tanggal_masuk'),
                    'status_karyawan' => $this->input->post('status_karyawan'),
                    'jabatan_id'      => $this->input->post('jabatan_id'),

                ];

                if (!empty($_FILES['foto']['name'])) {
                    $config['upload_path']   = './assets/images/karyawan/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size']      = 5048; // 2MB
                    $config['file_name']     = 'karyawan_' . time();
                    
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('foto')) {
                        $upload_data = $this->upload->data();
                        $data['foto'] = $upload_data['file_name'];

                        // Hapus foto lama (jika ada)
                        $old_foto = $this->M_master->get_by_id($id)->foto;
                        if ($old_foto && file_exists('./assets/images/karyawan/' . $old_foto)) {
                            unlink('./assets/images/karyawan/' . $old_foto);
                        }
                    } else {
                        // Jika upload gagal
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('karyawan/edit-karyawan/' . $id);
                    }
                }

            $update = $this->M_master->updateData('tbl_karyawan', $where, $data);
            print_r($update);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect('karyawan/daftar-karyawan');
            }
        }

        function viewData($id){

            $userid             = $this->session->userdata('id');
            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Update Alur Kerja',
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar');
            $this->load->view('admin/'.$controller.'/form_update', $data);
            $this->load->view('layout_admin/footer');
        }

        public function divisi(){
            $userid             = $this->session->userdata('id');

            $controller         = $this->uri->segment(1);
            $table              = 'tbl_divisi';
            $data['order']      = 'divisi_id';
            $data['id']         = 'divisi_id';

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Divisi',
                'table'         => 'tbl_divisi',
                'tampilData'    => $this->M_master->tampilsemuadata($table, $data['order'])->result(),
                'total_rows'    => $this->M_master->tampilsemuadata($table, $data['order'])->num_rows(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/divisi', $data);
            $this->load->view('layout_admin/footer');
        }


        public function kasir(){
            $userid             = $this->session->userdata('id');

            $controller             = $this->uri->segment(1);
            $table                  = 'tbl_karyawan';
            $data['order']          = 'karyawan_id';
            $data['id']             = 'kategori_id';
            $divisi                 = '4';
            $data['divisi_nama']    = 'Kasir';

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Kasir',
                'table'         => 'tbl_karyawan',
                'tampilData'    => $this->M_master->getdivisi($table, $divisi)->result(),
                'total_rows'    => $this->M_master->getdivisi($table, $divisi)->num_rows(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/kasir', $data);
            $this->load->view('layout_admin/footer');
        }

        public function deskprint(){

            $userid             = $this->session->userdata('id');
            $controller         = $this->uri->segment(1);
            $table              = 'tbl_karyawan';
            $data['order']      = 'karyawan_id';
            $data['id']         = 'kategori_id';
            $divisi             = '2';
            $data['divisi_nama']    = 'Deskprint';

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Deskprint',
                'table'         => 'tbl_karyawan',
                'tampilData'    => $this->M_master->getdivisi($table, $divisi)->result(),
                'total_rows'    => $this->M_master->getdivisi($table, $divisi)->num_rows(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/deskprint', $data);
            $this->load->view('layout_admin/footer');
        }

        public function gudang(){
            $userid             = $this->session->userdata('id');
            $controller             = $this->uri->segment(1);
            $table                  = 'tbl_karyawan';
            $data['order']          = 'karyawan_id';
            $data['id']             = 'kategori_id';
            $divisi                 = '6';
            $data['divisi_nama']    = 'Gudang';

            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => $this->uri->segment(2),
                'title'         => 'Daftar Gudang',
                'table'         => 'tbl_karyawan',
                'tampilData'    => $this->M_master->getdivisi($table, $divisi)->result(),
                'total_rows'    => $this->M_master->getdivisi($table, $divisi)->num_rows(),
                'level'         => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/gudang', $data);
            $this->load->view('layout_admin/footer');
        }

        public function penggajian() {
            $data['gaji'] = $this->Penggajian_model->get_all_penggajian();
            $this->load->view('penggajian/index', $data);
        }

        public function proses_penggajian($id_karyawan, $bulan) {
            $result = $this->Penggajian_model->proses_gaji($id_karyawan, $bulan);
            if ($result) {
                redirect('penggajian');
            }
        }
    }
    
?>