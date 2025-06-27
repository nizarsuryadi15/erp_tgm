<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Absensi_model');
    }

    public function karyawan_get() {
        $data = $this->Absensi_model->get_all();
        echo json_encode($data);
    }

    public function absen_post() {
        $input = json_decode(file_get_contents("php://input"), true);
        $result = $this->Absensi_model->simpan_absen($input);
        echo json_encode(['success' => $result]);
    }
}
