<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Satuan extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->session->userdata('logged_in') !== TRUE) {
                redirect('auth');
            }
        }

        public function index(){
            $table              = 'tbl_satuan';
            $data['id']         = 'satuan_id';
            

            $conf  = array(
                'perusahaan'    => $this->db->get_where('tbl_perusahaan', array('id_perusahaan'=> $this->session->userdata('perusahaan_id')))->row_array(),
                'hakakses'      => $this->db->get_where('tbl_divisi', array('divisi_id'=> $this->session->userdata('level')))->row_array(),
            );


            $data = array(
                'controller'    => $this->uri->segment(1),
                'function'      => 'Data Satuan',
                'title'         => 'Daftar Satuan',
                'table'         => 'tbl_satuan',
                'satuan'        => $this->M_master->getDatanonorder($table)->result(),
                'total_rows'    => $this->M_master->getDatanonorder($table)->num_rows(),
                'perusahaan'    => $conf['perusahaan']['nama_perusahaan'],
                'hakakses'      => $conf['hakakses']['divisi_nama'],
                'logo'          => $conf['perusahaan']['logo'],
                'menu'          => $this->db->get('menu')->result(),
                'submenu'       => $this->M_master->getmenu($controller)->result(),
                
            );

            $this->load->view('layout_admin/head', $data);
            $this->load->view('layout_admin/top_header');
            $this->load->view('layout_admin/sidebar', $data);
            $this->load->view('admin/satuan/index', $data);
            $this->load->view('layout_admin/footer');
        }

        

        function simpan(){
            $table              = 'tbl_satuan';
            $controller         = $this->uri->segment(1);

            $data = array(
                'satuan_nama'         => $this->input->post('satuan_nama'),
                'satuan_deskripsi'    => $this->input->post('satuan_deskripsi'),
                
                
            );

            $add = $this->M_master->addData($table, $data);

            if ($add == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Disimpan');
                redirect($controller);
            }
        }

        function delete($id){
            $table              = 'tbl_satuan';
            $data['id']         = 'satuan_id';
            $controller         = $this->uri->segment(1);

            $this->db->where($data['id'], $id);
            $delete = $this->db->delete($table);

            if ($delete == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
                redirect($controller);
            }
        }

        public function update(){
            $table          = 'tbl_satuan';
            $controller     = $this->uri->segment(1);
            
            $where          = array(
                'satuan_id' => $this->input->post('satuan_id'),
            );

            $data = array(
                'satuan_nama'         => $this->input->post('satuan_nama'),
                'satuan_deskripsi'    => $this->input->post('satuan_deskripsi'),
                
            );
            $update = $this->M_master->updateData($table, $where, $data);

            if ($update == true) {
                $this->session->set_flashdata('success', 'Data Berhasil Diupdate');
                redirect($controller);
            }
        }

    }
    
?>