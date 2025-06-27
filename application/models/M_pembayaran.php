<?php 
    class M_pembayaran extends CI_Model
    {
        public function prosesTransaksi($post, $perusahaan, $userid)
        {
            $this->db->trans_start();

            $this->insertPembayaran($post, $perusahaan, $userid);
            $this->insertDetailDanProduksi($post['nospk'], $perusahaan);
            
            if ((int)$post['piutang'] > 0) {
                $this->insertPiutang($post, $perusahaan);
            }
            $this->updateStatusPemesanan($post['nospk']);

            $this->generateQrCode($post['nospk']);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                return ['status' => 'success', 'message' => 'Data Berhasil Dikirim'];
            } else {
                return ['status' => 'error', 'message' => 'Gagal menyimpan data'];
            }
        }

        private function insertPembayaran($post, $perusahaan, $userid)
        {
            $data = [
                'nospk'             => $post['nospk'],
                'konsumen_id'       => $post['konsumen_id'],
                'pembayaran_tgl'    => $post['pembayaran_tgl'],
                'pembayaran_jam'    => $post['pembayaran_jam'],
                'sub_total'         => $post['sub_total'],
                'diskon'            => rupiahToInt($post['diskon']),
                'ongkir'            => rupiahToInt($post['ongkir']),
                'grand_total'       => rupiahToInt($post['grandtotal']),
                'bayar_tunai'       => rupiahToInt($post['bayar_tunai']),
                'bayar_debit'       => rupiahToInt($post['bayar_debit']),
                'id_edc'            => $post['id_edc'],
                'nomor_debit'       => $post['nomor_debit'],
                'bayar_transfer'    => rupiahToInt($post['bayar_transfer']),
                'rekening_id'       => $post['rekening_id'],
                'bayar_ewallet'     => rupiahToInt($post['bayar_ewallet']),
                'ewallet_id'        => $post['ewallet_id'],
                'piutang'           => $post['piutang'],
                'kasir_id'          => $userid,
                'deskprint_id'      => $post['deskprint_id'],
                'id_jenis_transaksi' => $post['id_jenis_transaksi'],
                'marketplace_id'    => $post['marketplace_id'],
                'perusahaan_id'     => $perusahaan,
                'metode'            => $post['metode'],
            ];

            

            $this->db->insert('tbl_pembayaran', $data);

        }

        private function insertDetailDanProduksi($nospk, $perusahaan)
        {
            $details = $this->M_transaksi->getDetailPesan($nospk)->result();

            foreach ($details as $item) {
                $this->db->insert('tbl_pembayaran_detail', [
                    'nospk'         => $item->nospk,
                    'product_id'    => $item->product_id,
                    'qty'           => $item->qty,
                    'diskon'        => $item->diskon,
                    'panjang'       => $item->panjang,
                    'lebar'         => $item->lebar,
                    'mesin_id'      => $item->mesin_id,
                    'finishing_id'  => $item->finishing_id,
                    'harga_id'      => $item->harga_id,
                    'dateline_tgl'  => $item->dateline_tgl,
                    'dateline_jam'  => $item->dateline_jam,
                ]);

                $this->updateStok($item, $perusahaan);
                $this->insertProduksi($item, $perusahaan);
            }
        }

        private function updateStok($item, $perusahaan)
        {
            $product = $this->db->get_where('tbl_product', ['product_id' => $item->product_id])->row_array();

            $this->db->insert('tbl_stok_berkurang', [
                'bahan_id' => $product['bahan_id'],
                'qty' => $item->qty,
                'perusahaan_id' => $perusahaan,
            ]);

            $stok = $this->db->get_where('tbl_stok_bahan', [
                'bahan_id' => $product['bahan_id'],
                'perusahaan_id' => $perusahaan
            ])->row_array();

            $this->db->update('tbl_stok_bahan', [
                'stok_kurang' => $stok['stok_kurang'] + $item->qty
            ], [
                'bahan_id' => $product['bahan_id'],
                'perusahaan_id' => $perusahaan
            ]);
        }

        private function insertProduksi($item, $perusahaan)
        {
            $routing = $this->M_master->routingbykode($item->product_id)->row_array();

            $this->db->insert('tbl_produksi', [
                'product_id' => $item->product_id,
                'harga_id' => $item->harga_id,
                'perusahaan_id' => $perusahaan,
                'operator_id' => $routing['operator_id'],
                'nospk' => $item->nospk,
                'qty' => $item->qty,
                'dateline_tgl' => $item->dateline_tgl,
                'dateline_jam' => $item->dateline_jam,
                'panjang' => $item->panjang,
                'lebar' => $item->lebar,
            ]);
        }

        private function insertPiutang($post, $perusahaan)
        {
            $this->db->insert('tbl_piutang', [
                'nospk' => $post['nospk'],
                'konsumen_id' => $post['konsumen_id'],
                'piutang_tgl' => $post['pembayaran_tgl'],
                'piutang_jam' => $post['pembayaran_jam'],
                'piutang_total' => $post['piutang'],
                'tempo_tgl' => date('Y-m-d', strtotime('+14 days')),
                'piutang_bayar' => 0,
                'piutang_sisa' => $post['piutang'],
                'piutang_status' => 'Belum Lunas',
                'perusahaan_id' => $perusahaan,
            ]);
        }

       

        private function updateStatusPemesanan($nospk)
        {
            $this->M_transaksi->update('tbl_pemesanan', ['status_pembayaran' => '1'], ['nospk' => $nospk]);
        }

        private function generateQrCode($nospk)
        {
            $config = [
                'cacheable' => true,
                'cachedir' => './assets/',
                'errorlog' => './assets/',
                'imagedir' => './assets/qrcode/',
                'quality' => true,
                'size' => '1024',
                'black' => [224, 255, 255],
                'white' => [70, 130, 180],
            ];
            $this->ciqrcode->initialize($config);

            $image_name = $nospk . '.png';
            $params = [
                'data' => "https://tgmprint.com/cekpesanan/spk/" . $nospk,
                'level' => 'H',
                'size' => 10,
                'savename' => FCPATH . $config['imagedir'] . $image_name,
            ];
            $this->ciqrcode->generate($params);
        }
}
