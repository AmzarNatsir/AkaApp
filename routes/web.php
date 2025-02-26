<?php

use App\Http\Controllers\AgenVoucherController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DistribusiMaterialController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
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

// Route::get('/foo', function () {
//     Artisan::call('storage:link');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    // 'material' => MaterialController::class
]);
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
    Route::put('update/{id}', [MaterialController::class, 'update'])->name('material.update');
    Route::get('list', [MaterialController::class, 'index'])->name('material.index');
    Route::get('getData', [MaterialController::class, 'getData'])->name('material.getData');
    Route::get('destroy/{id}', [MaterialController::class, 'destroy'])->name('material.destroy');
    //control stok
    Route::get('kontrol', [MaterialController::class, 'kontrol'])->name('material.kontrol');
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
    //penjualan
    Route::get('penjualan', [VoucherController::class, 'penjualan'])->name('voucher.penjualan');
    Route::get('penjualan/load_form/{bulan}/{tahun}/{agen}', [VoucherController::class, 'load_form_data_agen_voucher'])->name('voucher.penjualan.load_form_voucher_agen');
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

    // Route::get('edit/{id}', [PetugasController::class, 'edit'])->name('distribusiMaterial.edit');
    // Route::put('update/{id}', [PetugasController::class, 'update'])->name('distribusiMaterial.update');
    // Route::get('destroy/{id}', [PetugasController::class, 'destroy'])->name('distribusiMaterial.destroy');
});
