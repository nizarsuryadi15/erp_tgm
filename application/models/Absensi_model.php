<?php
class Absensi_model extends CI_Model {

    public function cekabsen($karyawan){
        return $this->db->get('absensi');
    }

    public function get_karyawan() {
        return $this->db->get('tbl_karyawan')->result();
    }

    public function get_absensi_hari_ini()
    {
        $karyawan           = $this->session->userdata('karyawan_id');
        $today = date('Y-m-d');
        $this->db->select('k.nama_lengkap, a.jam_masuk, a.jam_pulang, a.status, a.tanggal');
        $this->db->from('absensi a');
        $this->db->join('tbl_karyawan k', 'k.karyawan_id = a.karyawan_id');
        $this->db->where('k.karyawan_id', $karyawan);
        return $this->db->get()->result_array();
    }


    public function get_all_absensi() {
        $this->db->select('absensi.*, tbl_karyawan.nama_lengkap');
        $this->db->from('absensi');
        $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id = absensi.karyawan_id');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_absen_karyawan($kode) {
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where('tbl_karyawan.karyawan_id', $kode);
        $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id = absensi.karyawan_id');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get();
    }

    public function simpan_absen_batch($data) {
        return $this->db->insert_batch('absensi', $data);
    }

    public function get_rekap_by_karyawan($karyawan_id) {
        $this->db->select('status, COUNT(*) as jumlah');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->group_by('status');
        return $this->db->get('absensi')->result();
    }

    public function get_absen_hari_ini()
    {
        $today              = date('Y-m-d');
        $karyawan           = $this->session->userdata('karyawan_id');

        $this->db->where('tanggal)', $today); // Pastikan kolom `tanggal` berformat datetime/date
        $this->db->where('karyawan_id', $karyawan);
        return $this->db->get('absensi'); // Ganti 'absen' dengan nama tabel sebenarnya
    }

    public function insert($data) {
        $cek = $this->db->get_where('absensi', [
        'karyawan_id'       => $data['karyawan_id'],
        'tanggal'           => $data['tanggal']
        ])->row();

        if (!$cek) {
            $this->db->insert('absensi', $data);
        }
    }

    public function update($where, $update) {
        return $this->db->update('absensi', $update, $where);
    }

    public function get_lembur($karyawan){
        $this->db->where('karyawan_id', $karyawan);
        $this->db->where('status', 'disetujui');
        return $this->db->get('tbl_lembur');
    }

    public function get_absen($karyawan, $kehadiran){
        $this->db->where('karyawan_id', $karyawan);
        $this->db->where('status', $kehadiran);
        return $this->db->get('absensi');
    }

}
