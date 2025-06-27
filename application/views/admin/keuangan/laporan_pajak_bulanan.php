<div class="app-content d-block">
    <div class="container-fluid py-3">
        <div class="card">
            <div class="card-header">
                <?php $this->load->view('admin/keuangan/menu_pemasukan'); ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-none" id="datatable-details">
                        <thead class="table-dark">
                            <tr>
                                <th width="3%">No</th>
                                <th width="10%">Tanggal Invoice</th>
                                <th width="10%">No Invoice</th>
                                <th width="20%">Nama Konsumen</th>
                                <th width="10%">No HP Konsumen</th>
                                <th width="10%">Email Konsumen</th>
                                <th>Total Transaksi</th>
                                <th>Diskon</th>
                                <th>Ongkir</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1;
                                $total_subtotal   = 0;
                                $total_diskon     = 0;
                                $total_ongkir     = 0;
                                $total_grandtotal = 0;

                                foreach ($lap_pajak as $dt) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= date_indo($dt->pembayaran_tgl) ?></td>
                                <td><?= $dt->nospk ?></td>
                                <td><?= $dt->konsumen_nama ?></td>
                                <td><?= $dt->konsumen_nohp ?></td>
                                <td><?= $dt->konsumen_email ?></td>
                                <td class="text-right">Rp. <?= number_format($dt->sub_total) ?></td>
                                <td class="text-right">Rp. <?= number_format($dt->diskon) ?></td>
                                <td class="text-right">Rp. <?= number_format($dt->ongkir) ?></td>
                                <td class="text-right">Rp. <?= number_format($dt->grand_total) ?></td>
                            </tr>
                            <?php 
                                    $no++;
                                    $total_subtotal   += $dt->sub_total;
                                    $total_diskon     += $dt->diskon;
                                    $total_ongkir     += $dt->ongkir;
                                    $total_grandtotal += $dt->grand_total;
                                }
                            ?>
                            <!--
                            <tr>
                                <th colspan="6" class="text-right"><h4><b>Jumlah</b></h4></th>
                                <th class="text-right"><h4>Rp. <?= number_format($total_subtotal) ?></h4></th>
                                <th class="text-right"><h4>Rp. <?= number_format($total_diskon) ?></h4></th>
                                <th class="text-right"><h4>Rp. <?= number_format($total_ongkir) ?></h4></th>
                                <th class="text-right"><h4>Rp. <?= number_format($total_grandtotal) ?></h4></th>
                            </tr>
                            -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
