<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Akun extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
            $table  = 'users';
        }

        public function index(){
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
                'controller'        => $this->uri->segment(1),
                'function'          => $this->uri->segment(2),
                'title'             => 'Akun Karyawan',
                'table'             => 'tbl_karyawan',
                'tampilData'        => $this->M_master->getUser()->result(),
                'total_rows'        => $this->M_master->getUser()->num_rows(),
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'list_perusahaan'   => $this->db->get('tbl_perusahaan')->result(),
                'list_roles'        => $this->db->get('roles')->result(),
                'list_karyawan'     => $this->db->get('tbl_karyawan')->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/akun/index', $data);
            $this->load->view('layout_admin/footer');
        }

        public function action_add_user()
        {
            // $this->load->library('form_validation');

            // Set rules validasi
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('karyawan_id', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('perusahaan_id', 'Store', 'required');

            if ($this->form_validation->run() == FALSE) {
                // Kembalikan ke halaman sebelumnya dengan pesan error
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('akun')); // Sesuaikan dengan controller/view
            }

            // Ambil input
            $data = [
                'username'          => $this->input->post('username', TRUE),
                'password'          => md5($this->input->post('password', TRUE)),
                'email'             => $this->input->post('email', TRUE),
                'karyawan_id'       => $this->input->post('karyawan_id', TRUE),
                'perusahaan_id'     => $this->input->post('perusahaan_id', TRUE),
                'active'            => 1, // default aktif
                'created_at'        => date('Y-m-d H:i:s')
            ];

            // Simpan ke database (misalnya ke tabel 'user')
            $this->db->insert('users', $data);

            $this->session->set_flashdata('success', 'Akun berhasil ditambahkan.');
            redirect(base_url('akun'));
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
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
            );

            print_r($data['getlist']);

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/karyawan/edit_akun', $data);
            $this->load->view('layout_admin/footer');
            
        }

        public function aksi_edit_akun()
        {
            // Ambil data dari form POST
            $user_id      = $this->input->post('user_id');
            $username     = $this->input->post('username');
            $karyawan_id  = $this->input->post('karyawan_id');
            $role_id      = $this->input->post('role_id');

            // Validasi sederhana (bisa diperluas sesuai kebutuhan)
            if (!$user_id || !$karyawan_id || !$role_id) {
                $this->session->set_flashdata('error', 'Data tidak lengkap!');
                redirect('akunn');
            }

            // Siapkan data untuk update
            $data = [
                'username'      => $username,
                'karyawan_id'   => $karyawan_id,
                'role_id'       => $role_id
                // Tidak perlu update username jika readonly (kecuali ingin diubah juga)
            ];

            // Lakukan update di database
            $this->db->where('user_id', $user_id);
            $update = $this->db->update('users', $data); // Ganti 'users' sesuai nama tabel kamu

            if ($update) {
                $this->session->set_flashdata('success', 'Akun berhasil diupdate.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate akun.');
            }

            redirect('akun'); // Ganti sesuai route tujuan setelah update
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
                    'jabatan_id'      => $this->input->post('jabatan_id')
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
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
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
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
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
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
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
            );


            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/header');
            $this->load->view('layout_admin/left_sidebar', $data);
            $this->load->view('admin/'.$controller.'/gudang', $data);
            $this->load->view('layout_admin/footer');
        }

        public function reset_password($user_id)
        {
            // Default password, misal: "123456"
            $default_password = password_hash('123456', PASSWORD_DEFAULT);

            $this->db->where('user_id', $user_id);
            $this->db->update('users', ['password' => $default_password]);

            $this->session->set_flashdata('success', 'Password berhasil direset ke default.');
            redirect('akun');
        }

    }
    
?>