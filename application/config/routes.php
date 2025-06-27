<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller']                    = 'website';
$route['404_override']                          = 'Error';
$route['translate_uri_dashes']                  = FALSE;
// $route['bahan']                                 = FALSE;

// Sistem Gudang
$route['gudang/kategori']                       = 'kategori';
$route['gudang/addkategori']                    = 'kategori/formadd';
$route['gudang/updatekategori/(:any)']          = 'kategori/formUpdate/$id';
$route['gudang/subkategori']                    = 'subkategori';
$route['gudang/addsubkategori']                 = 'subkategori/formadd';
$route['gudang/updatesubkategori/(:any)']       = 'subkategori/formUpdate/$id';
$route['gudang/supplier']                       = 'supplier';
$route['gudang/gudang']                         = 'gudang';
$route['gudang/bahan']                          = 'bahan';
$route['gudang/produk-bahan/(:any)']            = 'bahan/product_bahan/$id';
$route['gudang/buat-produk/(:any)']             = 'product/formAdd/$id';
$route['gudang/lihat-produk/(:any)']            = 'product/viewProduct/$id';

$route['gudang/hapus-bahan/(:any)']             = 'bahan/actionDelete/$id';
$route['gudang/product']                        = 'product';
// $route['gudang/detail-product/(:any)']          = 'product/detail/$id';
$route['gudang/formAdd/(:any)']                 = 'product/formAdd/$add/';
$route['gudang/pembelian-barang']               = 'gudang/DaftarPembelian';
$route['gudang/pengiriman-barang']              = 'gudang/DaftarPengambilan';
$route['gudang/tambah-pengiriman']              = 'gudang/PengambilanBahan';
$route['gudang/laporan-stok']                   = 'gudang/gudang_bahan';
$route['gudang/laporan-barang-masuk']           = 'gudang/laporan_barang_masuk';
$route['gudang/laporan-barang-keluar']          = 'gudang/laporan_barang_keluar';
$route['gudang/stok-opname']                    = 'gudang/stokopname';
$route['gudang/barang-masuk']                   = 'gudang/barang_masuk';
$route['gudang/barang-keluar']                   = 'gudang/barang_keluar';

// Sistem Kasir
$route['transaksi/daftar-bahan']                = 'bahan';
$route['transaksi/daftar-product']              = 'product';
$route['transaksi/daftar-konsumen']             = 'konsumen';
$route['transaksi/daftar-transaksi']            = 'transaksi/transaksi_sudahbayar';
$route['transaksi/search_konsumen']             = 'Transaksi/search_konsumen';



$route['transaksi/daftar-produksi']             = 'produksi';
$route['transaksi/daftar-produksi-op']          = 'produksi/op_produksi';
$route['transaksi/daftar-pengambilan-barang']   = 'transaksi/pbarang';
$route['dashboard/halaman-utama']               = 'dashboard/board';

//Website
$route['cek-pesanan']                           = 'website/cekpesanan';

// Karyawan
$route['humanresource/']                        = 'karyawan/index';
$route['karyawan/lihat-akun/(:any)']            = 'karyawan/lihat_akun/$id';
$route['karyawan/edit-akun/(:any)']             = 'karyawan/edit_akun/$id';
$route['karyawan/delete-akun/(:any)']           = 'karyawan/edit_akun/$id';
$route['karyawan/lihat-karyawan/(:any)']        = 'karyawan/lihat_karyawan/$id';
$route['karyawan/edit-karyawan/(:any)']         = 'karyawan/edit_karyawan/$id';
$route['karyawan/delete-karyawan/(:any)']       = 'karyawan/delete_karyawan/$id';
$route['karyawan/tambah-karyawan']              = 'karyawan/tambah_karyawan';
$route['karyawan/daftar-karyawan']              = 'karyawan/karyawan';
$route['karyawan/daftar-akun']                  = 'karyawan/akun';
$route['karyawan/daftar-jabatan-divisi']        = 'karyawan/jabatan';
$route['karyawan/tambah-jabatan']               = 'karyawan/tambah_jabatan';
$route['karyawan/penilaian-kinerja']            = 'karyawan/penilaian_kinerja';
$route['karyawan/absensi-lembur']               = 'karyawan/absen_lembur';
$route['karyawan/absensi-dan-cuti']             = 'karyawan/absen_karyawan';
$route['konsumen/search_ajax']                  = 'konsumen/search_ajax';


// Manufactur
$route['manufaktur/routing/(:any)']             = 'manufaktur/routing/$id';
$route['manufaktur/bom/(:any)']                 = 'manufaktur/bom/$id';
$route['manufaktur/skala-harga/(:any)']         = 'manufaktur/skalaharga/$id';
$route['manufaktur/edit-product/(:any)']        = 'manufaktur/edit_product/$id';
$route['manufaktur/copy-product/(:any)']        = 'manufaktur/copy_product/$id';
$route['manufaktur']                            = 'product';

$route['konsumen/aksi-simpan']                  = 'konsumen/actionAdd';
$route['konsumen/aksi-delete/(:any)']           = 'konsumen/action_delete';
$route['konsumen/aktivitas-konsumen']           = 'konsumen/aktivitas_konsumen';

$route['mesin/aksi-simpan']                     = 'mesin/actionAdd';
$route['mesin/aksi-delete/(:any)']              = 'mesin/action_delete';

//keuangan
$route['keuangan/akun-piutang']                 = 'keuangan/piutang';
$route['keuangan/akun-hutang']                  = 'keuangan/hutang';
$route['keuangan/laporan-periode-keuangan']     = 'keuangan/laporan_periode_keuangan';
$route['keuangan/laporan-keuangan-harian']      = 'keuangan/transaksi_harian';
$route['keuangan/laporan-keuangan-bulanan']     = 'keuangan/transaksi_bulanan';
$route['keuangan/laporan-cash-bulanan']         = 'keuangan/transaksi_cash_bulanan';
$route['keuangan/laporan-transfer-bulanan']     = 'keuangan/transaksi_transfer_bulanan';
$route['keuangan/laporan-edc-bulanan']          = 'keuangan/transaksi_edc_bulanan';
$route['keuangan/laporan-ewallet-bulanan']      = 'keuangan/transaksi_ewallet_bulanan';
$route['keuangan/laporan-pajak-bulanan']        = 'keuangan/laporan_pajak_bulanan';
$route['keuangan/export-laporan-pajak']         = 'keuangan/export_laporan_pajak';

$route['keuangan/laporan-cash-harian']          = 'keuangan/transaksi_cash_harian';
$route['keuangan/laporan-transfer-harian']      = 'keuangan/transaksi_transfer_harian';
$route['keuangan/laporan-edc-harian']           = 'keuangan/transaksi_edc_harian';
$route['keuangan/laporan-ewallet-harian']       = 'keuangan/transaksi_ewallet_harian';
$route['keuangan/buku-besar']                   = 'keuangan/legger';


//bahan
$route['bahan/edit-bahan/(:any)']              = 'bahan/formUpdate/$id';



