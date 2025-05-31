<?php

use App\Http\Controllers\AgenVoucherController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistribusiMaterialController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PaketInternetController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengembalianMaterialController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function ()
{

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        // 'material' => MaterialController::class
    ]);
    Route::group(["prefix" => "dashboard"], function(){
        Route::get("/", [DashboardController::class, 'index'])->name("dashboard.all");
    });

    Route::group(["prefix" => "dataMaster"], function(){
        //master merek
        Route::get('merek', [MerekController::class, 'index'])->name('datamaster.merek');
        Route::get('merek/getData', [MerekController::class, 'getData'])->name('datamaster.merek.getdata');
        Route::get('merek/create', [MerekController::class, 'create'])->name('datamaster.merek.create');
        Route::post('merek/store', [MerekController::class, 'store'])->name('datamaster.merek.store');
        Route::get('merek/edit/{id}', [MerekController::class, 'edit'])->name('datamaster.merek.edit');
        Route::put('merek/update/{id}', [MerekController::class, 'update'])->name('datamaster.merek.update');
        Route::get('merek/destroy/{id}', [MerekController::class, 'destroy'])->name('datamaster.merek.destroy');
        //master satuan
        Route::get('satuan', [SatuanController::class, 'index'])->name('datamaster.satuan');
        Route::get('satuan/getData', [SatuanController::class, 'getData'])->name('datamaster.satuan.getdata');
        Route::get('satuan/create', [SatuanController::class, 'create'])->name('datamaster.satuan.create');
        Route::post('satuan/store', [SatuanController::class, 'store'])->name('datamaster.satuan.store');
        Route::get('satuan/edit/{id}', [SatuanController::class, 'edit'])->name('datamaster.satuan.edit');
        Route::put('satuan/update/{id}', [SatuanController::class, 'update'])->name('datamaster.satuan.update');
        Route::get('satuan/destroy/{id}', [SatuanController::class, 'destroy'])->name('datamaster.satuan.destroy');
    });
    Route::group(['prefix' => 'wilayah'], function(){
        Route::get('list', [WilayahController::class, 'list'])->name('wilayah.list');
        Route::get('getData', [WilayahController::class, 'getData'])->name('wilayah.getdata');
        Route::get('create', [WilayahController::class, 'create'])->name('wilayah.create');
        Route::post('store', [WilayahController::class, 'store'])->name('wilayah.store');
        Route::get('edit/{id}', [WilayahController::class, 'edit'])->name('wilayah.edit');
        Route::put('update/{id}', [WilayahController::class, 'update'])->name('wilayah.update');
        Route::get('destroy/{id}', [WilayahController::class, 'destroy'])->name('wilayah.destroy');
    });
    Route::group(['prefix' => 'cabang'], function(){
        Route::get('list', [CabangController::class, 'list'])->name('cabang.list');
        Route::get('getData', [CabangController::class, 'getData'])->name('cabang.getdata');
        Route::get('create', [CabangController::class, 'create'])->name('cabang.create');
        Route::post('store', [CabangController::class, 'store'])->name('cabang.store');
        Route::get('edit/{id}', [CabangController::class, 'edit'])->name('cabang.edit');
        Route::put('update/{id}', [CabangController::class, 'update'])->name('cabang.update');
        Route::get('destroy/{id}', [CabangController::class, 'destroy'])->name('cabang.destroy');
    });
    Route::group(["prefix" => "material"], function(){
        Route::get('create', [MaterialController::class, 'create'])->name('material.create');
        Route::post('store', [MaterialController::class, 'store'])->name('material.store');
        Route::get('edit/{id}', [MaterialController::class, 'edit'])->name('material.edit');
        Route::get('show/{id}', [MaterialController::class, 'show'])->name('material.show');
        Route::put('update/{id}', [MaterialController::class, 'update'])->name('material.update');
        Route::get('list', [MaterialController::class, 'index'])->name('material.index');
        Route::get('getData', [MaterialController::class, 'getData'])->name('material.getData');
        Route::get('destroy/{id}', [MaterialController::class, 'destroy'])->name('material.destroy');
        //control stok
        Route::get('kontrol', [MaterialController::class, 'kontrol'])->name('material.kontrol');
        Route::post('getAllData', [MaterialController::class, 'kontrol_get_data_material'])->name('material.kontrol.get_data');
        Route::get('getDetailTransaksi/{gudang}/{material}', [MaterialController::class, 'kontrol_get_detail'])->name('material.kontrol.get_detail_transaksi');
        //pencatian material
        Route::get('searchMaterial', [MaterialController::class, 'searchMaterial'])->name('material.searchMaterial');
    });

    Route::group(["prefix" => "pembelian"], function(){
        //baru
        Route::get("/", [PembelianController::class, 'create'])->name('pembelian.create');
        Route::post('storeHead', [PembelianController::class, 'storeHead'])->name('pembelian.storeHead');
        Route::get('addDetail/{id}', [PembelianController::class, 'addDetail'])->name('pembelian.addDetail');
        Route::get('formAddItems/{nomor}', [PembelianController::class, 'addItems'])->name('pembelian.addItems');
        Route::post('storeItem', [PembelianController::class, 'storeItem'])->name('pembelian.storeItem');
        Route::get('getDataItems', [PembelianController::class, 'getDataItems'])->name('pembelian.getDataItems');
        Route::get('formEditItem/{id}', [PembelianController::class, 'editItem'])->name('pembelian.editItem');
        Route::put('updateItem/{id}', [PembelianController::class, 'updateItem'])->name('pembelian.updateItem');
        Route::get('destroyItem/{id}', [PembelianController::class, 'destroyItem'])->name('pembelian.destroyItem');
        Route::put('finishTrans/{id}', [PembelianController::class, 'finishTrans'])->name('pembelian.finishTrans');
        //daftar
        Route::get('list', [PembelianController::class, 'list'])->name('pembelian.list');
        Route::get('getData', [PembelianController::class, 'getData'])->name('pembelian.getData');
        Route::get('showDetail/{id}', [PembelianController::class, 'show'])->name('pembelian.show');
    });

    //akanet
    Route::group(['prefix' => 'voucher'], function(){
        Route::get('list', [VoucherController::class, 'list'])->name('voucher.list');
        Route::get('getData', [VoucherController::class, 'getData'])->name('voucher.getdata');
        Route::get('create', [VoucherController::class, 'create'])->name('voucher.create');
        Route::post('store', [VoucherController::class, 'store'])->name('voucher.store');
        Route::get('edit/{id}', [VoucherController::class, 'edit'])->name('voucher.edit');
        Route::put('update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::get('destroy/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');

        //distribusi
        Route::get('distribusi', [VoucherController::class, 'distribusi'])->name('voucher.distribusi');
        Route::get('distribusi/load_form/{bulan}/{tahun}/{agen}', [VoucherController::class, 'load_form_pengaturan'])->name('voucher.distribusi.load_form_pengaturan');
        Route::post('distribusi/store', [VoucherController::class, 'distribusi_store'])->name('voucher.distribusi.store');
        //daftar distribusi
        Route::get('listDistribusi', [VoucherController::class, 'distribusi_list'])->name('voucher.distribusi.list');
        Route::post('distribusi/list/getData', [VoucherController::class, 'distribusi_list_get_data'])->name('voucher.distribusi.list.getData');
        Route::get('distribusi/print/{id}', [VoucherController::class, 'distribusi_list_print'])->name('voucher.distribusi.print');
        Route::get('distribusi/edit/{id}', [VoucherController::class, 'distribusi_edit'])->name('voucher.distribusi.edit');
        //penjualan
        Route::get('penjualan', [VoucherController::class, 'penjualan'])->name('voucher.penjualan');
        Route::get('penjualan/load_form/{bulan}/{tahun}/{agen}', [VoucherController::class, 'load_form_data_agen_voucher'])->name('voucher.penjualan.load_form_voucher_agen');
        Route::post('penjualan/store', [VoucherController::class, 'penjualan_store'])->name('voucher.penjualan.store');
        Route::get('penjualan/list', [VoucherController::class, 'penjualan_list'])->name('voucher.penjualan.list');
        Route::post('penjualan/list/getData', [VoucherController::class, 'penjualan_list_getData'])->name('voucher.penjualan.list.getData');
        Route::get('penjualan/detailToPrint/{id}', [VoucherController::class, 'penjualan_detail_to_print'])->name('voucher.penjualan.detailToPrint');
        Route::get('penjualan/print/{id}', [VoucherController::class, 'print_penagihan'])->name('voucher.penjualan.print_tagihan');

    });
    Route::group(['prefix' => 'agen'], function(){
        Route::get('list', [AgenVoucherController::class, 'list'])->name('agen.list');
        Route::get('getData', [AgenVoucherController::class, 'getData'])->name('agen.getdata');
        Route::get('create', [AgenVoucherController::class, 'create'])->name('agen.create');
        Route::post('store', [AgenVoucherController::class, 'store'])->name('agen.store');
        Route::get('edit/{id}', [AgenVoucherController::class, 'edit'])->name('agen.edit');
        Route::put('update/{id}', [AgenVoucherController::class, 'update'])->name('agen.update');
        Route::get('destroy/{id}', [AgenVoucherController::class, 'destroy'])->name('agen.destroy');
    });

    Route::group(['prefix' => 'petugas'], function(){
        Route::get('list', [PetugasController::class, 'list'])->name('petugas.list');
        Route::get('getData', [PetugasController::class, 'getData'])->name('petugas.getdata');
        Route::get('create', [PetugasController::class, 'create'])->name('petugas.create');
        Route::post('store', [PetugasController::class, 'store'])->name('petugas.store');
        Route::get('edit/{id}', [PetugasController::class, 'edit'])->name('petugas.edit');
        Route::put('update/{id}', [PetugasController::class, 'update'])->name('petugas.update');
        Route::get('destroy/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
        Route::get('show/{id}', [PetugasController::class, 'show'])->name('petugas.show');
    });

    Route::group(['prefix' => 'distribusiMaterial'], function(){
        Route::get('list', [DistribusiMaterialController::class, 'list'])->name('distribusiMaterial.list');
        Route::get('getData', [DistribusiMaterialController::class, 'getData'])->name('distribusiMaterial.getdata');

        // Route::get('create', [PetugasController::class, 'create'])->name('distribusiMaterial.create');
        // Route::post('store', [PetugasController::class, 'store'])->name('distribusiMaterial.store');
        // Route::get('edit/{id}', [PetugasController::class, 'edit'])->name('distribusiMaterial.edit');
        // Route::put('update/{id}', [PetugasController::class, 'update'])->name('distribusiMaterial.update');
        // Route::get('destroy/{id}', [PetugasController::class, 'destroy'])->name('distribusiMaterial.destroy');
    });

    Route::group(['prefix' => 'pemakaianMaterial'], function(){

        Route::get('/', [PemakaianController::class, 'index'])->name('pemakaianMaterial.index');
        Route::get('create/{gudang}', [PemakaianController::class, 'create'])->name('pemakaianMaterial.create');
        Route::post('getItem', [PemakaianController::class, 'getItem'])->name('pemakaianMaterial.getItem');
        Route::post('store', [PemakaianController::class, 'store'])->name('pemakaianMaterial.store');

        Route::get('list', [PemakaianController::class, 'list'])->name('pemakaianMaterial.list');
        Route::get('getData', [PemakaianController::class, 'getData'])->name('pemakaianMaterial.getdata');
        Route::get('detail/{id}', [PemakaianController::class, 'detail'])->name('distribusiMaterial.detail');

        // Route::get('edit/{id}', [PetugasController::class, 'edit'])->name('distribusiMaterial.edit');
        // Route::put('update/{id}', [PetugasController::class, 'update'])->name('distribusiMaterial.update');
        // Route::get('destroy/{id}', [PetugasController::class, 'destroy'])->name('distribusiMaterial.destroy');
    });

    Route::group(['prefix' => 'pengembalianMaterial'], function(){
        //baru
        Route::get('/', [PengembalianMaterialController::class, 'index'])->name('pengembalian.material.index');
        Route::get('baru/{gudang}', [PengembalianMaterialController::class, 'baru'])->name('pengembalian.material.baru');
        Route::post('getItem', [PengembalianMaterialController::class, 'getItem'])->name('pengembalian.meterial.getItem');
        Route::post('store', [PengembalianMaterialController::class, 'store'])->name('pengembalian.material.store');

        Route::get('list', [PengembalianMaterialController::class, 'list'])->name('pengembalian.material.list');
        Route::get('getData', [PengembalianMaterialController::class, 'getData'])->name('pengembalian.material.getdata');
        Route::get('detail/{id}', [PengembalianMaterialController::class, 'detail'])->name('pengembalian.material.detail');
    });

    Route::group(['prefix' => 'keuangan'], function(){
        //kas masuk
        Route::get('kasMasuk', [KeuanganController::class, 'kasMasuk'])->name("keuangan.kasMasuk.daftar");
        Route::post('getDataKasMasuk', [KeuanganController::class, 'getDataKasMasuk'])->name("keuangan.kasMasuk.getData");
        Route::get('kasMasukBaru', [KeuanganController::class, 'kasMasukBaru'])->name("keuangan.kasMasuk.baru");
        Route::post('kasMasukSimpan', [KeuanganController::class, 'kasMasukSimpan'])->name("keuangan.kasMasuk.simpan");
        Route::get('kasMasukEdit/{id}', [KeuanganController::class, 'kasMasukEdit'])->name("keuangan.kasMasuk.edit");
        Route::put('kasMasukUpdate/{id}', [KeuanganController::class, 'kasMasukUpdate'])->name("keuangan.kasMasuk.update");
        Route::get('kasMasukDelete/{id}', [KeuanganController::class, 'kasMasukDelete'])->name('keuangan.kasMasuk.delete');
        //kas keluar
        Route::get('kasKeluar', [KeuanganController::class, 'kasKeluar'])->name("keuangan.kasKeluar.daftar");
        Route::post('getDataKasKeluar', [KeuanganController::class, 'getDataKasKeluar'])->name("keuangan.kasKeluar.getData");
        Route::get('kasKeluarBaru', [KeuanganController::class, 'kasKeluarBaru'])->name("keuangan.kasKeluar.baru");
        Route::post('kasKeluarSimpan', [KeuanganController::class, 'kasKeluarSimpan'])->name("keuangan.kasKeluar.simpan");
        Route::get('kasKeluarEdit/{id}', [KeuanganController::class, 'kasKeluarEdit'])->name("keuangan.kasKeluar.edit");
        Route::put('kasKeluarUpdate/{id}', [KeuanganController::class, 'kasKeluarUpdate'])->name("keuangan.kasKeluar.update");
        Route::get('kasKeluarDelete/{id}', [KeuanganController::class, 'kasKeluarDelete'])->name('keuangan.kasKeluar.delete');
    });

    Route::group(['prefix' => 'paket_internet'], function(){
        Route::get('/', [PaketInternetController::class, 'index'])->name('paket_internet.index');
        Route::get('getData', [PaketInternetController::class, 'getData'])->name('paket_internet.getData');
        Route::get('create', [PaketInternetController::class, 'create'])->name('paket_internet.create');
        Route::post('store', [PaketInternetController::class, 'store'])->name('paket_internet.store');
        Route::get('edit/{id}', [PaketInternetController::class, 'edit'])->name('paket_internet.edit');
        Route::put('update/{id}', [PaketInternetController::class, 'update'])->name('paket_internet.update');
        Route::get('destroy/{id}', [PaketInternetController::class, 'destroy'])->name('paket_internet.destroy');
    });

    Route::group(['prefix' => 'pelanggan'], function(){
        Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('getData', [PelangganController::class, 'getData'])->name('pelanggan.getData');
        Route::get('create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('store', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('show/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
        Route::get('edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::get('destroy/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
        Route::get('aktivasi/{id}', [PelangganController::class, 'aktivasi'])->name('pelanggan.aktivasi'); //pelanggan lama
        Route::post('simpanAktivasi', [PelangganController::class, 'simpanAktivasi'])->name('pelanggan.simpanAktivasi'); //pelanggan lama
        //proses pemasangan tahap 1 - pengaturan awal
        Route::get('proses/{id}', [PelangganController::class, 'proses'])->name('pelanggan.proses');
        Route::post('storeProses', [PelangganController::class, 'storeProses'])->name('pelanggan.storeProses');
        //monitoring pemasangan paket pelanggan
        Route::get('monitoring', [PelangganController::class, 'monitoring'])->name('pelanggan.monitoring');
        Route::get('getDataMonitoring', [PelangganController::class, 'getDataMonitoring'])->name('pelanggan.getDataMonitoring');
        Route::get('showDetail/{id}', [PelangganController::class, 'showDetail'])->name('pelanggan.showDetail');
        Route::get('showFormAktivasi/{id}', [PelangganController::class, 'showFormAktivasi'])->name('pelanggan.showFormAktivasi');
        Route::post('storeAktivasi', [PelangganController::class, 'storeAktivasi'])->name('pelanggan.storeAktivasi');
        Route::get('showDetaiPelangganFinished/{id}', [PelangganController::class, 'showDetaiPelangganFinished'])->name('pelanggan.showDetaiPelangganFinished');
        //pencarian pelanggan
        Route::get('pembayaran', [PelangganController::class, 'pembayaran'])->name('pelanggan.pembayaran');
        Route::get('getPelanggan', [PelangganController::class, 'getPelanggan'])->name('pelanggan.getPelanggan');
        Route::get('detailPelanggan/{id}', [PelangganController::class, 'detailPelanggan'])->name('pelanggan.detailPelanggan');
        Route::post('storePembayaran', [PelangganController::class, 'storePembayaran'])->name('pelanggan.storePembayaran');
        //daftar pelanggan aktif
        Route::get('daftar', [PelangganController::class, 'daftar'])->name("pelanggan.daftar");
        Route::get('getDataPelanggan', [PelangganController::class, 'getDataPelangganAktif'])->name('pelanggan.getDataPelanggan');
        Route::get('profilPelanggan/{id}', [PelangganController::class, 'profilPelanggan'])->name('pelanggan.profilPelanggan');
        Route::get('editPelanggan/{id}', [PelangganController::class, 'editPelanggan'])->name('pelanggan.editPelanggan');
        Route::get('listPembayaranPelanggan/{id}', [PelangganController::class, 'showPembayaranPelanggan'])->name('pelanggan.listPembayaranPelanggan');
        //pembaharuan data
        Route::get('pembaharuanData/{id}', [PelangganController::class, 'pembaharuanData'])->name('pelanggan.pembaharuanData');
        Route::put('simpanPembaharuanDataPelanggan/{id}', [PelangganController::class, 'simpanPembaharuanDataPelanggan'])->name('pelanggan.simpanPembaharuanDataPelanggan');
        Route::put('simpanPembaharuanDataPelangganAll/{id}', [PelangganController::class, 'simpanPembaharuanDataPelangganAll'])->name('pelanggan.simpanPembaharuanDataPelangganAll');
        Route::get('destroyPelangganAktif/{id}', [PelangganController::class, 'destroyPelangganAktif'])->name('pelanggan.destroyPelangganAktif');
        //tools
        Route::get('importPelanggan', [PelangganController::class, 'importData'])->name('pelanggan.import');
        Route::post('doImportPelanggan', [PelangganController::class, 'doImportData'])->name('pelanggan.doImportPelanggan');
    });

    Route::group(['prefix' => 'service'], function() {
        Route::get('getListMaterial/{idHead}', [ServiceController::class, 'getListMaterialPelanggan'])->name('service.getListMaterialPelanggan');
        Route::get('goFormComplete/{idPelanggan}', [ServiceController::class, 'goFormComplete'])->name('service.goFormComplete');
        Route::post('storeFormComplete', [ServiceController::class, 'storeFormComplete'])->name('service.storeFormComplete');
        Route::get('listTaskCompleted', [ServiceController::class, 'listTaskComplete'])->name("service.listTaskCompleted");
        Route::get('listTaskFinished', [ServiceController::class, 'listTaskFinished'])->name("service.listTaskFinished");

        Route::get('goFormCacelTask/{idPelanggan}', [ServiceController::class, 'goFormCacelTask'])->name('service.goFormCacelTask');
        Route::post('storeCanceledTask', [ServiceController::class, 'storeCanceledTask'])->name('service.storeCanceledTask');
    });
    Route::group(['prefix' => 'asset'], function() {
        Route::get('list', [AssetController::class, 'list'])->name('asset.list');
        Route::get('create', [AssetController::class, 'create'])->name('asset.create');
    });
    Route::group(['prefix' => 'report'], function(){
        Route::get('distribusiVoucher', [ReportController::class, 'distribusiVoucher'])->name('report.distribusiVoucher');
        Route::post('distribusiVoucherGetData', [ReportController::class, 'distribusiVoucherGetData'])->name('report.distribusiVoucher.getdata');
        Route::get('distribusiVoucherDetail/{id}', [ReportController::class, 'distribusiVoucherDetail'])->name('report.distribusiVoucher.detail');
        //penjualan
        Route::get('penjualanVoucher', [ReportController::class, 'penjualanVoucher'])->name('report.penjualanVoucher');
        Route::post('penjualanVoucherGetData', [ReportController::class, 'penjualanVoucherGetData'])->name('report.penjualanVoucher.getdata');
        Route::get('penjualanVoucher/load_data_penjualan/{bulan}/{tahun}/{agen}', [ReportController::class, 'load_data_penjualan_voucher'])->name('report.penjualanVoucher.load_data_penjualan_voucher');
        Route::get('penjualanVoucher/print/{bulan}/{tahun}/{agen}', [ReportController::class, 'penjualanVoucherPrint'])->name('report.penjualanVoucher.print');
        Route::get('showDetailPenjualanVoucher/{id}', [ReportController::class, 'showDetaiPenjualanVoucher'])->name('report.showDetailPenjualanVoucher');
        Route::get('printDetailPenjualanVoucher/{bulan}/{tahun}/{agen}', [ReportController::class, 'printDetailPenjualanVoucher'])->name('report.printDetailPenjualanVoucher');
        //keuangan
        Route::get('keuangan', [ReportController::class, 'keuangan'])->name('report.keuangan');
        Route::post('keuanganGetData', [ReportController::class, 'filterKeuangan'])->name('report.keuangan.getdata');
        Route::get('keuanganPrint/{tanggal_awal}/{tanggal_akhir}', [ReportController::class, 'keuanganPrint'])->name('report.keuangan.print');
        //pelanggan - pembayaran
        Route::get('pembayaranPelanggan', [ReportController::class, 'pembayaranPelanggan'])->name('report.pelanggan.pembayaran');
        Route::post('pembayaranPelangganGetData', [ReportController::class, 'pembayaranPelangganGetData'])->name('report.pelanggan.pembayaran.getdata');
        Route::get('pembayaranPelangganPrint/{bulan}/{tahun}/{wilayah}', [ReportController::class, 'pembayaranPelangganPrint'])->name('report.pelanggan.pembayaran.print');
    });
});
