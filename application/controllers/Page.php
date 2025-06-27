<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function req_login()
    {
        $username   = $this->session->userdata('username');
        $roleid     = $this->session->userdata('role_id');

        $data      = [  
            'perusahaan'    => $this->db->get('tbl_perusahaan')->row_array(),
            'users'                 => $this->M_users->getUsers($username )->row_array(),
            'title'                 => 'Data Karyawan ',
            'cekusername'           => $this->M_login->cekusernamekasir($username)->row_array(),
            'role_id'               => $roleid,
            'tampildata'            => $this->M_karyawan->tampildata()->result_array()     

        ];

        // $this->load->view('_layout/header');
        $this->load->view('please_login', $data);
    }
    public function access_denied()
    {
        $username   = $this->session->userdata('username');
        $roleid     = $this->session->userdata('role_id');

        $data      = [  
            'perusahaan'    => $this->db->get('tbl_perusahaan')->row_array(),
            'users'                 => $this->M_users->getUsers($username )->row_array(),
            'title'                 => 'Data Karyawan ',
            'cekusername'           => $this->M_login->cekusernamekasir($username)->row_array(),
            'role_id'               => $roleid,
            'tampildata'            => $this->M_karyawan->tampildata()->result_array()     

        ];

        //$this->load->view('_layout/header');
        $this->load->view('access_denied', $data);
    }
}
