<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Absensi_model');
    }

    public function index() {
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
                'title'             => 'Daftar Absensi Karyawan',
                'table'             => 'tbl_kategori',  
                'perusahaan'        => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'          => $conf['hakakses']['divisi_nama'],
                'logo'              => $conf['perusahaan']['logo'],
                'level'             => $this->db->get_where('users', array('user_id'=>$userid))->row_array(),  
                'menu'              => $this->db->get('menu')->result(),
                'submenu'           => $this->M_master->getmenu($controller)->result(),
                'list_bahan'        => $this->M_master->getDataBahan()->result(),
            );
            $data['absensi'] = $this->Absensi_model->get_all_absensi();

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header',);
            $this->load->view('layout_admin/sidebar', $data);
            // $this->load->view('layout_admin/top_bar');
            $this->load->view('admin/absensi/index', $data);
            $this->load->view('layout_admin/footer');
        

    }

    public function rekap($karyawan_id) {
        $data['rekap'] = $this->Absensi_model->get_rekap_by_karyawan($karyawan_id);
        $this->load->view('absensi/rekap', $data);
    }

    public function absen_masuk() {
        $data = [
            'karyawan_id'       => $this->input->post('karyawan_id'),
            'tanggal'           => $this->input->post('tanggal'),
            'jam_masuk'         => $this->input->post('jam_masuk'),
            'status'            => 'Hadir'
            ];
        $this->Absensi_model->insert($data);
        redirect('mobile');
    }

    public function izin_absen() {
        $data = [
            'karyawan_id'       => $this->input->post('karyawan_id'),
            'tanggal'           => $this->input->post('tanggal'),
            'status'            => $this->input->post('status'),
            ];
        $this->Absensi_model->insert($data);
        redirect('mobile');
    }

    public function absen_pulang() {
        $where = [
            'karyawan_id'       => $this->input->post('karyawan_id'),
            'tanggal'           => $this->input->post('tanggal'),
            ];
        print_r($where);

        $update = [
            'jam_pulang'         => $this->input->post('jam_pulang'),
        ];

        print_r($update);

        $this->Absensi_model->update($where, $update);
        redirect('mobile');
    }

    public function scan() {
        $nip = $this->input->post('nip_qr');
        $karyawan = $this->Karyawan_model->get_by_nip($nip);

        if ($karyawan) {
        $data = [
            'nip' => $nip,
            'tanggal' => date('Y-m-d'),
            'waktu' => date('H:i:s'),
            'status' => 'Hadir'
        ];
        $this->Absensi_model->insert($data);
        }
        redirect('absensi/form');
    }
}
