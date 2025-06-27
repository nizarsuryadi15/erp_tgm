<?php 
    class M_gudang extends CI_model
    {
        function getBahan($kode){
            $this->db->where('tbl_bahan.bahan_id',$kode);
            $this->db->join('tbl_stok_gudang','tbl_bahan.bahan_id = tbl_stok_gudang.bahan_id');
            return $this->db->get('tbl_bahan');
        }
        
        function getAllBahan(){
            $this->db->join('tbl_stok_gudang','tbl_bahan.bahan_id = tbl_stok_gudang.bahan_id');
            $this->db->join('tbl_satuan','tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
            return $this->db->get('tbl_bahan');
        } 

        function stokjasa($perusahaan){
            $this->db->where('perusahaan_id', $perusahaan);
            $this->db->where('approve', '0');
            return $this->db->get('tbl_pengambilan');
        }

        function stok_minim(){
            return $this->db->query("SELECT * FROM tbl_stok_gudang a inner join 
                                        tbl_bahan b on a.bahan_id = b.bahan_id inner join
                                            tbl_satuan c on b.satuan_gudang = c.satuan_id
                                                where ((stok_awal + stok_tambah) - stok_kurang) <= stok_min");
            // return $this->db->get('tbl_stok_gudang');
        }

        function getSonDetail($id){
            $this->db->where('son_id', $id);
            $this->db->join('tbl_bahan','tbl_bahan.bahan_id = tbl_stok_opname.bahan_id');
            $this->db->join('tbl_satuan','tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
           
            return $this->db->get('tbl_stok_opname');
        }

        function stokjasa_masuk($perusahaan){
            $this->db->where('tbl_pengambilan.perusahaan_id', $perusahaan);
            $this->db->where('tbl_pengambilan_detail.approve', '0');
            $this->db->join('tbl_pengambilan_detail','tbl_pengambilan_detail.pengambilan_id = tbl_pengambilan.pengambilan_id');
            $this->db->join('tbl_bahan','tbl_bahan.bahan_id = tbl_pengambilan_detail.bahan_id');
            $this->db->join('tbl_stok_bahan','tbl_stok_bahan.bahan_id = tbl_bahan.bahan_id');
            return $this->db->get('tbl_pengambilan');
        }

        function getStokgudang(){
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_stok_gudang.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
            return $this->db->get('tbl_stok_gudang');
        }
        

        function getDataBahan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('perusahaan_id', $perusahaan);
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_stok_bahan.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
            // $this->db->join('tbl_satuan', 'tbl_bahan.satuan_id = tbl_satuan.satuan_id');
            // $this->db->join('tbl_satuan', 'tbl_bahan.satuan_id = tbl_satuan.satuan_id');
            return $this->db->get('tbl_stok_bahan');
        }

        function getGudangBahan(){
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_stok_gudang.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
            return $this->db->get('tbl_stok_gudang');
        }

        function getdatabyId($id){
            $this->db->where('bahan_id',$id);
            return $this->db->get('tbl_bahan');
        }

        function updateData($table, $id, $update){
            $this->db->where($id);
            return $this->db->update($table, $update);
        }

        function getTemp($table){
            $this->db->join('tbl_bahan', "$table.bahan_id = tbl_bahan.bahan_id");
            return $this->db->get($table);
        }

        function deleteData($table, $id){
            $this->db->where($id);
            return $this->db->delete($table);
        }

        function getLastId($table, $field){
            $this->db->select_max($field);
            return $this->db->get($table);
        }

        function getStok($bahan){
            $this->db->where('bahan_id', $bahan);
            return $this->db->get('tbl_stok_gudang');
        }

        function getStokBahan($bahan){
            $this->db->where('bahan_id', $bahan);
            return $this->db->get('tbl_stok_bahan');
        }

        function harga_max($bahan){
            return $this->db->query("SELECT max(pemb_harga) FROM tbl_pembelian_detail WHERE bahan_id = $bahan");
        }

        function getDataPembelian(){
            // $perusahaan = $this->session->userdata('perusahaan_id');
            // $this->db->where('perusahaan_id', $perusahaan);
            $this->db->join('tbl_supplier','tbl_pembelian.supplier_id = tbl_supplier.supplier_id');
            return $this->db->get('tbl_pembelian');
        }

        // function getdetailpembelian(){
        //     return $this->db->get('tbl_pembelian_detail');
        // }

        function getDataPengambilan(){
            $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = tbl_pengambilan.karyawan_id');
            $this->db->join('tbl_gudang','tbl_gudang.gudang_id = tbl_pengambilan.gudang_id');
            return $this->db->get('tbl_pengambilan');
        }

        function getDataStokOpname(){
            $bulanini  = date('Y-m');
            $this->db->like('son_tgl',$bulanini);
            $this->db->join('tbl_bahan','tbl_bahan.bahan_id = tbl_stok_opname.bahan_id');
            $this->db->join('tbl_satuan','tbl_bahan.satuan_gudang = tbl_satuan.satuan_id');
            return $this->db->get('tbl_stok_opname');
        }

        function getdetailPembelian($id){
            $this->db->join('tbl_pembelian','tbl_pembelian_detail.pembelian_id = tbl_pembelian.pembelian_id');
            $this->db->join('tbl_supplier','tbl_pembelian.supplier_id = tbl_supplier.supplier_id');
            $this->db->join('tbl_bahan','tbl_pembelian_detail.bahan_id = tbl_bahan.bahan_id');
            $this->db->where('tbl_pembelian_detail.pembelian_id', $id);
            return $this->db->get('tbl_pembelian_detail');
        }

        function getbelibahan(){
          
            $this->db->join('tbl_supplier','tbl_pembelian.supplier_id = tbl_supplier.supplier_id');
           
            return $this->db->get('tbl_pembelian');
        }

        function getbahanPembelian($id){
            $bulanini = date('Y-m');
           // print_r($bulanini);
            $this->db->join('tbl_pembelian','tbl_pembelian_detail.pembelian_id = tbl_pembelian.pembelian_id');
            $this->db->join('tbl_supplier','tbl_pembelian.supplier_id = tbl_supplier.supplier_id');
            $this->db->join('tbl_bahan','tbl_pembelian_detail.bahan_id = tbl_bahan.bahan_id');
            $this->db->where('tbl_pembelian_detail.bahan_id', $id);
            $this->db->like('pembelian_tgl', $bulanini);
            return $this->db->get('tbl_pembelian_detail');
        }

        function getbahanPengambilan($id){
            $bulanini = date('Y-m');
          // print_r($bulanini);
            
            $this->db->join('tbl_pengambilan','tbl_pengambilan_detail.pengambilan_id = tbl_pengambilan.pengambilan_id');
            $this->db->join('tbl_perusahaan','tbl_perusahaan.id_perusahaan = tbl_pengambilan.perusahaan_id');
            $this->db->join('tbl_karyawan','tbl_pengambilan.karyawan_id = tbl_karyawan.karyawan_id');
            $this->db->join('tbl_bahan','tbl_pengambilan_detail.bahan_id = tbl_bahan.bahan_id');
            $this->db->where('tbl_pengambilan_detail.bahan_id', $id);
            $this->db->like('pengambilan_tgl', $bulanini);
            return $this->db->get('tbl_pengambilan_detail');
        }

        function search_bahan($title){
            $this->db->like('barcode', $title , 'both');
            $this->db->order_by('blog_title', 'ASC');
            $this->db->limit(10);
            return $this->db->get('blog')->result();
        }

        function cekSon($bahan_id, $son_tgl){
            $this->db->where('bahan_id', $bahan_id);
            $this->db->like('son_tgl', $son_tgl);
            return $this->db->get('tbl_stok_opname');
        }

        function getMonitoringStok(){
            return $this->db->query("
                SELECT 
                    pd.bahan_id,
                    s.satuan_nama,
                    b.bahan_nama,
                    pd.pemb_qty AS qty_masuk,
                    0 AS qty_keluar,
                    'Masuk' AS tipe,
                    p.pembelian_tgl AS tanggal,
                    p.pembelian_waktu AS waktu,
                    sup.supplier_nama as nama_supplier,
                    k.nama_lengkap AS nama_karyawan

                FROM tbl_pembelian_detail pd
                JOIN tbl_bahan b ON b.bahan_id = pd.bahan_id
                JOIN tbl_pembelian p ON p.pembelian_id = pd.pembelian_id
                JOIN tbl_satuan s ON s.satuan_id = b.satuan_gudang
                JOIN tbl_supplier sup ON sup.supplier_id = p.supplier_id
                LEFT join tbl_karyawan k ON k.karyawan_id = p.karyawan_id
                

                UNION ALL

                SELECT 
                    pgd.bahan_id,
                    s.satuan_nama,
                    b.bahan_nama,
                    0 AS qty_masuk,
                    pgd.pengambilan_qty AS qty_keluar,
                    'Keluar' AS tipe,
                    pg.pengambilan_tgl AS tanggal,
                    pg.pengambilan_waktu AS waktu,
                    g.gudang_nama AS nama_gudang,
                    k.nama_lengkap AS nama_karyawan

                FROM tbl_pengambilan_detail pgd
                JOIN tbl_bahan b ON b.bahan_id = pgd.bahan_id
                JOIN tbl_pengambilan pg ON pg.pengambilan_id = pgd.pengambilan_id
                JOIN tbl_satuan s ON s.satuan_id = b.satuan_gudang
                JOIN tbl_gudang g ON g.gudang_id = pg.gudang_id
                JOIN tbl_karyawan k ON k.karyawan_id = pg.karyawan_id
                

                ORDER BY waktu DESC
            ");

        }

        
    }
    
?>