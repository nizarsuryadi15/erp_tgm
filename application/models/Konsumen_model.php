<?php 
    class Konsumen_model extends CI_model
    {
        public function get_datatables($request)
        {
            $columns    = ['konsumen_nama', 'konsumen_nohp', 'konsumen_alamat', 'konsumen_email', 'status'];
            $search     = $request['search']['value'];
            $limit      = $request['length'];
            $start      = $request['start'];

            $this->db->from('tbl_konsumen');

            if (!empty($search)) {
                $this->db->group_start();
                foreach ($columns as $col) {
                    $this->db->or_like($col, $search);
                }
                $this->db->group_end();
            }

            $totalFiltered = $this->db->count_all_results('', FALSE);

            $this->db->limit($limit, $start);
            $query = $this->db->get();

            $data = [];
            $no = $start + 1;
            foreach ($query->result() as $row) {
                $data[] = [
                    'no' => $no++,
                    'konsumen_nama' => $row->konsumen_nama,
                    'konsumen_nohp' => $row->konsumen_nohp,
                    'konsumen_alamat' => $row->konsumen_alamat,
                    'konsumen_email' => $row->konsumen_email,
                    'status' => $row->status == 1 ? 'Aktif' : 'Tidak Aktif',
                    'aksi' => '
                        <button class="btn btn-primary btn-sm btn-edit-konsumen"
                                data-toggle="modal" data-target="#modalEditKonsumen"
                                data-id="'.$row->konsumen_id.'"
                                data-nama="'.$row->konsumen_nama.'"
                                data-alamat="'.$row->konsumen_alamat.'"
                                data-nohp="'.$row->konsumen_nohp.'"
                                data-email="'.$row->konsumen_email.'"
                                data-status="'.$row->status.'">
                                <i class="fa fa-pencil"></i></button>
                        <a href="'.base_url("konsumen/aksi_delete/$row->konsumen_id").'" 
                        class="btn btn-danger btn-sm"
                        onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa fa-trash-o"></i></a>'
                ];
            }

            $totalData = $this->db->count_all('tbl_konsumen');

            return [
                "draw" => intval($request['draw']),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data" => $data
            ];
        }


    }