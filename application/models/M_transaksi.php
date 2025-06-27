<?php 
    class M_transaksi extends CI_Model
    {
        public function get_legger($tanggal_awal, $tanggal_selesai){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT pembayaran_tgl, SUM(CASE WHEN metode = 'cash' THEN sub_total ELSE 0 END) 
                                AS total_cash, SUM(CASE WHEN metode = 'transfer' 
                                    THEN sub_total ELSE 0 END) AS total_transfer, 
                                        SUM(CASE WHEN metode = 'edc' THEN sub_total ELSE 0 END) 
                                            AS total_edc, SUM(CASE WHEN metode = 'ewallet' 
                                                THEN sub_total ELSE 0 END) AS total_ewallet, 
                                                    SUM(CASE WHEN metode = 'piutang' 
                                                        THEN sub_total ELSE 0 END) AS total_piutang, 
                                                            SUM(sub_total) AS total_harian 
                                                                FROM tbl_pembayaran WHERE (pembayaran_tgl >= '$tanggal_awal') 
                                                                    and (pembayaran_tgl <= '$tanggal_selesai') and (perusahaan_id = $perusahaan)
                                                                        GROUP BY pembayaran_tgl ORDER BY pembayaran_tgl ASC");
            
        }

        public function getkeuanganmobile(){
            $bulanini   = date('Y-m');
            $this->db->like('pembayaran_tgl', $bulanini);
            $this->db->group_by('pembayaran_tgl');

            return $this->db->get("tbl_pembayaran");
        }

        public function jmltransaksi($tgl, $store) {
            $tglini = $this->db->escape($tgl);
            $query = $this->db->query("
                SELECT SUM(sub_total) AS jumlah 
                FROM tbl_pembayaran 
                WHERE pembayaran_tgl = $tglini AND perusahaan_id = $store");
            return $query;
        }

        public function getpengeluaran() {
            $bulanini = date('Y-m');
            $this->db->select('pengeluaran_tgl');
            $this->db->from('tbl_pengeluaran_harian');
            $this->db->like('pengeluaran_tgl', $bulanini);
            $this->db->group_by('pengeluaran_tgl');
            
            return $this->db->get();
        }

        public function jmlpengeluaran($tgl,$store){
            $tglini     = $this->db->escape($tgl);
            $query      = $this->db->query("
                SELECT SUM(pengeluaran_jumlah) AS jumlah 
                FROM tbl_pengeluaran_harian 
                WHERE pengeluaran_tgl = $tglini AND perusahaan_id = $store");
            return $query;
        }

        public function product_terlaris(){
            $bulan  = date('Y-m');
            return $this->db->query("SELECT 
                                        a.product_id,
                                        a.nospk,
                                        b.product_nama,
                                        c.satuan_nama,
                                        d.pembayaran_tgl,
                                        SUM(a.qty) AS total_qty
                                    FROM 
                                        tbl_pembayaran_detail a 
                                    INNER JOIN 
                                        tbl_product b ON a.product_id = b.product_id 
                                    INNER JOIN 
                                        tbl_satuan c ON b.satuan_id = c.satuan_id
                                    INNER JOIN 
                                        tbl_pembayaran d ON a.nospk = d.nospk
                                    WHERE 
                                        d.pembayaran_tgl LIKE '$bulan%'
                                    GROUP BY 
                                        a.product_id,
                                        a.nospk,
                                        b.product_nama,
                                        c.satuan_nama,
                                        d.pembayaran_tgl
                                    ORDER BY 
                                        total_qty DESC
                                    LIMIT 10

                                ");
        }
        

        

        

        public function get_transaksi(){
            $user   = $this->session->userdata('id');
            return $this->db->query("SELECT SUM(sub_total) as totalna FROM tbl_pembayaran WHERE kasir_id = $user");

        }

        public function get_konsumen_dengan_transaksi() {
            return $this->db->query("SELECT k.konsumen_id, k.konsumen_nama, k.konsumen_nohp, 
                                        COUNT(p.id) AS jumlah_transaksi, COALESCE(SUM(p.grand_total), 0) 
                                            AS total_transaksi 
                                            FROM tbl_konsumen k LEFT JOIN tbl_pembayaran p 
                                            ON k.konsumen_id = p.konsumen_id 
                                            GROUP BY k.konsumen_id, k.konsumen_nama 
                                            ORDER BY total_transaksi DESC
                                                lIMIT 200
                                            ");
        
        }

        function getTotalPiutang(){
            return $this->db->query("SELECT SUM(piutang_sisa) as total_piutang FROM tbl_piutang");
        }

        function total_produk_terjual($date){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(qty) as total FROM tbl_pembayaran_detail a 
                                        INNER JOIN tbl_pembayaran b ON a.nospk = b.nospk 
                                            WHERE pembayaran_tgl like'$date%' and b.perusahaan_id = $perusahaan
                                    ");
        }

        function cekRange($qty){
            return $this->db->query("SELECT * FROM tbl_range WHERE range_min >= '$qty' OR range_max <= '$qty'");
            
        }

        function update ($table, $data, $where){
            $this->db->where($where);
            return $this->db->update($table, $data);
        }

        function deleteTemp($product, $kodena){
            $this->db->where('product_id', $product);
            $this->db->where('kode_trx', $kodena);
            return $this->db->delete('tbl_temp_transaksi');
        }

        //Cek Produk Print A3 dan yang memiliki side 1,2

        function cekHargaProductB($product, $qty, $ket_1){
            
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                            AND ket_1 = '$ket_1'
                                                AND jml_minimum <= '$qty' 
                                                        ORDER BY jml_minimum
                                                            DESC LIMIT 0,1 ");
        }

        function cekHargaKategori2($product, $jenis){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                            AND jenisprint_id = $jenis
                                    ");
        }

        function cekHargaProductD($product, $qty){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                                AND jml_minimum <= '$qty' 
                                                        ORDER BY jml_minimum
                                                            DESC LIMIT 0,1
                                    
                                    ");
        }
        

        function cekHargaProductC($product, $ket, $field){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                            AND $field = '$ket' 
                                    ");
        }


        function cekHargaProductJ($product, $qty, $sisi, $ket2){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                            AND ket_1 = '$sisi'
                                                
                                                    AND jml_minimum <= '$qty' 
                                                        Order By jml_minimum 
                                                            DESC LIMIT 0,1 ");
        }

        function cekHargaProductK($product, $qty){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' 
                                                AND jml_minimum <= '$qty' 
                                                    Order By jml_minimum 
                                                        DESC LIMIT 0,1 ");
        }

        function cekHargaProductI($product){
            return $this->db->query("SELECT * FROM tbl_harga_product WHERE harga_id = '$product' ");
        }

        function cekHargaProductF($product,$ket_1, $ket_2){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' AND ket_1 = '$ket_1' 
                                    ");
        }
        function cekHargaProductG($product,$ket_1, $ket_2, $ket_3){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' AND ket_1 = '$ket_1' AND ket_3 = '$ket_3'
                                    ");
        }

        function cekHargaProductE($product, $panjang){
            return $this->db->query("SELECT * FROM tbl_harga_product WHERE product_id = $product 
                                        AND (jml_minimum <= $panjang) order By jml_minimum DESC LIMIT 0,1
                                                            
                                    ");
        }

        function cekHargaProductH($product,$ket_1){
            return $this->db->query("SELECT * FROM tbl_harga_product 
                                        WHERE product_id = '$product' AND ket_1 = '$ket_1'
                                    ");
        }

        function cekProduct($kategori, $subkategori, $bahan){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->join('tbl_kategori','tbl_kategori.kategori_id = tbl_product.kategori_id');
            $this->db->join('tbl_subkategori','tbl_subkategori.subkategori_id = tbl_product.subkategori_id');
            $this->db->where('tbl_product.kategori_id', $kategori);
            $this->db->where('tbl_product.subkategori_id', $subkategori);
            $this->db->where('bahan_id', $bahan);
            return $this->db->get('tbl_product');
        }

        function tampilTmp($kode){
            $user = $this->session->userdata('id');
            $this->db->select('tbl_temp_transaksi.*,tbl_satuan.*, tbl_harga_product.harga_1,tbl_harga_product.harga_2,tbl_harga_product.harga_3, tbl_harga_product.harga_aktif, tbl_harga_product.ket_1, tbl_harga_product.harga_id, tbl_harga_product.detail_product, tbl_harga_product.range_id, tbl_harga_product.jml_minimum, tbl_konsumen.*');
            $this->db->where('no_spk', $kode);
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_temp_transaksi.harga_id');
            $this->db->join('tbl_product', 'tbl_product.product_id = tbl_temp_transaksi.product_id');
            $this->db->join('tbl_satuan', 'tbl_satuan.satuan_id = tbl_product.satuan_id');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_temp_transaksi.konsumen_id','left');
            return $this->db->get('tbl_temp_transaksi');
        }

        function deleteTmp($kode){
            $user = $this->session->userdata('id');
            $this->db->where('user_id', $user);
            $this->db->delete('tbl_temp_transaksi');
        }

        function setKonsumen($konsummen, $kode){
            $user = $this->session->userdata('id');
            $this->db->where('user_id', $user);
            $this->db->where('kode_trx', $kode);
            $this->db->update('tbl_temp_transaksi', ['konsumen_id' => $konsummen]);
        }

        function getNoSPK($user,$perusahaan){
             return $this->db->query("SELECT no_urut_spk FROM tbl_spk WHERE perusahaan_id = $perusahaan and user_id = $user
                                        order by no_urut_spk DESC limit 0,1"
                                            );
        }

        function getDataPemesanan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pemesanan.perusahaan_id', $perusahaan);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = users.karyawan_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman','left');
            
            // $this->db->join('tbl_pembayaran', 'tbl_pembayaran.nospk = tbl_pemesanan.nospk', 'left');
            $this->db->order_by('tbl_pemesanan.id', 'asc');
            return $this->db->get('tbl_pemesanan');
        }

        function getDataPemesanankasir($status){
            $perusahaan = $this->session->userdata('perusahaan_id');
            // $user       = $this->session->userdata('id');
            $this->db->where('tbl_pemesanan.perusahaan_id', $perusahaan);
            // $this->db->where('tbl_pemesanan.deskprint_id', $user);
            $this->db->where('tbl_pemesanan.status_pembayaran', $status);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = users.karyawan_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman','left');
            
            // $this->db->join('tbl_pembayaran', 'tbl_pembayaran.nospk = tbl_pemesanan.nospk', 'left');
            $this->db->order_by('tbl_pemesanan.id', 'asc');
            return $this->db->get('tbl_pemesanan');
        }

        function transaksideskprint(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $user       = $this->session->userdata('id');
            
            $this->db->where('tbl_pemesanan.perusahaan_id', $perusahaan);
            $this->db->where('tbl_pemesanan.deskprint_id', $user);
            // $this->db->where('tbl_pemesanan.status_pembayaran', $status);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            // $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = users.karyawan_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            // $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman','left');
            $this->db->order_by('tbl_pemesanan.id', 'desc');
            return $this->db->get('tbl_pemesanan');
        }

        function getbayarsukses($status){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $user       = $this->session->userdata('id');

            $this->db->where('tbl_pemesanan.perusahaan_id', $perusahaan);
            $this->db->where('tbl_pemesanan.status_pembayaran', $status);
            if ($this->session->userdata('level') <> 1){
            $this->db->where('tbl_pembayaran.kasir_id', $user);
            }    
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = users.karyawan_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman','left');
            
            $this->db->join('tbl_pembayaran', 'tbl_pembayaran.nospk = tbl_pemesanan.nospk', 'left');
            $this->db->order_by('tbl_pemesanan.id', 'asc');
            return $this->db->get('tbl_pemesanan');
        }

        function getpenjualanall(){
            $bulanini = date('Y-m');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            $this->db->join('tbl_karyawan','tbl_karyawan.karyawan_id = users.karyawan_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman','left');
            $this->db->join('tbl_perusahaan', 'tbl_perusahaan.id_perusahaan = tbl_pemesanan.perusahaan_id');
            $this->db->join('tbl_pembayaran', 'tbl_pembayaran.nospk = tbl_pemesanan.nospk','left');
            $this->db->like('tgl_pemesanan',$bulanini);
            $this->db->order_by('tbl_pemesanan.perusahaan_id', 'asc');
            $this->db->order_by('tbl_pemesanan.id', 'asc');
            
            return $this->db->get('tbl_pemesanan');
        }

        function getDetailPemesanan(){
            $nospk = decrypt_url($this->uri->segment(3));
            
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pemesanan.konsumen_id');
            $this->db->join('users', 'users.user_id = tbl_pemesanan.deskprint_id');
            $this->db->join('tbl_jenis_transaksi', 'tbl_jenis_transaksi.id_jenis_transaksi = tbl_pemesanan.id_jenis_transaksi');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_pemesanan.marketplace_id','left');
            // $this->db->join('tbl_pengiriman','tbl_pengiriman.id_pengiriman = tbl_pemesanan.id_pengiriman');
            return $this->db->get('tbl_pemesanan');
        }

        function getDetail(){
            $nospk = decrypt_url($this->uri->segment(3));
            $this->db->select('tbl_pemesanan_detail.*, tbl_product.product_nama, tbl_harga_product.harga_1, tbl_harga_product.harga_2, tbl_harga_product.harga_3, tbl_harga_product.harga_aktif, tbl_harga_product.ket_1, tbl_harga_product.harga_id, tbl_harga_product.detail_product, tbl_harga_product.range_id, tbl_harga_product.jml_minimum');
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_product', 'tbl_product.product_id = tbl_pemesanan_detail.product_id');
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_pemesanan_detail.harga_id');
            return $this->db->get('tbl_pemesanan_detail');
        }

        function getDetailPesan($nospk){
            $this->db->select('tbl_pemesanan_detail.*, tbl_product.product_nama, tbl_harga_product.harga_1, tbl_harga_product.harga_2, tbl_harga_product.harga_3, tbl_harga_product.harga_aktif, tbl_harga_product.ket_1, tbl_harga_product.harga_id, tbl_harga_product.detail_product, tbl_harga_product.range_id, tbl_harga_product.jml_minimum');
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_product', 'tbl_product.product_id = tbl_pemesanan_detail.product_id');
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_pemesanan_detail.harga_id');
            return $this->db->get('tbl_pemesanan_detail');
        }

        function deletePesanan($table,$nospk){
            $this->db->where('nospk', $nospk);
            return $this->db->delete($table);
        }

        function getPenjualan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $bulanini    = date('Y-m');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->like('tbl_pembayaran.pembayaran_tgl', $bulanini, 'after');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            // $this->db->join('tbl_jenis_transaksi','tbl_jenis_transaksi.id_jenis_transaksi = tbl_pembayaran.id_jenis_transaksi');
            // $this->db->join('tbl_marketplace','tbl_marketplace.marketplace_id = tbl_pembayaran.marketplace_id', 'left');
            $this->db->join('tbl_rekening','tbl_rekening.id = tbl_pembayaran.rekening_id', 'left');
            $this->db->join('tbl_mesin_edc','tbl_mesin_edc.edc_id = tbl_pembayaran.id_edc', 'left');
            $this->db->join('tbl_ewallet','tbl_ewallet.id = tbl_pembayaran.ewallet_id', 'left');
            $this->db->join('users', 'users.user_id = tbl_pembayaran.kasir_id');
            $this->db->order_by('tbl_pembayaran.id', 'desc');
            return $this->db->get('tbl_pembayaran');
        }

        function getBayarmetode(){
            //print_r($bayar);
            $perusahaan = $this->session->userdata('perusahaan_id');
            $bulanini    = date('Y-m');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->like('tbl_pembayaran.pembayaran_tgl', $bulanini, 'after');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            $this->db->join('tbl_jenis_transaksi','tbl_jenis_transaksi.id_jenis_transaksi = tbl_pembayaran.id_jenis_transaksi');
            $this->db->join('tbl_marketplace','tbl_marketplace.marketplace_id = tbl_pembayaran.marketplace_id', 'left');
            $this->db->join('tbl_rekening','tbl_rekening.id = tbl_pembayaran.rekening_id', 'left');
            $this->db->join('tbl_mesin_edc','tbl_mesin_edc.edc_id = tbl_pembayaran.id_edc', 'left');
            $this->db->join('tbl_ewallet','tbl_ewallet.id = tbl_pembayaran.ewallet_id', 'left');
            $this->db->join('users', 'users.user_id = tbl_pembayaran.kasir_id');
            $this->db->order_by('tbl_pembayaran.id', 'desc');
            return $this->db->get('tbl_pembayaran');
        }
         
        function getPenjualanday($bayar){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            if ($bayar == '1'){
                $this->db->where('bayar_tunai <>',0);
            }elseif($bayar == '2'){
                $this->db->where('bayar_transfer <>',0);
            }elseif($bayar == '3'){
                $this->db->where('bayar_debit <>',0);
            }elseif($bayar == '4'){
                $this->db->where('bayar_ewallet <>',0);
            }else{
                
            }

            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('tbl_pembayaran.pembayaran_tgl', $hariini);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            $this->db->join('tbl_jenis_transaksi','tbl_jenis_transaksi.id_jenis_transaksi = tbl_pembayaran.id_jenis_transaksi');
            $this->db->join('tbl_marketplace','tbl_marketplace.marketplace_id = tbl_pembayaran.marketplace_id', 'left');
            $this->db->join('tbl_rekening','tbl_rekening.id = tbl_pembayaran.rekening_id', 'left');
            $this->db->join('tbl_mesin_edc','tbl_mesin_edc.edc_id = tbl_pembayaran.id_edc', 'left');
            $this->db->join('tbl_ewallet','tbl_ewallet.id = tbl_pembayaran.ewallet_id', 'left');
            $this->db->join('users', 'users.user_id = tbl_pembayaran.kasir_id');
            $this->db->order_by('tbl_pembayaran.id', 'desc');
            return $this->db->get('tbl_pembayaran');
        }

        function getPembayaran($nospk){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            $this->db->join('tbl_rekening','tbl_rekening.id = tbl_pembayaran.rekening_id', 'left');
            $this->db->join('tbl_ewallet','tbl_ewallet.id = tbl_pembayaran.ewallet_id', 'left');
            $this->db->join('users', 'users.user_id = tbl_pembayaran.kasir_id');
            return $this->db->get('tbl_pembayaran');
        
        }

        function getcekpesanan($nospk){
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            $this->db->join('tbl_rekening','tbl_rekening.id = tbl_pembayaran.rekening_id', 'left');
            $this->db->join('tbl_ewallet','tbl_ewallet.id = tbl_pembayaran.ewallet_id', 'left');
            $this->db->join('users', 'users.user_id = tbl_pembayaran.kasir_id');
            return $this->db->get('tbl_pembayaran');
        
        }

        

        function getDetailPembayaran($nospk){
            $this->db->where('nospk', $nospk);
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_pembayaran_detail.harga_id');
            return $this->db->get('tbl_pembayaran_detail');
        }

        function getDetailPembayaranAll(){
            $divisi = $this->session->userdata('level');
            $this->db->select('tbl_pembayaran_detail.*, tbl_pembayaran.*, tbl_product.*, tbl_bahan.*, tbl_harga_product.detail_product, tbl_konsumen.konsumen_nama, tbl_konsumen.konsumen_nohp');
            $this->db->where('tbl_pembayaran_detail.mesin_id',$divisi);
            $this->db->join('tbl_pembayaran', 'tbl_pembayaran.nospk = tbl_pembayaran_detail.nospk');
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_pembayaran_detail.harga_id');
            $this->db->join('tbl_product', 'tbl_product.product_id = tbl_pembayaran_detail.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_konsumen','tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran_detail');
        }

        function getTotalTrx($date){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(sub_total) as total  FROM tbl_pembayaran 
                                        where (perusahaan_id = $perusahaan) and pembayaran_tgl like'$date%'");
        }
        

        function transaksi_bulanan($bulan){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $bulanini    = date('Y-'.$bulan);
            
            return $this->db->query("SELECT SUM(sub_total) as total  FROM tbl_pembayaran where (perusahaan_id = $perusahaan) and pembayaran_tgl like'$bulanini%'");
        }

        function getTotalTrxmetode($bayarna){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $bulanini    = date('Y-m');
            return $this->db->query("SELECT SUM(sub_total) as total  FROM tbl_pembayaran where (perusahaan_id = $perusahaan) and (pembayaran_tgl like'$bulanini%') and ($bayarna <> '')");
        }

        function getTotalday(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            //$this->db->where('perusahaan_id', $perusahaan);
            return $this->db->query("SELECT SUM(sub_total) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl = '$hariini' ");
        }

        function getcashbulan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m');
            return $this->db->query("SELECT SUM(bayar_tunai) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getcashharian(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            return $this->db->query("SELECT SUM(bayar_tunai) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getpiutangbulan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m');
            return $this->db->query("SELECT SUM(piutang) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getpiutangharian(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            return $this->db->query("SELECT SUM(piutang) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function gettransferbulan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m');
            return $this->db->query("SELECT SUM(bayar_transfer) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }
        function gettransferharian(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            return $this->db->query("SELECT SUM(bayar_transfer) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getedcbulan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m');
            return $this->db->query("SELECT SUM(bayar_debit) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getedcharian(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            return $this->db->query("SELECT SUM(bayar_debit) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getewalletbulan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m');
            return $this->db->query("SELECT SUM(bayar_ewallet) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getewalletharian(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $hariini    = date('Y-m-d');
            return $this->db->query("SELECT SUM(bayar_ewallet) as total  FROM tbl_pembayaran where perusahaan_id = $perusahaan and pembayaran_tgl like'$hariini%' ");
        }

        function getPiutang(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            // $this->db->where('tbl_piutang.perusahaan_id', $perusahaan);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_piutang.konsumen_id');
            $this->db->join('tbl_perusahaan','tbl_perusahaan.id_perusahaan = tbl_piutang.perusahaan_id');
            $this->db->group_by('tbl_piutang.konsumen_id');
            return $this->db->get('tbl_piutang');
        }

        function get_pemesanan(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('perusahaan_id', $perusahaan);
            return $this->db->get('tbl_pemesanan');
        }

        function getPiutangKonsumen($konsumen){
            $this->db->where('tbl_piutang.konsumen_id', $konsumen);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_piutang.konsumen_id');
            return $this->db->get('tbl_piutang');
        }
        
        function getPiutangSPK($nospk){
            $this->db->where('nospk', $nospk);
            return $this->db->get('tbl_piutang');
        }

        function getoldpiutang($konsumen){
            $this->db->where('tbl_piutang.konsumen_id', $konsumen);
            $this->db->where('tbl_piutang.piutang_status', 'BELUM LUNAS');
            $this->db->order_by('tbl_piutang.piutang_tgl', 'desc');
            $this->db->LIMIT(1);
            return $this->db->get('tbl_piutang');
        }

        function updatebayar($idpiutang, $bayarna){
            $this->db->where('id', $idpiutang);
            return $this->db->update('tbl_piutang', $bayarna);
        }

        function totalPiutangKonsumen($konsumen){
            return $this->db->query("SELECT SUM(tbl_piutang.piutang_sisa) as total FROM tbl_piutang WHERE konsumen_id = '$konsumen'");
        }

        function getPengambilanAll(){
            $this->db->where('status_transaksi','3');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran');
        }
        
        function getPengambilanBarang(){
            $divisi = $this->session->userdata('level');
            $this->db->where('status_trx','2');
            $this->db->join('tbl_harga_product', 'tbl_harga_product.harga_id = tbl_pembayaran_detail.harga_id');
            $this->db->join('tbl_product', 'tbl_product.product_id = tbl_pembayaran_detail.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            return $this->db->get('tbl_pembayaran_detail');
        }

        function getPemasukan($tanggal_awal, $tanggal_akhir){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);

            $this->db->where('pembayaran_tgl >=', $tanggal_awal);
            $this->db->where('pembayaran_tgl <=', $tanggal_akhir);
           
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran');
        }

        // function getPemasukanharian($hariini){

        //     $this->db->where('pembayaran_tgl', $hariini);
        //     return $this->db->get('tbl_pembayaran');
        // }

        function getMetodeBayar($tanggal_awal, $tanggal_akhir, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('pembayaran_tgl >=', $tanggal_awal);
            $this->db->where('pembayaran_tgl <=', $tanggal_akhir);
          
            $this->db->where($field.'<>', 0);
            return $this->db->get('tbl_pembayaran');
        }

        function getMetodeBayarharian($hariini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('pembayaran_tgl', ".$hariini.");
            $this->db->where($field.'<>', 0);
            return $this->db->get('tbl_pembayaran');
        }

        function getMetodeBayarbulanan($bulanini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->like('pembayaran_tgl', ".$bulanini.", 'after');
            $this->db->where($field.'<>', 0);
            return $this->db->get('tbl_pembayaran');
        }

        function totalCash($tanggal_awal, $tanggal_akhir, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai) as totalna FROM $table 
                                        WHERE (pembayaran_tgl BETWEEN '$tanggal_awal' AND '$tanggal_akhir')  
                                            and $table.perusahaan_id = $perusahaan
                                            ");
        }

        function totalCashharian($hariini, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai) as totalna FROM $table 
                                        WHERE (pembayaran_tgl = '$hariini') and ($table.perusahaan_id = $perusahaan)
                                            ");
        }

        function totalCashbulanan($bulanini, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai) as totalna FROM $table 
                                        WHERE (pembayaran_tgl like'$bulanini%') and  $table.perusahaan_id = $perusahaan
                                            ");
        }

        function totalPemasukan($tanggal_awal, $tanggal_akhir, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai + bayar_debit + bayar_ewallet + bayar_transfer) as totalna FROM $table 
                                        WHERE (pembayaran_tgl BETWEEN '$tanggal_awal' AND '$tanggal_akhir') 
                                            and $table.perusahaan_id = $perusahaan
                                        ");
        }

        function totalPemasukanharian($hariini, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai + bayar_debit + bayar_ewallet + bayar_transfer) as totalna FROM $table 
                                        WHERE pembayaran_tgl = '$hariini' and $table.perusahaan_id = $perusahaan");
        }

        function totalPemasukanbulanan($bulanini, $table){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT SUM(bayar_tunai + bayar_debit + bayar_ewallet + bayar_transfer) as totalna FROM $table 
                                        WHERE pembayaran_tgl like'$bulanini%' and $table.perusahaan_id = $perusahaan");
        }

        function getProduksi($nospk){
            $this->db->where('nospk', $nospk);
            $this->db->where('status_trx', '2');
            return $this->db->get('tbl_pembayaran_detail');
        }

        function getPemasukanHarian($hariini){
            // $hariini = date('2022-06-04');
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('pembayaran_tgl', $hariini);
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran');
        }

        function getpemasukanbulanan($bulanini){
            // $hariini = date('2022-06-04');
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->like('pembayaran_tgl', $bulanini, 'after');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran');
        }

        function getpajakbulanan($bulanini){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('tbl_pembayaran.perusahaan_id', $perusahaan);
            $this->db->where('tbl_pembayaran.piutang', 0);
            $this->db->like('pembayaran_tgl', $bulanini, 'after');
            $this->db->join('tbl_konsumen', 'tbl_konsumen.konsumen_id = tbl_pembayaran.konsumen_id');
            return $this->db->get('tbl_pembayaran');
        }

        function getpendapatan($bulanini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT * FROM tbl_pembayaran a INNER JOIN tbl_konsumen b on a.konsumen_id = b.konsumen_id 
                                        WHERE $field <> 0 and a.perusahaan_id = $perusahaan and pembayaran_tgl like'$bulanini%' ");
        }

        

        function gettransfer($bulanini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT * FROM tbl_pembayaran a 
                                        INNER JOIN tbl_konsumen b on a.konsumen_id = b.konsumen_id 
                                            INNER JOIN tbl_rekening c on a.rekening_id = c.id
                                                WHERE $field <> 0 and a.perusahaan_id = $perusahaan
                                                    and a.pembayaran_tgl like'$bulanini%'");
        }

        function getbayaredcbulan($bulanini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT * FROM tbl_pembayaran a 
                                        INNER JOIN tbl_konsumen b on a.konsumen_id = b.konsumen_id 
                                            INNER JOIN tbl_mesin_edc c on a.id_edc = c.edc_id
                                                WHERE $field <> 0 and a.perusahaan_id = $perusahaan 
                                                    and pembayaran_tgl like'$bulanini%'");
        }

        function getbayaewalletcbulan($bulanini, $field){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("SELECT * FROM tbl_pembayaran a 
                                        INNER JOIN tbl_konsumen b on a.konsumen_id = b.konsumen_id 
                                            INNER JOIN tbl_ewallet c on a.ewallet_id = c.id
                                                WHERE $field <> 0 and a.perusahaan_id = $perusahaan
                                                    and pembayaran_tgl like'$bulanini%'");
        }

        function pengeluarantotal($cek){
            $perusahaan = $this->session->userdata('perusahaan_id');

            return $this->db->query("SELECT SUM(pengeluaran_jumlah) as total FROM tbl_pengeluaran_harian 
                                        WHERE pengeluaran_tgl like'$cek%' and perusahaan_id = $perusahaan ");
        }

        

        function getpengeluaranharian($hariini){
            $hariini    = date('Y-m-d');
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('pengeluaran_tgl', $hariini);
            $this->db->where('perusahaan_id', $perusahaan);
            $this->db->join('tbl_kategori_pengeluaran', 'tbl_kategori_pengeluaran.id = tbl_pengeluaran_harian.kategori_pengeluaran_id');
            return $this->db->get('tbl_pengeluaran_harian');
        }

        function getpengeluaranbulanan($bulanini, $tahunini){
            $this->db->where('pengeluaran_tahun', $tahunini);
            $this->db->where('pengeluaran_bulan', $bulanini);
            $this->db->join('tbl_kategori_pengeluaran', 'tbl_kategori_pengeluaran.id = tbl_pengeluaran_bulanan.kategori_pengeluaran_id');
            return $this->db->get('tbl_pengeluaran_bulanan');
        }

        function jml_transaksi($user){
            return $this->db->query("SELECT COUNT(id) as jml FROM tbl_pembayaran WHERE kasir_id = '$user'");
        }

        function total_transaksi($user){
            return $this->db->query("SELECT SUM(grand_total) as jml FROM tbl_pembayaran WHERE kasir_id = '$user'");
        }

        function total_trx($nospk){
            return $this->db->query("SELECT 
                SUM(
                    IF(
                        t.temp_panjang != 0 AND t.temp_lebar != 0,
                        t.temp_panjang * t.temp_lebar * t.temp_qty * h.harga_1,
                        t.temp_qty * h.harga_1
                    )
                ) AS total_pemesanan
                FROM tbl_temp_transaksi t
                JOIN tbl_harga_product h ON t.harga_id = h.harga_id
                WHERE t.no_spk = '$nospk' 
            ");
        }

        function get_sub_category($category_id){
            $this->db->where('kat_finishing_id',$category_id);
            return $this->db->get('tbl_product');
        }

        function get_finishing($id){
            $hasil=$this->db->query("SELECT * FROM tbl_harga_product WHERE product_id ='$id'");
            return $hasil->result();
        }

        function get_largeformat($id){
            $hasil=$this->db->query("SELECT * FROM tbl_bahan WHERE kategori_kode ='$id'");
            return $hasil->result();
        }

        function getProduksina(){
            $this->db->join('tbl_product','tbl_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            $this->db->order_by('produksi_id', 'desc');
            return $this->db->get('tbl_produksi');
        }


        function getOPProduksina($op){
            $this->db->join('tbl_product','tbl_product.product_id = tbl_produksi.product_id');
            $this->db->where('tbl_product.step_2', $op);
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            $this->db->order_by('produksi_id', 'desc');
            return $this->db->get('tbl_produksi');
        }

        function getPB(){
            $this->db->where('status_produksi','2');
            $this->db->join('tbl_pembayaran','tbl_pembayaran.nospk = tbl_produksi.nospk');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            $this->db->order_by('produksi_id', 'desc');
            $this->db->group_by('tbl_produksi.nospk');
            return $this->db->get('tbl_produksi');
        }

        function detailProduksina($id){
            $this->db->where('produksi_id', $id);
            //$this->db->join('tbl_harga_product','tbl_harga_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_product','tbl_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            //$this->db->group_by('tbl_produksi.product_id');
            return $this->db->get('tbl_produksi');
        }

        function detailpengambilan($nospk){
            $this->db->where('nospk', $nospk);
            //$this->db->join('tbl_harga_product','tbl_harga_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_product','tbl_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            //$this->db->group_by('tbl_produksi.product_id');
            return $this->db->get('tbl_produksi');
        }

        function detailproduk($id){
            $this->db->where('no_spk', $id);
            //$this->db->join('tbl_harga_product','tbl_harga_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_product','tbl_product.product_id = tbl_produksi.product_id');
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = tbl_product.bahan_id');
            $this->db->join('tbl_operator','tbl_operator.operator_id = tbl_produksi.operator_id');
            //$this->db->group_by('tbl_produksi.product_id');
            return $this->db->get('tbl_produksi');
        }


        function cekproduksi($id){
            $this->db->where('produksi_id', $id);
            return $this->db->get('tbl_produksi');
        }

        function pengeluaran_harian($hariini){
            return $this->db->query("SELECT SUM(pengeluaran_jumlah) as total_pengeluaran 
                                        FROM tbl_pengeluaran_harian 
                                            WHERE pengeluaran_tgl = '$hariini' ");
        }

        function getkonsumen($id){
            
            $this->db->join('tbl_spk', 'tbl_spk.konsumen_id = tbl_konsumen.konsumen_id');
            $this->db->join('tbl_jenis_transaksi','tbl_jenis_transaksi.id_jenis_transaksi = tbl_spk.metode_pesan');
            $this->db->join('tbl_marketplace', 'tbl_marketplace.marketplace_id = tbl_spk.id_marketplace', 'left');
            $this->db->where('tbl_konsumen.konsumen_id', $id);
            return $this->db->get('tbl_konsumen');
        }
        
    }
    
?>