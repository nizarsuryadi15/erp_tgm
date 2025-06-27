<?php 
    class M_master extends CI_model
    {
        public function get_menu_with_submenu() {
        $this->db->select('menu.id as menu_id, menu.alias, menu.icon, submenu.nama_submenu, submenu.link_submenu');
        $this->db->from('menu');
        $this->db->join('submenu', 'submenu.menu_id = menu.id');
        // $this->db->where('submenu.is_active', 1);
        $this->db->order_by('menu.id, submenu.id');
        $query = $this->db->get();
        $results = $query->result();

        // Struktur nested
        $menus = [];
        foreach ($results as $row) {
            if (!isset($menus[$row->menu_id])) {
                $menus[$row->menu_id] = (object)[
                    'alias' => $row->alias,
                    'icon' => $row->icon,
                    'submenu' => []
                ];
            }
            $menus[$row->menu_id]->submenu[] = [
                'title' => $row->title,
                'url' => $row->url,
                'icon' => $row->sub_icon
            ];
        }

        return $menus;
        }

        public function search_by_keyword($keyword)
        {
            $this->db->select('konsumen_id, konsumen_nama');
            $this->db->like('konsumen_nama', $keyword);
            $this->db->limit(10);
            $query = $this->db->get('tbl_konsumen');

            log_message('debug', 'QUERY: ' . $this->db->last_query()); // <-- tambahkan ini

            return $query->result();
        }



        public function search_product($keyword) {
            $this->db->select('product_id, product_nama');
            $this->db->like('product_nama', $keyword);
            $query = $this->db->get('tbl_product'); // sesuaikan nama tabel
            return $query->result();
        }


        public function getprodukbyid($id){
            return $this->db->get_where('tbl_product', array('product_id' => $id));
        }
        
        public function delete_product($id){
            return $this->db->delete('tbl_product', ['product_id' => $id]);
        }

        public function delete_skala_harga($product_id){
            return $this->db->delete('tbl_harga_product', ['product_id' => $product_id]);
        }

        public function delete_routing($product_id){
            return $this->db->delete('routing', ['product_id' => $product_id]);
        }



        function getprodukbykode($kode){
            $this->db->where('tbl_product.product_id', $kode);
            $this->db->join('tbl_subkategori', 'tbl_subkategori.subkategori_id = tbl_product.subkategori_id');
            $this->db->join('tbl_kategori', 'tbl_product.kategori_id = tbl_kategori.kategori_id');
            $this->db->join('tbl_bahan', 'tbl_product.bahan_id = tbl_bahan.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_product.satuan_id = tbl_satuan.satuan_id');
            $this->db->join('tbl_type', 'tbl_type.tipe_id = tbl_product.tipe_id');
            $this->db->order_by('tbl_product.kategori_id','asc');
            $this->db->order_by('tbl_product.subkategori_id','asc');
            return $this->db->get('tbl_product');
        }

        function getmenu($menu){
            $this->db->where('menu.link', $menu);
            $this->db->join('menu', 'menu.id = submenu.id_menu');
            return $this->db->get('submenu');
        }

        function aksi_edit($tbl, $data, $where){
            $this->db->where($where);
            return $this->db->update($table, $data);
        }

        function getproductorderby($orderby){
            $this->db->order_by($orderby, 'asc');
            return $this->db->get('tbl_product');
        }

        function getrouting(){
            $this->db->query("SELECT * FROM `routing` a inner join tbl_product b 
                                on a.product_id=b.product_id inner join tbl_mesin c 
                                    on a.mesin_id = c.mesin_id");
            return $this->db->get();
        }

        function getbom($orderby){
            $this->db->join('tbl_product', 'tbl_product.product_id = bom_lines.product_id');
            $this->db->order_by($orderby, 'asc');
            return $this->db->get('bom_lines');
        }

        function getbomkode($orderby, $kode){
            $this->db->where('tbl_product.product_id', $kode);
            $this->db->join('tbl_bahan', 'tbl_bahan.bahan_id = bom_lines.bahan_id');
            $this->db->join('tbl_product', 'tbl_product.product_id = bom_lines.product_id');
            $this->db->join('tbl_satuan', 'tbl_satuan.satuan_id = bom_lines.satuan_id');
            return $this->db->get('bom_lines');
        }

        function getbombykode($kode){
            $this->db->where('tbl_product.product_id', $kode);
            $this->db->join('tbl_product', 'tbl_product.product_id = bom_lines.product_id');
            $this->db->order_by('bom_line_id','asc');
            $this->db->limit('1');
            return $this->db->get('bom_lines');
        }

        function getroutingkode($orderby, $kode){
            $this->db->where('tbl_product.product_id', $kode);
            $this->db->join('tbl_product', 'tbl_product.product_id = routing.product_id');
            $this->db->order_by($orderby, 'asc');
            return $this->db->get('routing');
        }

        function routingbykode($kode){
            $this->db->where('tbl_product.product_id', $kode);
            $this->db->join('tbl_operator', 'tbl_operator.operator_id = routing.operator_id');
            $this->db->join('tbl_product', 'tbl_product.product_id = routing.product_id');
            return $this->db->get('routing');
        }


        function getroutingbykode($kode){
            return $this->db->get_where('routing', array('routing_id'=>$kode));
        }


        function getworkcenters(){
            return $this->db->get('workcenters');
        }

        function steprouting($kode){
            
            $this->db->where('routing_steps.routing_id', $kode);
            $this->db->join('workcenters', 'workcenters.workcenter_id = routing_steps.workcenter_id');
            $this->db->join('routing', 'routing.routing_id = routing_steps.routing_id');
            return $this->db->get('routing_steps');
        }

        function get_karyawan(){
            $this->db->select('k.*, j.nama_jabatan, j.gaji_pokok');
            $this->db->from('tbl_karyawan k');
            $this->db->join('tbl_jabatan j', 'j.jabatan_id = k.jabatan_id','left');
            return $this->db->get();
        }

        function get_lembur(){
            // $karyawan           = $this->session->userdata('karyawan_id');

            $this->db->select('*');
            $this->db->from('tbl_karyawan a');
            $this->db->join('tbl_lembur b', 'a.karyawan_id = b.karyawan_id');
            // $this->db->where('a.karyawan_id', $karyawan);

            // Filter bulan dan tahun ini (pakai fungsi MySQL MONTH() dan YEAR())
            $this->db->where('MONTH(b.tanggal)', date('m'));
            $this->db->where('YEAR(b.tanggal)', date('Y'));
            return $this->db->get();

        }


        function karyawan_lembur(){
            $karyawan           = $this->session->userdata('karyawan_id');

            $this->db->select('*');
            $this->db->from('tbl_karyawan a');
            $this->db->join('tbl_lembur b', 'a.karyawan_id = b.karyawan_id');
            $this->db->where('a.karyawan_id', $karyawan);

            // Filter bulan dan tahun ini (pakai fungsi MySQL MONTH() dan YEAR())
            $this->db->where('MONTH(b.tanggal)', date('m'));
            $this->db->where('YEAR(b.tanggal)', date('Y'));
            return $this->db->get();

        }

        function jml_jam_lembur(){
            $karyawan           = $this->session->userdata('karyawan_id');

            $this->db->select('a.*, ROUND(SUM(TIME_TO_SEC(TIMEDIFF(jam_selesai, jam_mulai)))/3600, 2) AS total_jam_lembur');
            $this->db->from('tbl_karyawan a');
            $this->db->join('tbl_lembur b', 'a.karyawan_id = b.karyawan_id');
            $this->db->where('a.karyawan_id', $karyawan);
            $this->db->where('b.status', 'disetujui');

            // Filter bulan dan tahun ini (pakai fungsi MySQL MONTH() dan YEAR())
            $this->db->where('MONTH(b.tanggal)', date('m'));
            $this->db->where('YEAR(b.tanggal)', date('Y'));
            $this->db->group_by('a.karyawan_id');

            return $this->db->get();
        }

        function jml_spk($user){
            return $this->db->query("select count('deskprint_id') as jum from tbl_pembayaran WHERE deskprint_id = $user");
        }

        function get_karyawan_jabatan($jabatan){
            
            $this->db->select('k.*, j.nama_jabatan');
            $this->db->from('tbl_karyawan k');
            $this->db->join('tbl_jabatan j', 'j.jabatan_id = k.jabatan_id', 'left');
            $this->db->join('users u', 'k.karyawan_id = u.karyawan_id');
            $this->db->where('k.jabatan_id', $jabatan);
            return $this->db->get();
        }

        public function get_by_id($id)
        {
            return $this->db->get_where('tbl_karyawan', ['karyawan_id' => $id])->row();
        }

        public function update($id, $data)
        {
            $this->db->where('karyawan_id', $id);
            return $this->db->update('tbl_karyawan', $data);
        }

        public function get_all_jabatan()
        {
            return $this->db->get('tbl_jabatan')->result();
        }
        function getkaryawan($table, $order){

            $this->db->join('tbl_divisi','tbl_divisi.divisi_id=tbl_karyawan.divisi_id');
            $this->db->order_by($order, 'ASC');
            return $this->db->get($table);
        }

        function getTampil($table, $order){
            
            // $this->db->join('tbl_perusahaan', 'tbl_perusahaan.id_perusahaan ='.$table.'.perusahaan_id');
            // $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id ='.$table.'.karyawan_id');
            $this->db->join('user_roles', 'user_roles.user_id ='.$table.'.user_id');
            $this->db->join('roles', 'roles.role_id =user_roles.role_id');
            return $this->db->get($table);
        }

        function getUser(){
            $this->db->join('tbl_perusahaan','tbl_perusahaan.id_perusahaan = users.perusahaan_id');
            $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id = users.karyawan_id','left');
            $this->db->join('roles', 'roles.role_id = users.role_id','left');
            $this->db->order_by('roles.no_urut', 'asc');
            return $this->db->get('users');
        }

        function tampilData($table, $order){
            $this->db->where('status', '1');
            $this->db->order_by($order, 'DESC');
            
            return $this->db->get($table);
        }

        public function addData($table, $data) 
        {
            return $this->db->insert($table, $data);
        }

        function updateData($table, $id, $update){
            $this->db->where($id);
            return $this->db->update($table, $update);
        }

        function joinKategori($table1, $table2, $order){
           
            $this->db->join($table2, $table1.'.kategori_id = '.$table2.'.kategori_id');
            $this->db->order_by($order, 'ASC');
            return $this->db->get($table1);
        }

        function getDatanonorder($table){
            return $this->db->get($table);
        }

        function getDataBahan(){

            $this->db->join('tbl_satuan as satuan_produk', 'tbl_bahan.satuan_id = satuan_produk.satuan_id');
            $this->db->join('tbl_satuan as satuan_gudang', 'tbl_bahan.satuan_gudang = satuan_gudang.satuan_id', 'left');
            $this->db->select('tbl_bahan.*, satuan_produk.satuan_nama as satuan_nama, satuan_gudang.satuan_nama as satuan_gudang_nama');
            $this->db->order_by('bahan_id','asc');
            return $this->db->get('tbl_bahan');
        }

        
        function getDataProduct(){
            // $this->db->where('tbl_product.perusahaan_id', $this->session->userdata('perusahaan_id'));
            $this->db->join('tbl_subkategori', 'tbl_subkategori.subkategori_id = tbl_product.subkategori_id');
            $this->db->join('tbl_kategori', 'tbl_product.kategori_id = tbl_kategori.kategori_id');
            $this->db->join('tbl_bahan', 'tbl_product.bahan_id = tbl_bahan.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_product.satuan_id = tbl_satuan.satuan_id');
            $this->db->join('tbl_type', 'tbl_type.tipe_id = tbl_product.tipe_id');
            $this->db->join('tbl_side','tbl_side.side_id = tbl_product.side_id','left');
            $this->db->order_by('tbl_bahan.barcode','asc');
            $this->db->order_by('tbl_product.kategori_id','asc');
            $this->db->order_by('tbl_product.subkategori_id','asc');
            return $this->db->get('tbl_product');
        }

        function getProduct($kode){
            $this->db->where('tbl_product.product_id', $kode);
            // $this->db->join('tbl_subkategori', 'tbl_subkategori.subkategori_id = tbl_product.subkategori_id');
            // $this->db->join('tbl_kategori', 'tbl_product.kategori_id = tbl_kategori.kategori_id');
            // $this->db->join('tbl_bahan', 'tbl_product.bahan_id = tbl_bahan.bahan_id');
            // $this->db->join('tbl_satuan', 'tbl_product.satuan_id = tbl_satuan.satuan_id');
            // $this->db->join('tbl_waktu', 'tbl_waktu.waktu_id = tbl_product.satuan_waktu_id');
            return $this->db->get('tbl_product');
        }

        function get_product_by_id($id){
            $this->db->where('product_id', $id);
            return $this->db->get('tbl_product');
        }

        function get_produk_by_bahan($id){
            $this->db->where('tbl_product.bahan_id', $id);
            // $this->db->join('tbl_subkategori', 'tbl_subkategori.subkategori_id = tbl_product.subkategori_id');
            // $this->db->join('tbl_kategori', 'tbl_product.kategori_id = tbl_kategori.kategori_id');
            $this->db->join('tbl_bahan', 'tbl_product.bahan_id = tbl_bahan.bahan_id');
            $this->db->join('tbl_satuan', 'tbl_product.satuan_id = tbl_satuan.satuan_id');
            // $this->db->join('tbl_type', 'tbl_type.tipe_id = tbl_product.tipe_id');
            return $this->db->get('tbl_product');
        }

        function getHarga($id){
            $this->db->join('tbl_product','tbl_product.product_id = tbl_harga_product.product_id');
            $this->db->join('tbl_satuan', 'tbl_satuan.satuan_id = tbl_product.satuan_id');
            // $this->db->join('tbl_range','tbl_range.range_id = tbl_harga_product.range_id');
            $this->db->where('tbl_harga_product.product_id', $id);
            return $this->db->get('tbl_harga_product');
        }


        function get_kategori(){
            $query  =   $this->db->query("SELECT * FROM tbl_kategori");
            return array_column($query->result_array(), 'kategori_id'); 
        }
    
        function get_subkategori(){
            $hasil=$this->db->query("SELECT * FROM tbl_subkategori");
            return $hasil->result();
        }

        function getUrutan($table, $order){
            $this->db->order_by($order, 'DESC');
            return $this->db->get($table);
        }

        function updateHarga($table, $id, $update){
            $this->db->where($id);
            return $this->db->update($table, $update);
        }

        function cekjml($table, $field, $id){
            $this->db->where($field, $id);
            return $this->db->get($table);
        }

       



        // public function getUser(){
        //     $user = $this->session->userdata('id');
        //     $this->db->where('user_id', $user); 
        //     $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id = tbl_user.karyawan_id');
        //     $this->db->join('tbl_divisi', 'tbl_divisi.divisi_id = tbl_user.divisi_id');
        //     return $this->db->get('tbl_user');
        // }

        public function getAllUser(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            return $this->db->query("select * from user_roles a inner join users b on a.user_id=b.user_id inner join roles c on a.role_id = c.role_id
            ");
            
        }

        public function getdeskprint(){
            $perusahaan = $this->session->userdata('perusahaan_id');
            $this->db->where('perusahaan_id', $perusahaan);
            $this->db->where('tbl_user.divisi_id', '2');
            // $this->db->join('tbl_karyawan', 'tbl_karyawan.karyawan_id = tbl_user.karyawan_id');
            // $this->db->join('tbl_divisi', 'tbl_divisi.divisi_id = tbl_user.divisi_id');
            return $this->db->get('tbl_user');
        }

        public function getPerusahaan(){
            return $this->db->get('tbl_perusahaan');
        }

       

        public function cekProduct($subkategori, $bahanid, $satuan, $perusahaan){
            $this->db->where('perusahaan_id', $perusahaan);
            $this->db->where('subkategori_id', $subkategori);
            $this->db->where('bahan_id', $bahanid);
            $this->db->where('satuan_id', $satuan);
            return $this->db->get('tbl_product');
        }

        function jml_detail($product){
            $this->db->where('product_id', $product);
            return $this->db->get('tbl_harga_product');
        }

        function jml_routing($product){
            $this->db->where('product_id', $product);
            return $this->db->get('routing');
        }

        function jml_bom($product){
            $this->db->where('product_id', $product);
            return $this->db->get('bom_lines');
        }
       
    }
    
?>